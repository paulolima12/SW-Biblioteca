CREATE DATABASE biblioteca;
USE biblioteca;

CREATE TABLE editora (
    id_editora int AUTO_INCREMENT UNIQUE PRIMARY KEY,
    editora varchar(150)
);

CREATE TABLE genero (
    id_genero int AUTO_INCREMENT UNIQUE PRIMARY KEY,
    genero varchar(150)
);

CREATE TABLE autor (
    id_autor int AUTO_INCREMENT UNIQUE PRIMARY KEY,
    nome varchar(250)
);

CREATE TABLE livro (
    id_livro int AUTO_INCREMENT UNIQUE PRIMARY KEY,
    isbn varchar(14),
    titulo varchar(200),
    ano_publicacao year,
    id_editora int,
    id_genero int,
    status ENUM('disponível', 'emprestado') DEFAULT 'disponível',
    FOREIGN KEY (id_editora) REFERENCES editora(id_editora),
    FOREIGN KEY (id_genero) REFERENCES genero(id_genero)
);

CREATE TABLE administrador (
    id_adm int AUTO_INCREMENT UNIQUE PRIMARY KEY,
    cpf varchar(11) UNIQUE,
    nome varchar(200),
    email varchar(100),
    senha varchar(100)
);

CREATE TABLE funcionario (
    email varchar(100),
    nome varchar(200),
    id_funcionario int AUTO_INCREMENT UNIQUE PRIMARY KEY,
    cpf varchar(11) UNIQUE,
    senha varchar(100)
);

CREATE TABLE usuario (
    nome varchar(200),
    id_usuario int AUTO_INCREMENT UNIQUE PRIMARY KEY,
    cpf varchar(11) UNIQUE,
    senha varchar(100),
    email varchar(100),
    status ENUM('ativo', 'bloqueado') DEFAULT 'ativo'
);

CREATE TABLE emprestimo (
    id_emprestimo int AUTO_INCREMENT UNIQUE PRIMARY KEY,
    data_emprestimo date,
    data_devolucao date,
    status_devolucao ENUM('pendente', 'confirmada', 'atrasada') DEFAULT 'pendente',
    status ENUM('solicitado', 'aprovado', 'em andamento', 'concluído') DEFAULT 'solicitado',
    id_livro int,
    id_funcionario int,
    id_usuario int,
    FOREIGN KEY (id_livro) REFERENCES livro(id_livro),
    FOREIGN KEY (id_funcionario) REFERENCES funcionario(id_funcionario),
    FOREIGN KEY (id_usuario) REFERENCES usuario(id_usuario)
);

CREATE TABLE livro_autor (
    id_autor int,
    id_livro int,
    PRIMARY KEY (id_autor, id_livro),
    FOREIGN KEY (id_autor) REFERENCES autor(id_autor),
    FOREIGN KEY (id_livro) REFERENCES livro(id_livro)
);
