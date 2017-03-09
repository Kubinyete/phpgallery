<?php
namespace PHPGallery\ApiInterface;

require_once "ApiErroDefinicoes.php";

/**
 * Classe responsável por representar uma resposta JSON de um objeto
 */
class ApiResposta {
	private $resposta_objeto;

	// Se criarmos o objeto ApiResposta apenas para enviar um erro, não precisamos de um $resposta_objeto, pois enviar erro irá preencher o nosso $resposta_objeto de acordo com o código de erro informado
	public function __construct($resposta_objeto=null) {
		$this->resposta_objeto = [
		"dados" => $resposta_objeto
		];
	}

	// Envia nosso objeto resposta encodificado para JSON
	public function enviar() {
		echo json_encode($this->resposta_objeto, JSON_PRETTY_PRINT);
	}

	// Envia uma resposta de erro codificada em JSON
	public function enviar_erro($err=0) {
		// Se o erro não existir
		if (!isset(ApiErroDefinicoes::$api_erros[$err])) {
			header("Status: " . ApiErroDefinicoes::$api_erros[AE_DESCONHECIDO][1], true, ApiErroDefinicoes::$api_erros[AE_DESCONHECIDO][1]);

			$this->resposta_objeto["dados"] = [
				"erro_api" => true,
				"erro_codigo" => 0,
				"erro_mensagem" => ApiErroDefinicoes::$api_erros[AE_DESCONHECIDO][0]
			];
		// Se o erro existir
		} else {
			header("Status: " . ApiErroDefinicoes::$api_erros[$err][1], true, ApiErroDefinicoes::$api_erros[$err][1]);

			$this->resposta_objeto["dados"] = [
				"erro_api" => true,
				"erro_codigo" => $err,
				"erro_mensagem" => ApiErroDefinicoes::$api_erros[$err][0]
			];
		}
		
		echo json_encode($this->resposta_objeto, JSON_PRETTY_PRINT);
	}
}

?>