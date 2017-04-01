<?php
/**
 * Nosso processador de miniaturas
 */

require_once dirname(__DIR__).DIRECTORY_SEPARATOR."bootstrap".DIRECTORY_SEPARATOR."autoload.php";

use App\Database\Conexao;
use App\Database\DalImagem;
use App\Http\Pedido;
use App\Http\Resposta;

const MAX_LARGURA = 256;
const MAX_ALTURA = 256;
const UTILIZAR_RESAMPLING = true;
const SAIDA = IMAGETYPE_JPEG;
const SAIDA_QUALIDADE = 100;

$id = intval(Pedido::obter("id"));

try {
	if ($id > 0) {
		$conexao = new Conexao();
		$dal = new DalImagem($conexao);

		$imagem = $dal->obterImagem($id);

		if ($imagem) {
			$imagemDados = file_get_contents(dirname(__DIR__).DIRECTORY_SEPARATOR.$imagem->getImagemUrl());

			if (!$imagemDados) {
				throw new Exception("A imagem não foi encontrada no disco.");
			} else {
				$imagemInfo = getimagesizefromstring($imagemDados);
				$imagemObj = imagecreatefromstring($imagemDados);

				$largura = $imagemInfo[0];
				$altura = $imagemInfo[1];
				$novaLargura = $largura;
				$novaAltura = $altura;

				if ($novaAltura > MAX_ALTURA) {
					$novaAltura = MAX_ALTURA;
					$novaLargura = $largura / $altura * $novaAltura;
				}
				if ($novaLargura > MAX_LARGURA) {
					$novaLargura = MAX_LARGURA;
					$novaAltura = $novaLargura / ($largura / $altura);
				}

				$miniaturaObj = imagecreatetruecolor($novaLargura, $novaAltura);

				if (UTILIZAR_RESAMPLING) {
					imagecopyresampled($miniaturaObj, $imagemObj, 0, 0, 0, 0, $novaLargura, $novaAltura, $largura, $altura);
				} else {
					imagecopyresized($miniaturaObj, $imagemObj, 0, 0, 0, 0, $novaLargura, $novaAltura, $largura, $altura);
				}

				switch (SAIDA) {
					case IMAGETYPE_PNG:
						Resposta::conteudoTipo("image/png");
						imagepng($miniaturaObj, null);
						break;
					case IMAGETYPE_GIF:
						Resposta::conteudoTipo("image/gif");
						imagegif($miniaturaObj, null);
						break;
					case IMAGETYPE_JPEG:
					default:
						Resposta::conteudoTipo("image/jpeg");
						imagejpeg($miniaturaObj, null, SAIDA_QUALIDADE);
						break;
				}
			}
		} else {
			throw new Exception("Esta imagem não existe.");
		}
	} else {
		throw new Exception("Identificação inválida.");
	}
} catch (Exception $e) {
	Resposta::status(400);
	exit(
		"<h1>Erro</h1>".
		"<hr>".
		"<p>".$e->getMessage()."</p>"
	);
}

?>