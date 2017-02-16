--Cria o banco de dados phpgallery
CREATE DATABASE phpgallery;
GO

USE phpgallery;

--Cria o modelo de objeto Usuario
CREATE TABLE usuarios
(
	usr_id bigint NOT NULL IDENTITY(1,1) PRIMARY KEY,
	usr_nome varchar(16) NOT NULL,
	usr_senha char(32) NOT NULL,
	usr_descricao varchar(150),
	usr_temimagem bit NOT NULL DEFAULT 0,
	usr_dataregistro char(17) NOT NULL
)

--Cria o modelo de objeto Imagem
CREATE TABLE imagens
(
	img_id bigint NOT NULL IDENTITY(1,1) PRIMARY KEY,
	img_titulo varchar(64),
	img_descricao varchar(150),
	img_privado bit NOT NULL DEFAULT 0,
	img_ext varchar(6) NOT NULL,
	img_autor varchar(16) NOT NULL,
	img_datacriacao char(17) NOT NULL
)

--Cria o modelo de 'gostei'
CREATE TABLE imagens_gosteis
(
	gst_imagem_id bigint NOT NULL,
	gst_autor_id bigint NOT NULL
)

--Comentários
CREATE TABLE comentarios
(
	cmt_id bigint NOT NULL IDENTITY(1,1) PRIMARY KEY,
	cmt_imagem_id bigint NOT NULL,
	cmt_conteudo varchar(150) NOT NULL,
	cmt_autor varchar(16) NOT NULL,
	cmt_datacriacao char(17) NOT NULL
)