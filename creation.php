<?php
session_start();
// Vérification de connexion
if (!isset($_SESSION['userIsLoggedIn']) || !$_SESSION['userIsLoggedIn']) {
    header("Location: connexion.php");
    exit;
}
// Vérification admin
if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] != 1) {
    header("Location: index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Création - Administration</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="./assets/css/header.css">
    <link rel="stylesheet" href="./assets/css/style.css">
    <link rel="stylesheet" href="./assets/css/footer.css">
    <link rel="stylesheet" href="./assets/css/creation.css">
</head>
<body>
<?php require 'header.php'; ?>
    <main>
        <div class="creation-container">
            <div class="creation-header">
                <ion-icon name="create-outline" class="icon"></ion-icon>
                <h1>Panneau d'Administration</h1>
                <p>Bienvenue dans la section d'administration. Gérez les actualités, chantiers et administrateurs du site.</p>
            </div>
            
            <div class="actions">
                <h3>Actions disponibles :</h3>
                <div class="actions-grid">
                    <a href="create-admin.php" class="action-link">
                        <div class="blocks">
                            <ion-icon name="person-add-outline"></ion-icon>
                            <span>Créer Admin</span>
                        </div>
                    </a>
                    <a href="create-actualite.php" class="action-link">
                        <div class="blocks">
                            <ion-icon name="newspaper-outline"></ion-icon>
                            <span>Créer Actualité</span>
                        </div>
                    </a>
                    <a href="create-chantier.php" class="action-link">
                        <div class="blocks">
                            <ion-icon name="map-outline"></ion-icon>
                            <span>Créer Chantier</span>
                        </div>
                    </a>
                    <a href="create-event.php" class="action-link">
                        <div class="blocks">
                            <ion-icon name="calendar-outline"></ion-icon>
                            <span>Créer Événement</span>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </main>
</body>
    <?php require 'footer.php'; ?>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <script src="./assets/JS/script.js"></script>
</html>