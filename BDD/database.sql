-- Base de données TechSolutionFinal
CREATE DATABASE IF NOT EXISTS TechSolutionFinal;
USE TechSolutionFinal;

-- Table des composants
CREATE TABLE composant (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nom VARCHAR(100) NOT NULL,
    type ENUM('processeur', 'ram', 'stockage', 'carte_graphique') NOT NULL,
    marque VARCHAR(50),
    prix DECIMAL(10,2)
);

-- Table des PC
CREATE TABLE pc (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nom VARCHAR(100) NOT NULL,
    description TEXT,
    prix DECIMAL(10,2) NOT NULL,
    stock INT DEFAULT 0
);

-- Table de liaison PC-Composants
CREATE TABLE Id_pc (
    id INT PRIMARY KEY AUTO_INCREMENT,
    pc_id INT,
    composant_id INT,
    quantite INT DEFAULT 1,
    FOREIGN KEY (pc_id) REFERENCES pc(id) ON DELETE CASCADE,
    FOREIGN KEY (composant_id) REFERENCES composant(id) ON DELETE CASCADE
);

-- Table des actualités
CREATE TABLE actualites (
    id INT PRIMARY KEY AUTO_INCREMENT,
    titre VARCHAR(200) NOT NULL,
    contenu TEXT NOT NULL,
    date_publication TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Table des messages de contact
CREATE TABLE contacts (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nom VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    message TEXT NOT NULL,
    date_creation TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Table des utilisateurs admin
CREATE TABLE users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL
);

-- Données de test
INSERT INTO users (username, password) VALUES ('admin', 'admin123');

INSERT INTO composant (nom, type, marque, prix) VALUES
('Intel Core i5-12400F', 'processeur', 'Intel', 199.99),
('AMD Ryzen 5 5600X', 'processeur', 'AMD', 229.99),
('16GB DDR4 3200MHz', 'ram', 'Corsair', 79.99),
('SSD 500GB NVMe', 'stockage', 'Samsung', 69.99),
('RTX 3060', 'carte_graphique', 'NVIDIA', 329.99);

INSERT INTO pc (nom, description, prix, stock) VALUES
('PC Gaming Pro', 'PC gaming haute performance pour les jeux récents', 899.99, 5),
('PC Bureau Standard', 'PC pour usage bureautique et navigation web', 549.99, 8),
('PC Workstation', 'PC professionnel pour le travail intensif', 1299.99, 3);

INSERT INTO Id_pc (pc_id, composant_id, quantite) VALUES
(1, 2, 1), (1, 3, 1), (1, 4, 1), (1, 5, 1),
(2, 1, 1), (2, 3, 1), (2, 4, 1),
(3, 2, 1), (3, 3, 2), (3, 4, 2), (3, 5, 1);

INSERT INTO actualites (titre, contenu) VALUES
('Nouvelle gamme de PC gaming', 'Découvrez notre nouvelle gamme de PC gaming haute performance avec les derniers processeurs Intel et cartes graphiques NVIDIA.'),
('Extension de nos services', 'TechSolutions étend ses services de développement logiciel pour mieux vous accompagner.');