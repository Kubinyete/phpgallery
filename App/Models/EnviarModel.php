<?php
/**
 * Camada de processamento e consulta do envio de uma imagem ou requisição da página de envio
 */

namespace App\Models;

const MIN_MAX_LARGURA = 256;
const MIN_MAX_ALTURA = 256;
const MIN_UTILIZAR_RESAMPLING = true;
const MIN_SAIDA = IMAGETYPE_JPEG;
const MIN_SAIDA_QUALIDADE = 100;

use App\Models\Model;
use App\Views\EnviarView;
use App\Objects\Imagem;
use App\Database\DalImagem;
use Config\Config;
use Exception;

class EnviarModel extends Model {
	// $conexao
	
	public function index($usuarioLogado, $erroMensagem="") {
		return [
			"retorno" => "view",
			"retorno_obj" => new EnviarView($usuarioLogado, $erroMensagem)
		];
	}

	public function enviar($usuarioLogado, $imagem, $imagemTitulo, $imagemDescricao, $imagemPrivada) {
		$erroMensagem = "";
		$erro = false;
		$imgExtensao = "";

		try {
			if ($usuarioLogado === null) {
				throw new Exception(Config::obter("MvcErrors.Enviar.NECESSITA_LOGAR"));
			} else {
				// Ocorreu um erro
				if ($imagem["tmp_name"] === "") {
					// Que erro?
					if ($imagem["name"] === "") {
						throw new Exception(Config::obter("MvcErrors.Enviar.NENHUMA_IMAGEM"));
					} else if ($imagem["error"] == 1) {
						throw new Exception(Config::obter("MvcErrors.Enviar.EXCEDE_TAMANHO_LIMITE"));
					} else {
						throw new Exception(Config::obter("MvcErrors.Enviar.DESCONHECIDO"));
					}
				}

				$info = getimagesize($imagem["tmp_name"]);

				// Se nem recebemos informações do tipo (formato)
				// o arquivo enviado então não é uma imagem
				if (!$info[2]) {
					throw new Exception(Config::obter("MvcErrors.Enviar.FORMATO_NAO_SUPORTADO"));
				} else {
					switch ($info[2]) {
						case IMAGETYPE_GIF:
							$imgExtensao = "gif";
							break;
						case IMAGETYPE_PNG:
							$imgExtensao = "png";
							break;
						case IMAGETYPE_JPEG:
							$imgExtensao = "jpg";
							break;
						default:
							throw new Exception(Config::obter("MvcErrors.Enviar.FORMATO_NAO_SUPORTADO"));
							break;
					}

					$imagemTitulo = trim($imagemTitulo);
					$imagemDescricao = trim($imagemDescricao);

					if (strlen($imagemTitulo) > Config::obter("Imagens.max_tamanho_titulo")) {
						throw new Exception(Config::obter("MvcErrors.Enviar.TITULO_EXCEDE_LIMITE"));
					} else if (strlen($imagemDescricao) > Config::obter("Imagens.max_tamanho_descricao")) {
						throw new Exception(Config::obter("MvcErrors.Enviar.DESCRICAO_EXCEDE_LIMITE"));
					}

					$novaImagem = new Imagem(
						0,
						date("Y-m-d H:i:s"),
						$usuarioLogado->getId(),
						$imagemTitulo,
						$imagemDescricao,
						$imgExtensao,
						$imagemPrivada,
						$info[0],	// width - largura
						$info[1]	// height - altura
					);

					$dal = new DalImagem($this->getConexao());
					$dal->criarImagem($novaImagem);

					/**
					 * TODO:
					 * Manipular isto de um maneira mais eficiente,
					 * corremos o risco de deletar uma imagem anterior da adicionada (?)
					 */

					if ($novaImagem->getId() <= 0) {
						throw new Exception(Config::obter("MvcErrors.Enviar.DESCONHECIDO"));
					} else {
						if (!@move_uploaded_file($imagem["tmp_name"], dirname(dirname(__DIR__)).(($novaImagem->getImagemUrl()[0]==='/') ? '' : DIRECTORY_SEPARATOR).$novaImagem->getImagemUrl())) {
							$dal->deletarImagem($novaImagem->getId());
							throw new Exception(Config::obter("MvcErrors.Enviar.DESCONHECIDO"));
						} else {
							// Vamos gerar a miniatura agora mesmo
							
							$imagemDados = file_get_contents(dirname(dirname(__DIR__)).DIRECTORY_SEPARATOR.$novaImagem->getImagemUrl());

							if (!$imagemDados) {
								throw new Exception(Config::obter("MvcErrors.Enviar.MIN_IMAGEM_FONTE_NAO_ENCONTRADA"));
							} else {
								$imagemObj = imagecreatefromstring($imagemDados);

								$largura = $info[0];
								$altura = $info[1];
								$novaLargura = $largura;
								$novaAltura = $altura;

								if ($novaAltura > MIN_MAX_ALTURA) {
									$novaAltura = MIN_MAX_ALTURA;
									$novaLargura = $largura / $altura * $novaAltura;
								}
								if ($novaLargura > MIN_MAX_LARGURA) {
									$novaLargura = MIN_MAX_LARGURA;
									$novaAltura = $novaLargura / ($largura / $altura);
								}

								$miniaturaObj = imagecreatetruecolor($novaLargura, $novaAltura);

								if (MIN_UTILIZAR_RESAMPLING) {
									imagecopyresampled($miniaturaObj, $imagemObj, 0, 0, 0, 0, $novaLargura, $novaAltura, $largura, $altura);
								} else {
									imagecopyresized($miniaturaObj, $imagemObj, 0, 0, 0, 0, $novaLargura, $novaAltura, $largura, $altura);
								}

								$caminhoFinal = dirname(dirname(__DIR__)).DIRECTORY_SEPARATOR.$novaImagem->getMiniaturaUrl();

								switch (MIN_SAIDA) {
									case IMAGETYPE_PNG:
										imagepng($miniaturaObj, $caminhoFinal);
										break;
									case IMAGETYPE_GIF:
										imagegif($miniaturaObj, $caminhoFinal);
										break;
									case IMAGETYPE_JPEG:
									default:
										imagejpeg($miniaturaObj, $caminhoFinal, MIN_SAIDA_QUALIDADE);
										break;
								}

								return [
									"retorno" => "imagem",
									"retorno_obj" => $novaImagem
								];
							}
						}
					}
				}
			}
		} catch (Exception $e) {
			$msg = Config::obter("MvcErrors.Enviar.Definicoes")[$e->getMessage()];
			
			if ($msg) {
				$erroMensagem .= $msg;
			}
			
			$erro = true;
		} finally {
			if ($erro) {
				return $this->index($usuarioLogado, $erroMensagem);
			}
		}
	}
}

?>