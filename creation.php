<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Creation Actualités, Chantier , Admins, - Admins</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="./assets/css/header.css">
    <link rel="stylesheet" href="./assets/css/style.css">
    <link rel="stylesheet" href="./assets/css/footer.css">
    <link rel="stylesheet" href="./assets/css/create.css">
</head>
<body>
    <?php require 'header.php'; ?>
    <main>
        <div>
            <h2>
                Bienvenue sur la page de création des actualités, chantiers et admins
            </h2>
            <p>
                Cette page est réservée aux administrateurs du site. Vous pouvez créer, modifier ou supprimer des actualités, des chantiers et des comptes administrateurs.
            </p>
            <div class="actions">
                <h3>Actions disponibles :</h3>
                <a href="admin_create.php">
                    <div class="blocks">Crée Admins</div>
                </a>
                <a href="actualite_create.php">
                    <div class="blocks">Crée Actualité</div>
                </a>
                <a href="chantier_create.php">
                    <div class="blocks">Crée Chantier</div>
                </a>
            </div>
        </div>
    </main>
    <?php
    require 'footer.php';
    ?>
</body>
</html>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <script src="./assets/JS/script.js"></script>