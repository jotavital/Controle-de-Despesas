-- MySQL Script generated by MySQL Workbench
-- Tue Jun 15 20:59:30 2021
-- Model: New Model    Version: 1.0
-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema easylize_financas
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema easylize_financas
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `easylize_financas` DEFAULT CHARACTER SET utf8mb4 ;
USE `easylize_financas` ;

-- -----------------------------------------------------
-- Table `easylize_financas`.`usuario`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `easylize_financas`.`usuario` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(255) NOT NULL,
  `sobrenome` VARCHAR(255) NOT NULL,
  `email` VARCHAR(200) NOT NULL,
  `senha` VARCHAR(100) NOT NULL,
  `data_cadastro` DATE NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `email_UNIQUE` (`email` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `easylize_financas`.`tipo_categoria`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `easylize_financas`.`tipo_categoria` (
  `id` INT NOT NULL,
  `descricao` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `easylize_financas`.`categoria`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `easylize_financas`.`categoria` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `nome_categoria` VARCHAR(255) NOT NULL,
  `fk_tipo` INT NOT NULL,
  `fk_usuario` INT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_tipo_categoria_idx` (`fk_tipo` ASC),
  INDEX `fk_usuario_categoria_idx` (`fk_usuario` ASC),
  CONSTRAINT `fk_tipo_categoria`
    FOREIGN KEY (`fk_tipo`)
    REFERENCES `easylize_financas`.`tipo_categoria` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_usuario_categoria`
    FOREIGN KEY (`fk_usuario`)
    REFERENCES `easylize_financas`.`usuario` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `easylize_financas`.`conta`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `easylize_financas`.`conta` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `nome_conta` VARCHAR(45) NOT NULL,
  `saldo_atual` DECIMAL(11,2) NOT NULL,
  `fk_usuario` INT NOT NULL,
  `fk_categoria` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_usuario_conta_idx` (`fk_usuario` ASC),
  INDEX `fk_catetgoria_idx` (`fk_categoria` ASC),
  CONSTRAINT `fk_usuario_conta`
    FOREIGN KEY (`fk_usuario`)
    REFERENCES `easylize_financas`.`usuario` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_catetgoria`
    FOREIGN KEY (`fk_categoria`)
    REFERENCES `easylize_financas`.`categoria` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `easylize_financas`.`despesa`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `easylize_financas`.`despesa` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `descricao_despesa` VARCHAR(255) NOT NULL,
  `imagem` VARCHAR(255) NULL,
  `data_despesa` DATE NOT NULL,
  `data_vencimento` DATE NULL,
  `valor` DECIMAL(11,2) NOT NULL,
  `data_inclusao` DATE NOT NULL,
  `tipo` VARCHAR(45) NOT NULL DEFAULT 'despesa',
  `fk_conta` INT NOT NULL,
  `fk_usuario` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_conta_despesa_idx` (`fk_conta` ASC),
  INDEX `fk_usuario_despesa_idx` (`fk_usuario` ASC),
  CONSTRAINT `fk_conta_despesa`
    FOREIGN KEY (`fk_conta`)
    REFERENCES `easylize_financas`.`conta` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_usuario_despesa`
    FOREIGN KEY (`fk_usuario`)
    REFERENCES `easylize_financas`.`usuario` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `easylize_financas`.`categoria_despesa`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `easylize_financas`.`categoria_despesa` (
  `fk_categoria` INT NOT NULL,
  `fk_despesa` INT NOT NULL,
  INDEX `categoria_despesa_fk1` (`fk_despesa` ASC),
  PRIMARY KEY (`fk_categoria`, `fk_despesa`),
  CONSTRAINT `categoria_despesa_fk0`
    FOREIGN KEY (`fk_categoria`)
    REFERENCES `easylize_financas`.`categoria` (`id`),
  CONSTRAINT `categoria_despesa_fk1`
    FOREIGN KEY (`fk_despesa`)
    REFERENCES `easylize_financas`.`despesa` (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `easylize_financas`.`receita`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `easylize_financas`.`receita` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `descricao_receita` VARCHAR(255) NOT NULL,
  `data_receita` DATE NULL,
  `valor` DECIMAL(11,2) NOT NULL,
  `data_inclusao` DATE NOT NULL,
  `tipo` VARCHAR(45) NOT NULL DEFAULT 'receita',
  `fk_usuario` INT NOT NULL,
  `fk_conta` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_usuario` (`fk_usuario` ASC),
  INDEX `fk_conta_receita_idx` (`fk_conta` ASC),
  CONSTRAINT `fk_usuario`
    FOREIGN KEY (`fk_usuario`)
    REFERENCES `easylize_financas`.`usuario` (`id`),
  CONSTRAINT `fk_conta_receita`
    FOREIGN KEY (`fk_conta`)
    REFERENCES `easylize_financas`.`conta` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `easylize_financas`.`meta`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `easylize_financas`.`meta` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `nome_meta` VARCHAR(255) NOT NULL,
  `descricao_meta` VARCHAR(255) NOT NULL,
  `prazo_meta` DATE NOT NULL,
  `valor_total` DECIMAL(11,2) NOT NULL,
  `valor_atingido` DECIMAL(11,2) NOT NULL,
  `fk_usuario` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_usuario_meta` (`fk_usuario` ASC),
  CONSTRAINT `fk_usuario_meta`
    FOREIGN KEY (`fk_usuario`)
    REFERENCES `easylize_financas`.`usuario` (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `easylize_financas`.`categoria_receita`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `easylize_financas`.`categoria_receita` (
  `fk_categoria` INT NOT NULL,
  `fk_receita` INT NOT NULL,
  INDEX `categoria_receita_fk1` (`fk_receita` ASC),
  PRIMARY KEY (`fk_categoria`, `fk_receita`),
  CONSTRAINT `categoria_receita_fk0`
    FOREIGN KEY (`fk_categoria`)
    REFERENCES `easylize_financas`.`categoria` (`id`),
  CONSTRAINT `categoria_receita_fk1`
    FOREIGN KEY (`fk_receita`)
    REFERENCES `easylize_financas`.`receita` (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `easylize_financas`.`categoria_meta`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `easylize_financas`.`categoria_meta` (
  `fk_categoria` INT NOT NULL,
  `fk_meta` INT NOT NULL,
  INDEX `categoria_meta_fk1` (`fk_meta` ASC),
  PRIMARY KEY (`fk_categoria`, `fk_meta`),
  CONSTRAINT `categoria_meta_fk0`
    FOREIGN KEY (`fk_categoria`)
    REFERENCES `easylize_financas`.`categoria` (`id`),
  CONSTRAINT `categoria_meta_fk1`
    FOREIGN KEY (`fk_meta`)
    REFERENCES `easylize_financas`.`meta` (`id`))
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

-- -----------------------------------------------------
-- Data for table `easylize_financas`.`tipo_categoria`
-- -----------------------------------------------------
START TRANSACTION;
USE `easylize_financas`;
INSERT INTO `easylize_financas`.`tipo_categoria` (`id`, `descricao`) VALUES (2, 'Meta');
INSERT INTO `easylize_financas`.`tipo_categoria` (`id`, `descricao`) VALUES (3, 'Despesa');
INSERT INTO `easylize_financas`.`tipo_categoria` (`id`, `descricao`) VALUES (4, 'Receita');
INSERT INTO `easylize_financas`.`tipo_categoria` (`id`, `descricao`) VALUES (5, 'Conta');
INSERT INTO `easylize_financas`.`tipo_categoria` (`id`, `descricao`) VALUES (1, 'Reajuste');

COMMIT;


-- -----------------------------------------------------
-- Data for table `easylize_financas`.`categoria`
-- -----------------------------------------------------
START TRANSACTION;
USE `easylize_financas`;
INSERT INTO `easylize_financas`.`categoria` (`id`, `nome_categoria`, `fk_tipo`, `fk_usuario`) VALUES (1, 'Conta corrente', 5, NULL);
INSERT INTO `easylize_financas`.`categoria` (`id`, `nome_categoria`, `fk_tipo`, `fk_usuario`) VALUES (2, 'Poupança', 5, NULL);
INSERT INTO `easylize_financas`.`categoria` (`id`, `nome_categoria`, `fk_tipo`, `fk_usuario`) VALUES (3, 'Carteira', 5, NULL);
INSERT INTO `easylize_financas`.`categoria` (`id`, `nome_categoria`, `fk_tipo`, `fk_usuario`) VALUES (4, 'Outros', 5, NULL);
INSERT INTO `easylize_financas`.`categoria` (`id`, `nome_categoria`, `fk_tipo`, `fk_usuario`) VALUES (5, 'Salário', 4, NULL);
INSERT INTO `easylize_financas`.`categoria` (`id`, `nome_categoria`, `fk_tipo`, `fk_usuario`) VALUES (6, 'Investimento', 4, NULL);
INSERT INTO `easylize_financas`.`categoria` (`id`, `nome_categoria`, `fk_tipo`, `fk_usuario`) VALUES (7, 'Pagamentos', 4, NULL);
INSERT INTO `easylize_financas`.`categoria` (`id`, `nome_categoria`, `fk_tipo`, `fk_usuario`) VALUES (8, 'Carro', 3, NULL);
INSERT INTO `easylize_financas`.`categoria` (`id`, `nome_categoria`, `fk_tipo`, `fk_usuario`) VALUES (9, 'Casa', 3, NULL);
INSERT INTO `easylize_financas`.`categoria` (`id`, `nome_categoria`, `fk_tipo`, `fk_usuario`) VALUES (10, 'Alimentação', 3, NULL);
INSERT INTO `easylize_financas`.`categoria` (`id`, `nome_categoria`, `fk_tipo`, `fk_usuario`) VALUES (11, 'Lazer', 3, NULL);
INSERT INTO `easylize_financas`.`categoria` (`id`, `nome_categoria`, `fk_tipo`, `fk_usuario`) VALUES (12, 'Compras', 3, NULL);
INSERT INTO `easylize_financas`.`categoria` (`id`, `nome_categoria`, `fk_tipo`, `fk_usuario`) VALUES (13, 'Saúde', 3, NULL);
INSERT INTO `easylize_financas`.`categoria` (`id`, `nome_categoria`, `fk_tipo`, `fk_usuario`) VALUES (14, 'Pagamentos', 3, NULL);
INSERT INTO `easylize_financas`.`categoria` (`id`, `nome_categoria`, `fk_tipo`, `fk_usuario`) VALUES (15, 'Transporte', 3, NULL);
INSERT INTO `easylize_financas`.`categoria` (`id`, `nome_categoria`, `fk_tipo`, `fk_usuario`) VALUES (16, 'Lazer', 2, NULL);
INSERT INTO `easylize_financas`.`categoria` (`id`, `nome_categoria`, `fk_tipo`, `fk_usuario`) VALUES (17, 'Outros', 4, NULL);
INSERT INTO `easylize_financas`.`categoria` (`id`, `nome_categoria`, `fk_tipo`, `fk_usuario`) VALUES (18, 'Outros', 3, NULL);
INSERT INTO `easylize_financas`.`categoria` (`id`, `nome_categoria`, `fk_tipo`, `fk_usuario`) VALUES (19, 'Reajuste', 1, NULL);

COMMIT;

