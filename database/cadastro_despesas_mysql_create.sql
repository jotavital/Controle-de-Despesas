CREATE TABLE `usuario` (
	`id` INT NOT NULL AUTO_INCREMENT,
	`nome` varchar(255) NOT NULL,
	`sobrenome` varchar(255) NOT NULL,
	`nome_usuario` varchar(45) NOT NULL,
	`senha` varchar(10) NOT NULL,
	`prazo_aviso` INT(2) NOT NULL,
	PRIMARY KEY (`id`)
);

CREATE TABLE `despesa` (
	`id` INT NOT NULL AUTO_INCREMENT,
	`nome_despesa` varchar(255) NOT NULL,
	`descricao_despesa` varchar(255) NOT NULL,
	`imagem` blob NOT NULL,
	`data_despesa` DATE NOT NULL,
	`data_vencimento` DATE NOT NULL,
	`valor` FLOAT NOT NULL,
	`fk_usuario` INT NOT NULL,
	PRIMARY KEY (`id`)
);

CREATE TABLE `categoria` (
	`id` INT NOT NULL AUTO_INCREMENT,
	`nome_categoria` varchar(255) NOT NULL,
	`descricao_categoria` varchar(255) NOT NULL,
	PRIMARY KEY (`id`)
);

CREATE TABLE `categoria_despesa` (
	`fk_categoria` INT NOT NULL,
	`fk_despesa` INT NOT NULL,
	PRIMARY KEY (`fk_categoria`,`fk_despesa`)
);

CREATE TABLE `receita` (
	`id` INT NOT NULL AUTO_INCREMENT,
	`nome_receita` varchar(255) NOT NULL,
	`descricao_receita` varchar(255) NOT NULL,
	`data_receita` DATE NOT NULL,
	`valor` FLOAT NOT NULL,
	`fk_usuario` INT NOT NULL,
	PRIMARY KEY (`id`)
);

CREATE TABLE `meta` (
	`id` INT NOT NULL AUTO_INCREMENT,
	`nome_meta` varchar(255) NOT NULL,
	`descricao_meta` varchar(255) NOT NULL,
	`prazo_meta` DATE NOT NULL,
	`valor_total` FLOAT NOT NULL,
	`valor_atingido` FLOAT NOT NULL,
	`fk_usuario` INT NOT NULL,
	PRIMARY KEY (`id`)
);

CREATE TABLE `economia` (
	`id` INT NOT NULL AUTO_INCREMENT,
	`nome_economia` varchar(255) NOT NULL,
	`descricao_economia` varchar(255) NOT NULL,
	`valor` FLOAT NOT NULL,
	`fk_usuario` INT NOT NULL,
	PRIMARY KEY (`id`)
);

CREATE TABLE `categoria_receita` (
	`fk_categoria` INT NOT NULL,
	`fk_receita` INT NOT NULL,
	PRIMARY KEY (`fk_categoria`)
);

CREATE TABLE `categoria_economia` (
	`fk_categoria` INT NOT NULL,
	`fk_economia` INT NOT NULL,
	PRIMARY KEY (`fk_categoria`)
);

CREATE TABLE `categoria_meta` (
	`fk_categoria` INT NOT NULL,
	`fk_meta` INT NOT NULL,
	PRIMARY KEY (`fk_categoria`)
);

ALTER TABLE `despesa` ADD CONSTRAINT `despesa_fk0` FOREIGN KEY (`fk_usuario`) REFERENCES `usuario`(`id`);

ALTER TABLE `categoria_despesa` ADD CONSTRAINT `categoria_despesa_fk0` FOREIGN KEY (`fk_categoria`) REFERENCES `categoria`(`id`);

ALTER TABLE `categoria_despesa` ADD CONSTRAINT `categoria_despesa_fk1` FOREIGN KEY (`fk_despesa`) REFERENCES `despesa`(`id`);

ALTER TABLE `receita` ADD CONSTRAINT `receita_fk0` FOREIGN KEY (`fk_usuario`) REFERENCES `usuario`(`id`);

ALTER TABLE `meta` ADD CONSTRAINT `meta_fk0` FOREIGN KEY (`fk_usuario`) REFERENCES `usuario`(`id`);

ALTER TABLE `economia` ADD CONSTRAINT `economia_fk0` FOREIGN KEY (`fk_usuario`) REFERENCES `usuario`(`id`);

ALTER TABLE `categoria_receita` ADD CONSTRAINT `categoria_receita_fk0` FOREIGN KEY (`fk_categoria`) REFERENCES `categoria`(`id`);

ALTER TABLE `categoria_receita` ADD CONSTRAINT `categoria_receita_fk1` FOREIGN KEY (`fk_receita`) REFERENCES `receita`(`id`);

ALTER TABLE `categoria_economia` ADD CONSTRAINT `categoria_economia_fk0` FOREIGN KEY (`fk_categoria`) REFERENCES `categoria`(`id`);

ALTER TABLE `categoria_economia` ADD CONSTRAINT `categoria_economia_fk1` FOREIGN KEY (`fk_economia`) REFERENCES `economia`(`id`);

ALTER TABLE `categoria_meta` ADD CONSTRAINT `categoria_meta_fk0` FOREIGN KEY (`fk_categoria`) REFERENCES `categoria`(`id`);

ALTER TABLE `categoria_meta` ADD CONSTRAINT `categoria_meta_fk1` FOREIGN KEY (`fk_meta`) REFERENCES `meta`(`id`);

