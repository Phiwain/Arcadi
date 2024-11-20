-- Insertion des utilisateurs dans la table `user`

INSERT INTO `user` (password, email, roles, nom, prenom) VALUES
-- Administrateur
('$2y$13$6NzlXwguj6gSQwxt1jOI6O28Q2LVc/siVk8nCf9RDE4GUCP2DLVny', 'admin@zooacardia.fr', '["ROLE_ADMIN"]', 'admin', 'admin'),
-- Employée
('$2y$13$6NzlXwguj6gSQwxt1jOI6O28Q2LVc/siVk8nCf9RDE4GUCP2DLVny', 'employee@zooacardia.fr', '["ROLE_EMPLOYEE"]', 'employee', 'employee'),
-- Veterinaire
('$2y$13$6NzlXwguj6gSQwxt1jOI6O28Q2LVc/siVk8nCf9RDE4GUCP2DLVny', 'veterinaire@zooacardia.fr', '["ROLE_VETERINAIRE"]', 'veterinaire', 'veterinaire'),


