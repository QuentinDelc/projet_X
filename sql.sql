-- MySQL Script generated by MySQL Workbench
-- Fri Sep 21 09:49:09 2018
-- Model: New Model    Version: 1.0
-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema projet_x
-- -----------------------------------------------------



-- -----------------------------------------------------
-- Table `projet_x`.`user`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `projet_x`.`user` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `username` VARCHAR(255) NOT NULL,
  `email` VARCHAR(255) NOT NULL,
  `confirmedAt` DATETIME NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  `confirmationToken` VARCHAR(60) NOT NULL,
  `isAdmin` TINYINT NOT NULL DEFAULT 0,
  `resetToken` VARCHAR(60) NULL,
  `resetAt` DATETIME NULL,
  `rememberToken` VARCHAR(60) NULL,
  PRIMARY KEY (`id`))
  ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `projet_x`.`difficulty`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `projet_x`.`difficulty` (
  `Id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`Id`))
  ENGINE = InnoDB;



-- -----------------------------------------------------
-- Schema projet_x
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `projet_x` DEFAULT CHARACTER SET utf8 ;
USE `projet_x` ;

CREATE TABLE IF NOT EXISTS `projet_x`.`article` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL,
  `description` VARCHAR(255) NOT NULL,
  `content` LONGTEXT NOT NULL,
  `slug` VARCHAR(255) NOT NULL,
  `difficultyId` INT NOT NULL,
  `authorId` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_article_user1_idx` (`authorId` ASC),
  INDEX `fk_article_difficulty1_idx` (`difficultyId` ASC))
  ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `projet_x`.`image`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `projet_x`.`image` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL,
  `articleId` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_image_article1_idx` (`articleId` ASC))
  ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `projet_x`.`comment`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `projet_x`.`comment` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `message` MEDIUMTEXT NULL,
  `date` DATETIME NULL,
  `userId` INT NOT NULL,
  `articleId` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_comments_users1_idx` (`userId` ASC),
  INDEX `fk_comments_articles1_idx` (`articleId` ASC))
  ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `projet_x`.`material`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `projet_x`.`material` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL,
  `parentId` VARCHAR(45) NULL,
  PRIMARY KEY (`id`))
  ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `projet_x`.`category`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `projet_x`.`category` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL,
  `slug` VARCHAR(255) NOT NULL,
  `parentId` INT NULL,
  PRIMARY KEY (`id`))
  ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `projet_x`.`category_article`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `projet_x`.`category_article` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `categoryId` INT NOT NULL,
  `articleId` INT NOT NULL,
  INDEX `fk_categorie_article_categorie1_idx` (`categoryId` ASC),
  INDEX `fk_categorie_article_article1_idx` (`articleId` ASC),
  PRIMARY KEY (`id`))
  ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `projet_x`.`material_article`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `projet_x`.`material_article` (
  `materialId` INT NOT NULL,
  `articleId` INT NOT NULL,
  INDEX `fk_material_article_material1_idx` (`materialId` ASC),
  INDEX `fk_material_article_article1_idx` (`articleId` ASC))
  ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `projet_x`.`pdf`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `projet_x`.`pdf` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL,
  `articleId` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_pdf_article1_idx` (`articleId` ASC))
  ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
