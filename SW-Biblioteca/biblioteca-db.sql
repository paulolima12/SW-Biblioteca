CREATE DATABASE biblioteca DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
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
    capa varchar(100),
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
    senha varchar(100),
    status ENUM('ativo', 'inativo') DEFAULT 'ativo'
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
    status_devolucao ENUM('aguardando confirmação', 'pendente', 'confirmada', 'atrasada') DEFAULT 'aguardando confirmação',
    status ENUM('solicitado', 'em andamento', 'concluído', 'rejeitado', 'atrasado') DEFAULT 'solicitado',
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

# INSERTS
# Link dos livros: https://resenhasalacarte.com.br/listas/100-livros-essenciais-literatura-mundial/


# AUTOR
insert into autor (nome) values 
("Homero"),
("William Shakespeare"),
("Miguel de Cervantes"),
("Dante Alighieri"),
("Marcel Proust"),
("James Joyce"),
("Leon Tolstói"),
("Fiódor Doistoiévski"),
("Michel de Montaigne"),
("Sófocles"),
("Gustave Flaubert"),
("Goethe"),
("Franz Kafka"),
("Thomas Mann"),
("Charles Baudelaire"),
("William Faukner"),
("T.S Eliot"),
("Hesíodo"),
("Ovídio"),
("Stendhal"),
("Francis Scott Fitzgerald"),
("Arthur Rimbaud"),
("Victor Hugo"),
("Albert Camus"),
("Eurípides"),
("Virgilio"),
("Ernest Hemingway"),
("Joseph Conrad"),
("Aldous Huxley"),
("Virginia Woolf"),
("Herman Melville"),
("Edgar Allan Poe"),
("Honore de Balzac"),
("Charles Dickens"),
("Robert Musil"),
("Jonathan Swift"),
("Luís de Camões"),
("Alexandre Dumas"),
("Henry James"),
("Giovanni Boccaccio"),
("Samuel Beckett"),
("George Orwell"),
("Bertolt Brecht"),
("Lautreamont"),
("Stephane Mallarme"),
("Vladimir Nabokov"),
("Molière"),
("Anton Tchekhov"),
("Antoine Galland"),
("Tirso de Molina"),
("Fernando Pessoa"),
("John Milton"),
("Daniel Defoe"),
("André Gide"),
("Machado de Assis"),
("Oscar Wilde"),
("Luigi Pirandello"),
("Lewis Carroll"),
("Jean-Paul Sartre"),
("Italo Svevo"),
("Eugene Gladstone O’Neill"),
("André Malraux"),
("Ezra Pound"),
("William Blake"),
("Tennessee Williams"),
("Jorge Luis Borges"),
("Eugene Ionesco"),
("Hermann Broch"),
("Walt Whitman"),
("Dino Buzzati"),
("Gabriel García Marquez"),
("Louis-Ferdinand Celine"),
("Eça de Queirós"),
("Julio Cortázar"),
("John Steinbeck"),
("Marguerite Yourcenar"),
("J. D. Salinger"),
("Mark Twain"),
("Hans Christian Andersen"),
("Tomasi di Lampedusa"),
("Laurence Sterne"),
("Edward Morgan Forster"),
("Jane Austen"),
("Henry Miller"),
("Ivan Turgueniev"),
("Thomas Bernhard"),
("Gilgamesh"),
("William Buck"),
("Italo Calvino"),
("Jack Kerouac"),
("Herman Hesse"),
("Philip Roth"),
("Ian McEwan"),
("J. M. Coetzee"),
("Junichiro Tanizaki"),
("Juan Rulfo");


# EDITORA
insert into editora (editora) values 
("Penguin-Companhia"),
("Editora 34"),
("Nova Fronteira"),
("Companhia das Letras"),
("Clássicos Zahar"),
("Companhia de Bolso"),
("Editora Hedra"),
("L&PM"),
("Record"),
("Bertrand Brasil"),
("Darkside"),
("Biblioteca Azul"),
("José Olympio"),
("Iluminuras"),
("Ibis Libris"),
("Alfaguara"),
("Editora UNESP"),
("Editora Peixoto Neto"),
("Todavia"),
("Estação Liberdade"),
("Pé da Letra"),
("Best Seller"),
("Crisalida"),
("Sétimo Selo"),
("Editora Paulinas"),
("Autêntica"),
("Cultrix");


# GENERO
insert into genero (genero) values 
("Épico"),
("Tragédia"),
("Romance"),
("Romance histórico"),
("Ensaio"),
("Poesia"),
("Poema"),
("Prosa poética"),
("Novela"),
("Comédia"),
("Autobiografia"),
("Roman à clef"),
("Ficção distópica"),
("Romance psicológico"),
("Suspense"),
("Ficção"),
("Sátira"),
("Literatura experimental"),
("Epopeia"),
("Tragicomédia"),
("Drama"),
("Literatura gótica"),
("Conto"),
("Literatura infantil"),
("Romance existencialista"),
("Coletânea"),
("Ficção política"),
("Romance biográfico"),
("Ficção doméstica"),
("Romance regionalista");


# LIVROS
insert into livro (isbn, titulo, ano_publicacao, id_editora, id_genero, capa) values 
("978-8563560568", "Ilíada", 2013, 1, 1, "iliada.jpg"),
("978-8563560278", "Odisseia", 2011, 1, 1, "odisseia.jpg"),
("978-8582850145", "Hamlet", 2015, 1, 2, "hamlet.jpg"),
("978-8563560551", "Dom Quixote", 2012, 1, 15, "dom-quixote.jpg"),
("978-8573261202", "A Divina Comédia", 2017, 2, 6, "divina-comedia.jpg"),
("978-8520926505", "Em Busca do Tempo Perdido", 2017, 3, 3, "em-busca-do-tempo-perdido.jpg"),
("978-8563560421", "Ulysses", 2012, 1, 3, "ulysses.jpg"),
("978-8535930047", "Guerra e paz", 2017, 4, 4, "guerra-e-paz.jpg"),
("978-8573266467", "Crime e castigo", 2016, 2, 14, "crime-e-castigo.jpg"),
("978-8563560063", "Os ensaios", 2010, 1, 5, "os-ensaios.jpg"),
("978-8537817360", "Édipo Rei", 2018, 5, 2, "edipo-rei.jpg"),
("978-8582850459", "Otelo", 2017, 1, 2, "otelo.jpg"),
("978-8563560315", "Madame Bovary", 2011, 1, 3, "madame-bovary.jpg"),
("978-6555250442", "Fausto", 2023, 2, 2, "fausto.jpg"),
("978-8535907438", "O processo", 2005, 6, 13, "o-processo.jpg"),
("978-8535926484", "Doutor Fausto", 2015, 4, 27, "doutor-fausto.jpg"),
("978-8582850930", "As flores do mal", 2019, 1, 6, "as-flores-do-mal.jpg"),
("978-8535929423", "O Som e a Fúria", 2017, 4, 3, "o-som-e-a-furia.jpg"),
("978-8535931785", "A terra devastada", 2018, 4, 7, "terra-devastada.jpg"),
("978-6589705581", "Teogonia", 2022, 7, 1, "teogonia.jpg"),
("978-8582851784", "Metamorfoses", 2023, 1, 6, "metamorfoses.jpg"),
("978-8582850725", "O Vermelho e o Negro", 2018, 1, 14, "o-vermelho-e-o-negro.jpg"),
("978-8563560292", "O Grande Gatsby", 2011, 1, 3, "o-grande-gatsby.jpg"),
("978-8525406712", "Uma Temporada no Inferno", 2006, 8, 6, "uma-temporada-no-inferno.jpg"),
("978-8582850480", "Os miseráveis", 2017, 1, 3, "os-miseraveis.jpg"),
("978-8501014863", "O estrangeiro", 1979, 9, 3, "o-estrangeiro.jpg"),
("978-6559790111", "Medeia", 2021, 5, 2, "medeia.jpg"),
("978-8551307915", "Eneida", 2022, 26, 1, "eneida.jpg"),
("978-8525413147", "Noite de Reis", 2004, 8, 10, "noite-de-reis.jpg"),
("978-8528618327", "Adeus às armas", 2013, 10, 11, "adeus-as-armas.jpg"),
("978-6555980998", "Coração das Trevas", 2021, 11, 12, "coracao-das-trevas.jpg"),
("978-8525056009", "Admirável mundo novo", 2014, 12, 13, "admiravel-mundo-novo.jpg"),
("978-8582850572", "Mrs. Dalloway", 2017, 1, 14, "mrs-dalloway.jpg"),
("978-8573267389", "Moby Dick", 2019, 2, 16, "moby-dick.jpg"),
("978-8535930030", "Histórias extraordinárias", 2017, 4, 26, "historias-extraordinarias.jpg"),
("978-8525053121", "A Comédia Humana", 2012, 12, 3, "comedia-humana.jpg"),
("978-8563560476", "Grandes Esperanças", 2012, 1, 16, "grandes-esperancas.jpg"),
("978-6556403571", "O Homem sem Qualidades", 2021, 3, 3, "o-homem-sem-qualidades.jpg"),
("978-6584952102", "Viagens de Gulliver", 2023, 5, 17, "viagens-de-gulliver.jpg"),
("978-8573215755", "Finnegans Wake", 2018, 14, 18, "finnegans-wake.jpg"),
("978-8520942956", "Os Lusíadas", 2020, 3, 19, "os-lusiadas.jpg"),
("978-8537802786", "Os três mosqueteiros", 2010, 5, 4, "os-tres-mosqueteiros.jpg"),
("978-8535929607", "Esperando Godot", 2017, 4, 2, "esperando-godot.jpg"),
("978-8535914849", "1984", 2009, 4, 13, "1984.jpg"),
("978-8573212310", "Os Cantos de Maldoror", 2018, 14, 6, "os-cantos-de-maldoror.jpg"),
("978-8578230838", "A Tarde de um Fauno", 2017, 15, 6, "a-tarde-de-um-fauno.jpg"),
("978-8579620560", "Lolita", 2011, 16, 3, "lolita.jpg"),
("978-6557110584", "Tartufo", 2022, 17, 10, "tartufo.jpg"),
("978-8588069053", "As três irmâs", 2004, 18, 21, "as-tres-irmas.jpg"),
("978-6558302032", "Mil e uma noites", 2023, 12, 26, "mil-e-uma-noites.jpg");


# LIVRO_AUTOR
insert into livro_autor (id_autor, id_livro) values 
(1, 1),
(1, 2),
(2, 3),
(3, 4),
(4, 5),
(5, 6),
(6, 7),
(7, 8),
(8, 9),
(9, 10),
(10, 11),
(2, 12),
(11, 13),
(12, 14),
(13, 15),
(14, 16),
(15, 17),
(16, 18),
(17, 19),
(18, 20),
(19, 21),
(20, 22),
(21, 23),
(22, 24),
(23, 25),
(24, 26),
(25, 27),
(26, 28),
(2, 29),
(27, 30),
(28, 31),
(29, 32),
(30, 33),
(31, 34),
(32, 35),
(33, 36),
(34, 37),
(35, 38),
(36, 39),
(6, 40),
(37, 41),
(38, 42),
(41, 43),
(42, 44),
(44, 45),
(45, 46),
(46, 47),
(47, 48),
(48, 49),
(49, 50);


# ADMIN (teste) senha: senhaADM1234
insert into administrador (cpf, nome, email, senha) values 
("55055055099", "Paulo Costa", "emailtesteadmin@gmail.com", "980a6edb7c2aedad638b8091bbb4c37b3a9f9d943ce44de96af17400b2419332");


# FUNCIONARIO (teste) senha João Gomes: senhaFUNC1234 e senha Cleber Rafael: senhaFUNCIO123
insert into funcionario (cpf, nome, email, senha) values 
("45045045088", "João Gomes", "emailtestefuncionario@gmail.com", "89e08d745d3a79b648abfb66bf9bb9cfc8e88c2cbc54245f5bbf81017d5ebb94"),
("45054045077", "Cléber Rafael", "emailfuncionarioteste@gmail.com", "ff24bd1a9dff2edeaed9fea1a491220cdc7458d73eb3c60499ee87191b36f5b5");


# USUARIO (teste) senha: senhaUSER1234
insert into usuario (cpf, nome, email, senha) values 
("35035035077", "Miguel Torres", "emailtesteuser@gmail.com", "8751687b2aebac992d2669bba14af112647a70087be7d97b47bc95e169fe3da5");

