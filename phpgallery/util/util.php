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
	define("IMAGENS_USUARIO_EXT", ".jpg");
	//Diretório das imagens
	define("IMAGENS_ORIGEM", "/resources/image/");
	//Imagem padrão de um usuário
	define("IMAGENS_USUARIO_PADRAO", "/resources/profile/user-default.jpg");

	//Local fixo dos nossos documentos
	define("DOWNLOAD_HTDOCS", "C:/xampp/htdocs");
	//Local fixo aonde as imagens serão enviadas
	define("UPLOAD_IMAGENS_DESTINO", DOWNLOAD_HTDOCS . IMAGENS_ORIGEM);

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
	//Retorna false se o comentário não for válido
	function conteudo_comentario_valido($string) {
		$val = trim($string);
		if (strlen($val) >= 1) {
			return true;
		} else {
			return false;
		}
	}
?>