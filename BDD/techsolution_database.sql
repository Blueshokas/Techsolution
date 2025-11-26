-- Base de données techsolution
CREATE DATABASE IF NOT EXISTS techsolution;
USE techsolution;

-- Table des PC
CREATE TABLE IF NOT EXISTS pcs (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nom VARCHAR(100) NOT NULL,
    description TEXT,
    prix DECIMAL(10,2) NOT NULL,
    stock INT DEFAULT 0,
    actif TINYINT(1) DEFAULT 1
);

-- Table des actualités
CREATE TABLE IF NOT EXISTS actualites (
    id INT PRIMARY KEY AUTO_INCREMENT,
    titre VARCHAR(200) NOT NULL,
    contenu TEXT NOT NULL,
    date_publication TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    actif TINYINT(1) DEFAULT 1
);

-- Table des messages de contact
CREATE TABLE IF NOT EXISTS contacts (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nom VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    message TEXT NOT NULL,
    date_creation TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    lu TINYINT(1) DEFAULT 0
);

-- Données de test pour les PC
INSERT INTO pcs (nom, description, prix, stock) VALUES
('PC Gaming Pro', 'PC gaming haute performance avec RTX 4060, Intel i5-12400F, 16GB RAM, SSD 1TB', 899.99, 5),
('PC Bureau Standard', 'PC pour usage bureautique avec Intel i3, 8GB RAM, SSD 256GB', 549.99, 8),
('PC Workstation', 'PC professionnel pour le travail intensif avec AMD Ryzen 7, 32GB RAM, SSD 2TB', 1299.99, 3),
('PC Gaming Elite', 'PC gaming ultra haute performance avec RTX 4080, Intel i7-13700K, 32GB RAM', 1899.99, 2);

-- Données de test pour les actualités
INSERT INTO actualites (titre, contenu) VALUES
('Nouvelle gamme de PC gaming 2024', 'Découvrez notre nouvelle gamme de PC gaming haute performance avec les derniers processeurs Intel 13ème génération et cartes graphiques RTX 4000.'),
('Extension de nos services', 'TechSolutions étend ses services de développement logiciel et de maintenance informatique pour mieux vous accompagner.'),
('Promotion spéciale rentrée', 'Profitez de -15% sur tous nos PC bureautique jusqu\'au 30 septembre. Idéal pour équiper votre bureau ou votre domicile.');

-- Données de test pour les contacts
INSERT INTO contacts (nom, email, message) VALUES
('Jean Dupont', 'jean.dupont@email.com', 'Bonjour, je souhaiterais avoir plus d\'informations sur le PC Gaming Pro.'),
('Marie Martin', 'marie.martin@email.com', 'Proposez-vous un service de maintenance pour les PC achetés chez vous ?');