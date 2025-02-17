-- Réinitialisation et création de la base de données
DROP DATABASE IF EXISTS `guess_the_flag`;
CREATE DATABASE `guess_the_flag`;
USE `guess_the_flag`;

-- Création des tables
CREATE TABLE regions (
    `id` INT PRIMARY KEY AUTO_INCREMENT,
    `name` VARCHAR(50) NOT NULL
);

CREATE TABLE users (
    `id` INT PRIMARY KEY AUTO_INCREMENT,
    `username` VARCHAR(85) NOT NULL,
    `password` VARCHAR(255) NOT NULL,
    `score` INT NOT NULL,
    `isAdmin` BOOLEAN NOT NULL,
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
INSERT INTO users (`username`, `password`, `score`, `isAdmin`, `idRegion`) VALUES
('alice', '$2y$10$sTUmzLJrCVAjU/aNDn4QsOZIfVfHWByI0lO0G5TAAUfdyP2n5EVT2', 256, 0, 1), -- mdp : password123
('bob', '$2y$10$rruuMGHZoDbIGBh7b4bcquDKjBakEOpJdWPHlwJeBUAyeyXKG/JgK', 1500, 0, 2), -- mdp : securepass
('Etienne', '$2y$10$D4Ji5l/XGzgJ7lAIGgzJ/OMTakLagaijNoZZpil5nYW.l.1Nu/g02', 0, 1, 1); -- mdp : Super
