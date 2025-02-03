-- Réinitialisation et création de la base de données
DROP DATABASE IF EXISTS `guess_the_flag`;
CREATE DATABASE `guess_the_flag`;
USE `guess_the_flag`;

-- Création des tables
CREATE TABLE regions (
	`id` INT PRIMARY KEY AUTO_INCREMENT,
	`name` VARCHAR(50) NOT NULL,
    ON DELETE CASCADE,
    ON UPDATE CASCADE
);

CREATE TABLE users (
	`id` INT PRIMARY KEY AUTO_INCREMENT,
	`username` VARCHAR(50) NOT NULL,
	`password` CHAR(64) NOT NULL,
	`score` INT NOT NULL,
	`idRegion` INT NOT NULL,
	FOREIGN KEY (`idRegion`) REFERENCES regions(`id`)
);

-- Ajout des régions
INSERT INTO regions (name) VALUES
('Europe'),
('Asie'),
('Afrique'),
('Amérique du Nord'),
('Amérique du Sud'),
('Océanie');