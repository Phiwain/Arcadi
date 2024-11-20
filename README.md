# Arcadia

deploiement de l'application en local
  - creer un projet symfony sur sa machine
  - telecharger l'ensemble du projet depuis le dépot gitHub
  - ouvrir le .env et changer l'utilisateur,le mot de passe, l'adresse, le port et le nom de la database
  - (creation de l'ADMIN) dans le fichier de migration: changer l'email, le nom, le prenom et le password (avant l'encodage) afin qu'ils correspondent à vos souhait pour l'utilisateur ADMIN
      ou telecharger les fichier SQL pour creer la base donnée et y inserer les données USER grace au second fichier (ou via la commande
                  $connection = $entityManager->getConnection();
                  $sql = "INSERT INTO `user` (password, email, roles, nom, prenom) VALUES 
                  ('$2y$13$6NzlXwguj6gSQwxt1jOI6O28Q2LVc/siVk8nCf9RDE4GUCP2DLVny', 'admin@zooacardia.fr', '["ROLE_ADMIN"]', 'admin', 'admin')";
                  $connection->executeQuery($sql);

  - lancer votre serveur local (MAMP,XAMP, WAMP)
    Si utilisation de la migration
      - ouvrir le terminal de votre éditeur
      - taper la commande: symfony console doctrine:database:create
      - taper la commande: symfony console doctrine:migration:migrate
      - taper la commande: php composer.phar 
      - taper la commande: symfony server:start

  - ouvrir l'ip que le terminal vous donne (127.0.0.1:3306 en general)
