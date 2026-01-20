-- Ajouter la colonne role à la table users
ALTER TABLE users ADD COLUMN role ENUM('admin', 'technicien', 'utilisateur') DEFAULT 'utilisateur' AFTER password;

-- Mettre à jour les utilisateurs existants en admin
UPDATE users SET role = 'admin';
