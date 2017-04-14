/**
 * Criando o banco de dados...
 */

CREATE DATABASE phpgallery;
USE phpgallery;

/**
 * Criando tabelas...
 */

CREATE TABLE Usuarios
(
	usr_id int NOT NULL PRIMARY KEY AUTO_INCREMENT,
	usr_nome varchar(16) NOT NULL,
	usr_senha char(64) NOT NULL,
	usr_descricao varchar(300) CHARSET UTF8 NULL,
	usr_tem_imagem_perfil tinyint(1) NOT NULL DEFAULT 0,
	usr_data_criacao datetime NOT NULL,
	usr_online_timestamp int NULL,
	usr_admin tinyint(1) NOT NULL DEFAULT 0,
	usr_rep int NOT NULL DEFAULT 0,
	usr_img_fundo int NULL
);

--

CREATE TABLE Imagens
(
	img_id int NOT NULL PRIMARY KEY AUTO_INCREMENT,
	usr_id int NOT NULL,
	img_titulo varchar(64) CHARSET UTF8 NULL,
	img_descricao varchar(300) CHARSET UTF8 NULL,
	img_data_criacao datetime NOT NULL,
	img_extensao varchar(4) NOT NULL,
	img_privada tinyint(1) NOT NULL DEFAULT 0,
	img_largura int NOT NULL,
	img_altura int NOT NULL
);

--

CREATE TABLE Comentarios
(
	cmt_id int NOT NULL PRIMARY KEY AUTO_INCREMENT,
	img_id int NOT NULL,
	usr_id int NOT NULL,
	cmt_conteudo varchar(300) CHARSET UTF8 NOT NULL,
	cmt_data_criacao datetime NOT NULL
);

--

ALTER TABLE Usuarios
ADD FOREIGN KEY (usr_img_fundo) REFERENCES Imagens(img_id);

ALTER TABLE Imagens
ADD FOREIGN KEY (usr_id) REFERENCES Usuarios(usr_id);

ALTER TABLE Comentarios
ADD FOREIGN KEY (img_id) REFERENCES Imagens(img_id),
ADD FOREIGN KEY (usr_id) REFERENCES Usuarios(usr_id);

