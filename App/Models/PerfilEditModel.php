<?php
/**
 * Representará a nossa camada Model da estruturação MVC
 * obtêm dados necessários para mostrar uma página de edição de perfil do usuário
 */

namespace App\Models;

use App\Models\Model;
use App\Views\PerfilEditView;
use App\Views\NotFoundView;
use App\Database\DalUsuario;
use App\Database\DalImagem;
use Config\Config;
use Exception;

class PerfilEditModel extends Model {
	// $conexao
	
	public function index($usuarioLogado, $erro='') {
		$dal = new DalImagem($this->getConexao());
		$imagens = $dal->listarImagensUsuario($usuarioLogado->getId());
		return new PerfilEditView($usuarioLogado, $erro, $imagens);
	}

	public function modificar($usuarioLogado, $imagem, $descricao, $imagemFundo) {
		$descricao = trim($descricao);
		$imagemFundo = intval($imagemFundo);
		$atualizar = false;
		$imagemErro = '';

		try {
			if ($descricao !== $usuarioLogado->getDescricao()) {
				if (strlen($descricao) > Config::obter('Usuarios.max_tamanho_descricao')) {
					throw new Exception(Config::obter('MvcErrors.PerfilEdit.DESCRICAO_EXCEDE_LIMITE'));
				}

				$usuarioLogado->setDescricao($descricao);
				$atualizar = true;
			}

			if ($imagem !== null && strlen($imagem["name"]) > 0) {
				if (file_exists($imagem["tmp_name"])) {
					// Se o arquivo existe temporáriamente
					
					// Size em bytes, kilobytes em Config
					if ($imagem["size"] > Config::obter('Usuarios.imagem_limite_kilobytes') * 1024) {
						throw new Exception(Config::obter('MvcErrors.PerfilEdit.IMAGEM_EXCEDE_TAMANHO_LIMITE'));
					}

					$info = getimagesize($imagem["tmp_name"]);

					if (!$info || $info[2] !== IMAGETYPE_JPEG) {
						throw new Exception(Config::obter('MvcErrors.PerfilEdit.IMAGEM_FORMATO_INVALIDO'));
					}

					/**
					 * TODO: 
					 * (Fazer isso quando nosso processador de miniaturas for substituido por um objeto)
					 * Se o tamanho da imagem de perfil ultrapassar nosso limite de nxn
					 * vamos utilizar nosso objeto de miniaturas para processar uma imagem menor e utilizá-la 
					 * como imagem de perfil do usuário
					 */
					
					if ($info[0] < Config::obter('Usuarios.imagem_perfil_min_largura') || $info[0] > Config::obter('Usuarios.imagem_perfil_max_largura') || $info[1] < Config::obter('Usuarios.imagem_perfil_min_altura') || $info[1] > Config::obter('Usuarios.imagem_perfil_max_altura')) {
						throw new Exception(Config::obter('MvcErrors.PerfilEdit.IMAGEM_DIMENSOES_INVALIDAS'));
					}

					// Se nada de errado aconteceu
					// vamos mover o arquivo
					
					$ok = @move_uploaded_file($imagem['tmp_name'], dirname(dirname(__DIR__)) . ( (Config::obter('Usuarios.caminho_imagens_perfil')[0] === '/') ? '' : DIRECTORY_SEPARATOR ) . Config::obter('Usuarios.caminho_imagens_perfil') . hash(Config::obter('Usuarios.hash_nome_imagem_perfil'), $usuarioLogado->getId()) . '.' . Config::obter('Usuarios.imagem_perfil_extensao'));

					if (!$ok) {
						throw new Exception(Config::obter('MvcErrors.PerfilEdit.DESCONHECIDO'));
					}

					if (!$usuarioLogado->getTemImagemPerfil()) {
						$usuarioLogado->setTemImagemPerfil(true);
						if (!$atualizar) {
							$atualizar = true;
						}
					}
				} else {
					// Se o número do erro for igual a 1, o tamanho do arquivo ultrapassou o limite
					if ($imagem["error"] == 1) {
						throw new Exception(Config::obter('MvcErrors.PerfilEdit.EXCEDE_TAMANHO_LIMITE'));
					} else {
						throw new Exception(Config::obter('MvcErrors.PerfilEdit.DESCONHECIDO'));
					}
				}
			}

			if ($imagemFundo > 0) {
				$dal = new DalImagem($this->getConexao());
				$localImagemFundo = $dal->obterImagem($imagemFundo);
				
				if ($localImagemFundo === null) {
					throw new Exception(Config::obter('MvcErrors.PerfilEdit.IMAGEM_FUNDO_INEXISTENTE'));
				} else if ($localImagemFundo->getUsuarioId() !== $usuarioLogado->getId()) {
					throw new Exception(Config::obter('MvcErrors.PerfilEdit.IMAGEM_FUNDO_OUTRO_AUTOR'));
				}

				if ($usuarioLogado->getImgFundo() !== $localImagemFundo->getId()) {
					$usuarioLogado->setImgFundo($localImagemFundo->getId());
					$usuarioLogado->setImgFundoExt($localImagemFundo->getExtensao());
					if (!$atualizar) {
						$atualizar = true;
					}
				}
			}
		} catch (Exception $e) {
			$imagemErro = Config::obter('MvcErrors.PerfilEdit.Definicoes')[$e->getMessage()];
		} finally {
			if ($atualizar) {
				$dal = new DalUsuario($this->getConexao());
				$dal->atualizarUsuario($usuarioLogado);
			}

			return $this->index($usuarioLogado, $imagemErro);
		}
	}

	public function notFound($usuarioLogado) {
		return new NotFoundView($usuarioLogado);
	}
}

?>