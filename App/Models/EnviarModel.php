<?php
/**
 * Camada de processamento e consulta do envio de uma imagem ou requisição da página de envio
 */

namespace App\Models;

use App\Models\Model;
use App\Views\EnviarView;
use App\MvcErrors\EnviarErro;
use App\Objects\Imagem;
use Config\ImagemConfig;
use App\Database\DalImagem;
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
				throw new Exception(EnviarErro::USUARIO_NAO_LOGADO);
			} else {
				// Ocorreu um erro
				if ($imagem["tmp_name"] === "") {
					// Que erro?
					if ($imagem["name"] === "") {
						throw new Exception(EnviarErro::NENHUMA_IMAGEM);
					} else if ($imagem["error"] == 1) {
						throw new Exception(EnviarErro::IMAGEM_EXCEDE_LIMITE);
					} else {
						throw new Exception(EnviarErro::DESCONHECIDO);
					}
				}

				$info = getimagesize($imagem["tmp_name"]);

				// Se nem recebemos informações do tipo (formato)
				// o arquivo enviado então não é uma imagem
				if (!$info[2]) {
					throw new Exception(EnviarErro::IMAGEM_FORMATO_NAO_SUPORTADO);
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
							throw new Exception(EnviarErro::IMAGEM_FORMATO_NAO_SUPORTADO);
							break;
					}

					$novaImagem = new Imagem(
						0,
						date("Y-m-d H:i:s"),
						$usuarioLogado->getId(),
						trim($imagemTitulo),
						trim($imagemDescricao),
						$imgExtensao,
						$imagemPrivada
					);

					$dal = new DalImagem($this->conexao);
					$novaImagem->setId($dal->criarImagem($novaImagem));

					if ($novaImagem->getId() <= 0) {
						throw new Exception(EnviarErro::DESCONHECIDO);
					} else {
						if (!move_uploaded_file($imagem["tmp_name"], dirname(dirname(__DIR__)).DIRECTORY_SEPARATOR.$novaImagem->getImagemUrl())) {
							$dal->deletarImagem($novaImagem->getId());
							throw new Exception(EnviarErro::DESCONHECIDO);
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
			$msg = EnviarErro::DEFINICOES[$e->getMessage()];
			
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