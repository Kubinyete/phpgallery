<?php
	//Inicio de uma página que necessita de sessão (o objeto do usuário)
	@session_start();
	
	if (!campo_valido(session_id())) {
		session_regenerate_id();
	}
?>