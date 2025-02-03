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

-- Ajout des utilisateurs avec des mots de passe hachés
INSERT INTO users (username, password, score, idRegion) VALUES
('alice', SHA2('password123', 256), 1200, 1),
('bob', SHA2('securepass', 256), 1500, 2),
('charlie', SHA2('guessme', 256), 800, 3),
('david', SHA2('12345678', 256), 950, 4),
('eva', SHA2('flagmaster', 256), 1700, 5),
('frank', SHA2('letmein', 256), 1100, 6);
