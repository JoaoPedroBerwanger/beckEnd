/* Nome da db: sistema_vendas*/

CREATE TABLE usuario (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(200) NOT NULL,
    login VARCHAR(50) NOT NULL UNIQUE,
    senha VARCHAR(100) NOT NULL,
    idnAtivo TINYINT(1) DEFAULT 1
);

INSERT INTO usuario (nome, login, senha)
VALUES ('Administrador', 'admin', MD5('123'));

CREATE TABLE cliente_grupo (
    id INT AUTO_INCREMENT PRIMARY KEY,
    descricao VARCHAR(200) NOT NULL,
    idnAtivo TINYINT(1) DEFAULT 1
);

CREATE TABLE cliente (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(200) NOT NULL,
    cpfCnpj VARCHAR(15),
    rua VARCHAR(150),
    bairro VARCHAR(100),
    numero INT,
    cep VARCHAR(15),
    email VARCHAR(50),
    idGrupoCliente INT,
    idnAtivo TINYINT(1) DEFAULT 1,
    FOREIGN KEY (idGrupoCliente) REFERENCES cliente_grupo(id)
);

CREATE TABLE produto_grupo (
    id INT AUTO_INCREMENT PRIMARY KEY,
    descricao VARCHAR(200) NOT NULL,
    idnAtivo TINYINT(1) DEFAULT 1
);

CREATE TABLE marca (
    id INT AUTO_INCREMENT PRIMARY KEY,
    descricao VARCHAR(200) NOT NULL,
    idnAtivo TINYINT(1) DEFAULT 1
);

CREATE TABLE produto (
    id INT AUTO_INCREMENT PRIMARY KEY,
    descricao VARCHAR(200) NOT NULL,
    idMarcaProduto INT,
    idGrupoProduto INT,
    precoVenda DECIMAL(18,4) NOT NULL,
    precoCusto DECIMAL(18,4),
    estoque DECIMAL(18,4) DEFAULT 0,
    idnAtivo TINYINT(1) DEFAULT 1,
    FOREIGN KEY (idMarcaProduto) REFERENCES marca(id),
    FOREIGN KEY (idGrupoProduto) REFERENCES produto_grupo(id)
);

CREATE TABLE condicao_pagamento (
    id INT AUTO_INCREMENT PRIMARY KEY,
    descricao VARCHAR(150) NOT NULL,
    idnAtivo TINYINT(1) DEFAULT 1
);

CREATE TABLE forma_pagamento (
    id INT AUTO_INCREMENT PRIMARY KEY,
    descricao VARCHAR(150) NOT NULL,
    idnAtivo TINYINT(1) DEFAULT 1
);

CREATE TABLE vendas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    numero INT NOT NULL,
    idCliente INT NOT NULL,
    idCondicaoPagamento INT,
    idFormaPagamento INT,
    totalVenda DECIMAL(18,4),
    dataVenda DATETIME DEFAULT NOW(),
    idUsuario INT,
    idnCancelada TINYINT(1) DEFAULT 0,
    FOREIGN KEY (idCliente) REFERENCES cliente(id),
    FOREIGN KEY (idCondicaoPagamento) REFERENCES condicao_pagamento(id),
    FOREIGN KEY (idFormaPagamento) REFERENCES forma_pagamento(id),
    FOREIGN KEY (idUsuario) REFERENCES usuario(id)
);

CREATE TABLE venda_produtos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    idVenda INT NOT NULL,
    idProduto INT NOT NULL,
    quantidade DECIMAL(18,4) NOT NULL,
    desconto DECIMAL(18,4) DEFAULT 0,
    precoVenda DECIMAL(18,4) NOT NULL,
    precoCusto DECIMAL(18,4),
    total DECIMAL(18,4) NOT NULL,
    FOREIGN KEY (idVenda) REFERENCES vendas(id),
    FOREIGN KEY (idProduto) REFERENCES produto(id)
);
