<?php
require 'database.php';
session_start();
// Vérification de la session pour savoir si l'utilisateur est connecté
$estConnecte = isset($_SESSION['userIsLoggedIn']) && $_SESSION['userIsLoggedIn'];
// Si l'utilisateur est connecté, on affiche toutes les actualités
$limit = $estConnecte ? null : 3; // Limite à 3 si non connecté

$query = "SELECT * FROM actualites  ORDER BY date_creation DESC";
if ($limit !== null) {
    $query .= " LIMIT $limit";
}

$stmt = $pdo->prepare($query);
$stmt->execute();
$actualites = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
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
    <div class="container py-5">
        <h1 class="mb-4"><?= $estConnecte ? 'Toutes les Actualités' : 'Dernières Actualités' ?></h1>
        
        <?php if (empty($actualites)): ?>
            <p class="text-center">Aucune actualité disponible pour le moment.</p>
        <?php else: ?>
            <div class="row">
                <?php foreach ($actualites as $actualite): ?>
                    <div class="col-md-4 mb-4">
                        <div class="card h-100 shadow-sm">
                            <?php if (!empty($actualite['image'])): ?>
                                <img src="<?= htmlspecialchars($actualite['image']) ?>" class="card-img-top" alt="<?= htmlspecialchars($actualite['titre']) ?>" style="height: 200px; object-fit: cover;">
                            <?php endif; ?>
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title"><?= htmlspecialchars($actualite['titre']) ?></h5>
                                <p class="card-text flex-grow-1"><?= nl2br(htmlspecialchars(substr($actualite['description'], 0, 100))) ?>...</p>
                                <p class="text-muted mt-auto">
                                    Publié le : <?= date('d/m/Y', $actualite['date_creation']) ?>
                                </p>
                                <a href="single-actualite.php?id=<?= $actualite['id'] ?>" class="btn btn-primary mt-2">Voir plus</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</main>
<?php require 'footer.php'; ?>
</body>
</html>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <script src="./assets/JS/script.js"></script>