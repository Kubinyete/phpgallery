<?php
/**
 * Camada de processamento e consulta do envio de uma imagem ou requisição da página de envio
 */

namespace App\Models;

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

					$dal = new DalImagem($this->conexao);
					$dal->criarImagem($novaImagem);

					if ($novaImagem->getId() <= 0) {
						throw new Exception(Config::obter("MvcErrors.Enviar.DESCONHECIDO"));
					} else {
						if (!move_uploaded_file($imagem["tmp_name"], dirname(dirname(__DIR__)).DIRECTORY_SEPARATOR.$novaImagem->getImagemUrl())) {
							$dal->deletarImagem($novaImagem->getId());
							throw new Exception(Config::obter("MvcErrors.Enviar.DESCONHECIDO"));
						} else {
							return [
								"retorno" => "imagem",
								"retorno_obj" => $novaImagem
							];
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