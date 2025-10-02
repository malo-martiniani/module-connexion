-- Base de données: module_connexion

CREATE DATABASE IF NOT EXISTS module_connexion;
USE module_connexion;

-- Structure de la table utilisateurs
CREATE TABLE IF NOT EXISTS utilisateurs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    login VARCHAR(255) UNIQUE NOT NULL,
    prenom VARCHAR(255) NOT NULL,
    nom VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL
);

-- Insertion de l'utilisateur admin
INSERT INTO utilisateurs (login, prenom, nom, password) VALUES ('admin', 'admin', 'admin', 'admin');
