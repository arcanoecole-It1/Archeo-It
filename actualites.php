<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}
require 'database.php'; 
$estConnecte = isset($_SESSION['userIsLoggedIn']) && $_SESSION['userIsLoggedIn'];
// Si l'utilisateur est connecté, on affiche toutes les actualités, sinon on limite à 3.
$limit = $estConnecte ? null : 3;
// Requête pour récupérer les actualités
$query = "SELECT id, titre, description, image, date_creation FROM actualites ORDER BY date_creation DESC";
if ($limit !== null) {
    $query .= " LIMIT :limit";
}
$stmt = $pdo->prepare($query);
if ($limit !== null) {
    $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
}
$stmt->execute();
$actualites = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Actualités - ARCHEO-IT</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="./assets/css/header.css">
    <link rel="stylesheet" href="./assets/css/respoheader.css">
    <link rel="stylesheet" href="./assets/css/style.css">
    <link rel="stylesheet" href="./assets/css/footer.css">
    <link rel="stylesheet" href="./assets/css/actualites.css">
<body>
    <?php require 'header.php'; ?>
    <?php require 'respoheader.php'; ?> 
    <main>
        <div class="container py-5">
            <h1 class="mb-4"><?= $estConnecte ? 'Toutes les Actualités' : 'Dernières Actualités' ?></h1>
            <?php if (empty($actualites)): ?>
                <p class="text-center">Aucune actualité disponible pour le moment.</p>
            <?php else: ?>
                <div class="row">
                    <?php foreach ($actualites as $index => $actualite): ?>
                        <?php 
                        $descriptionComplete = $actualite['description'];
                        $longueurMinimale = 150; // Seuils de caractères pour afficher le bouton "Lire plus"
                        $doitAfficherBouton = strlen($descriptionComplete) > $longueurMinimale;
                        // Détermine si la description doit être initialement réduite
                        $estInitialementReduite = $doitAfficherBouton;
                        ?>
                        <div class="col-md-4 mb-4">
                            <div class="card h-100 shadow-sm">
                                <?php if (!empty($actualite['image'])): ?>
                                    <?php 
                                    $imagePath = $actualite['image']; // Chemin tel qu'il est dans la BDD
                                    $fileExists = file_exists($imagePath); // Vérifie si le fichier existe à ce chemin
                                    ?>
                                    <img src="<?= $imagePath ?>" class="card-img-top" alt="<?= $actualite['titre'] ?>" style="height: 200px; object-fit: cover;">
                                    <div class="debug-info text-center">
                                        Chemin Stocké : <code><?= $imagePath ?></code><br>
                                        Fichier Existe : <span style="color: <?= $fileExists ? 'green' : 'red' ?>;"><?= $fileExists ? 'Oui' : 'Non' ?></span>
                                    </div>
                                <?php else: ?>
                                    <div class="card-img-top bg-secondary d-flex align-items-center justify-content-center" style="height: 200px;">
                                        <span class="text-white fs-5">Pas d'image</span>
                                    </div>
                                    <div class="debug-info text-center">
                                        Aucune image associée.
                                    </div>
                                <?php endif; ?>
                                <div class="card-body d-flex flex-column">
                                    <h5 class="card-title"><?= $actualite['titre'] ?></h5>
                                    <div class="description-container flex-grow-1">
                                        <p class="card-text description-text <?= $estInitialementReduite ? 'collapsed' : 'expanded' ?>" id="desc-<?= $index ?>">
                                            <?= nl2br($descriptionComplete) ?>
                                        </p>
                                        <?php if ($doitAfficherBouton): ?>
                                            <button class="btn-lire-plus" onclick="toggleDescription(<?= $index ?>)" id="btn-<?= $index ?>">
                                                Lire plus
                                            </button>
                                        <?php endif; ?>
                                    </div>
                                    <p class="text-muted mt-auto">
                                        Publié le : <?= date('d/m/Y', $actualite['date_creation']) ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </main>
    <?php require 'footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <script src="./assets/JS/script.js"></script>
</body>
</html>