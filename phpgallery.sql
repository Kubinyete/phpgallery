/**
 * Criando o banco de dados...
 */

CREATE DATABASE phpgallery;
GO
USE phpgallery;

/**
 * Criando tabelas...
 */

CREATE TABLE Usuarios
(
	usr_id int NOT NULL PRIMARY KEY IDENTITY(1,1),
	usr_nome varchar(16) NOT NULL,
	usr_senha char(64) NOT NULL,
	usr_descricao varchar(300) NULL,
	usr_tem_imagem_perfil bit NOT NULL DEFAULT 0,
	usr_data_criacao datetime NOT NULL,
	usr_online_timestamp int NULL,
	usr_admin bit NOT NULL DEFAULT 0,
	--usr_img_fundo int NOT NULL DEFAULT 0 FOREIGN KEY REFERENCES Imagens(img_id),
	usr_rep int NOT NULL DEFAULT 0
);

--

CREATE TABLE Imagens
(
	img_id int NOT NULL PRIMARY KEY IDENTITY(1,1),
	--usr_id int NOT NULL FOREIGN KEY REFERENCES Usuarios(usr_id),
	img_titulo varchar(64) NULL,
	img_descricao varchar(300) NULL,
	img_data_criacao datetime NOT NULL,
	img_extensao varchar(4) NOT NULL,
	img_privada bit NOT NULL DEFAULT 0,

	img_largura int NOT NULL,
	img_altura int NOT NULL
);

--

CREATE TABLE Comentarios
(
	cmt_id int NOT NULL PRIMARY KEY IDENTITY(1,1),
	--img_id int NOT NULL FOREIGN KEY REFERENCES Imagens(img_id),
	--usr_id int NOT NULL FOREIGN KEY REFERENCES Usuarios(usr_id),
	cmt_conteudo varchar(300) NOT NULL,
	cmt_data_criacao datetime NOT NULL,
);

--

ALTER TABLE Usuarios
ADD usr_img_fundo int NULL FOREIGN KEY REFERENCES Imagens(img_id);

ALTER TABLE Imagens
ADD usr_id int NOT NULL FOREIGN KEY REFERENCES Usuarios(usr_id);

ALTER TABLE Comentarios
ADD img_id int NOT NULL FOREIGN KEY REFERENCES Imagens(img_id),
    usr_id int NOT NULL FOREIGN KEY REFERENCES Usuarios(usr_id);
