<?php
	//Usuário do banco de dados MSSQL
	define("DB_USUARIO", "localhost\\Vitor");
	//Senha do usuário do banco de dados MSSQL
	define("DB_SENHA", "");
	//String utilizada para conectar-se ao banco de dados 
	define("DB_STRING_CONEXAO", "DRIVER={SQL Server};SERVER=localhost\\SQLEXPRESS;DATABASE=phpgallery;Trusted_Connection=yes");

	//Retorna esta string se a descricao de algo for nulo
	define("RESPOSTA_SEM_DESCRICAO", "Nenhuma descrição está disponível.");
	//Retorna esta string se o título da imagem for nulo
	define("RESPOSTA_SEM_TITULO", "Nenhum título está disponível.");

	//Diretório das imagens de perfil dos usuários
	define("IMAGENS_USUARIO_ORIGEM", "/resources/profile/");
	//Extensão de arquivo padrão para imagens de usuário
	//NESSE CONTEXTO USUÁRIOS SÓ PODERÃO ENVIAR IMAGENS JPEG,
	//PNGs SERÃO CONVERTIDOS PARA JPEG!
	define("IMAGENS_USUARIO_EXT", ".jpg");
	//Diretório das imagens
	define("IMAGENS_ORIGEM", "/resources/image/");
	//Imagem padrão de um usuário
	define("IMAGENS_USUARIO_PADRAO", IMAGENS_USUARIO_ORIGEM . "user-default" . IMAGENS_USUARIO_EXT);

	//Script processador de miniaturas
	define("IMAGENS_PROCESSADOR_MINIATURAS" , "thumbnail.php");

	//Local fixo dos nossos documentos
	define("DOWNLOAD_HTDOCS", "C:/xampp/htdocs");
	//Local fixo aonde as imagens serão enviadas
	define("UPLOAD_IMAGENS_DESTINO", DOWNLOAD_HTDOCS . IMAGENS_ORIGEM);
	//Local fixo aonde as imagens dos USUÁRIOS serão enviadas
	define("UPLOAD_USUARIO_IMAGEM_DESTINO", DOWNLOAD_HTDOCS . IMAGENS_USUARIO_ORIGEM);

	//MSSQL: filtrar escape strings
	//acrescenta uma nova ' em todas as ' da string
	//previne a execução de código SQL malicioso
	function filtrar_escape_string_mssql($string) {
		$string = strval($string);
		$retorno = "";

		for ($i = 0; $i < strlen($string); $i++) {
			if ($string[$i] === "'") {
				$retorno .= "'" . $string[$i];
			} else {
				$retorno .= $string[$i];
			}
		}

		return $retorno;
	}

	//Verifica se o conteudo do comentário é valido
	//Pode até ser utilizado em outros locais para verificar se o conteúdo não
	//é apenas vários espaços e new lines
	//Retorna false se o comentário não for válido
	function conteudo_comentario_valido($string) {
		$val = trim($string);
		if (strlen($val) >= 1) {
			return true;
		} else {
			return false;
		}
	}

	//Retorna se o campo informado é valido para efetuar login / registrar-se
	//Para conteúdos restritos (login/registrar)
	function campo_valido($string) {
		$retorno = true;

		for ($i = 0; $i < strlen($string); $i++) {
			if (ord($string[$i]) <= 47 || ord($string[$i]) >= 58 && ord($string[$i]) <= 64 || ord($string[$i]) >= 91 && ord($string[$i]) <= 96 || ord($string[$i]) >= 123) {
				$retorno = false;
			}
		}

		return $retorno;
	}
?>