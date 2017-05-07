<?php
/**
 * Representa o nosso modelo para download de imagens
 */

namespace App\Models;

use App\Models\Model;
use App\Views\ErroView;
use App\Database\DalImagem;

class DownloadModel extends Model {
	// $conexao
	
	public function index($usuarioLogado, $id=0) {
		$dal = new DalImagem($this->getConexao());
		$imagem = $dal->obterImagem($id);

		if ($imagem !== null) {
			return [
				'sucesso' => true,
				'conteudo' => @file_get_contents(dirname(dirname(__DIR__)).DIRECTORY_SEPARATOR.$imagem->getImagemUrl()),
				'imagem_tipo' => $imagem->getExtensao(),
				'imagem_arquivo' => $imagem->getArquivoNome()
			];
		} else {
			return $this->notFound($usuarioLogado);
		}
	}

	public function notFound($usuarioLogado) {
		return [
			'sucesso' => false,
			'conteudo' => new ErroView(
				$usuarioLogado,
				'A imagem que você está procurando não existe.',
				'HTTP - 404 Not Found'
			)
		];
	}
}

?>