<?php
require 'database.php';

// Vérifier si la table est vide
$stmt = $pdo->query("SELECT COUNT(*) FROM chantiers");
$count = $stmt->fetchColumn();

if ($count == 0) {
    try {
        $stmt = $pdo->prepare("
            INSERT INTO chantiers (nom, description, image, localisation, date_debut, date_fin, statut) VALUES
            ('Fouilles Romaines', 'Exploration des ruines d\'une ancienne cité romaine.', './assets/images/acceuil.jpg', 'Italie', '2025-06-01', '2025-07-30', 'actif'),
            ('Site Médiéval', 'Recherche archéologique sur un château fort médiéval.', './assets/images/medieval.jpg', 'France', '2025-07-15', '2025-08-15', 'planifie'),
            ('Pyramide Perdue', 'Découverte d\'une pyramide inconnue en Amérique du Sud.', './assets/images/pyramide.jpg', 'Pérou', '2025-05-10', '2025-06-20', 'termine')
        ");
        $stmt->execute();
        echo "<div class='alert alert-success text-center'>Les chantiers ont été insérés automatiquement.</div>";
    } catch (PDOException $e) {
        echo "<div class='alert alert-danger' role='alert'>Erreur lors de l'ajout des chantiers : " . $e->getMessage() . "</div>";
    }
}

// Récupérer tous les chantiers (triés par ID décroissant)
try {
    $stmt = $pdo->query("SELECT * FROM chantiers ORDER BY id DESC");
    $chantiers = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "<div class='alert alert-danger' role='alert'>Erreur lors de la récupération des chantiers.</div>";
    $chantiers = [];
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chantiers de Fouilles</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="./assets/css/header.css">
    <link rel="stylesheet" href="./assets/css/respoheader.css">
    <link rel="stylesheet" href="./assets/css/style.css">
    <link rel="stylesheet" href="./assets/css/footer.css">
    <link rel="stylesheet" href="./assets/css/chantier.css">
</head>

<?php require 'header.php'; ?>
<?php include 'respoheader.php'; ?>

<body>
<main class="container">
    <h1 class="text-center mb-4">Nos Chantiers de Fouilles</h1>
    <div class="row justify-content-center">
        <?php if (!empty($chantiers)): ?>
            <?php foreach ($chantiers as $chantier): ?>
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <?php if (!empty($chantier['image'])): ?>
                            <img src="<?= htmlspecialchars($chantier['image']) ?>" class="card-img-top" alt="<?= htmlspecialchars($chantier['nom']) ?>">
                        <?php else: ?>
                            <img src="./assets/images/gergovie.jpg" class="card-img-top" alt="Image par défaut">
                        <?php endif; ?>
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($chantier['nom']) ?></h5>
                            <p class="card-text"><?= htmlspecialchars($chantier['description']) ?></p>

                            <?php if (!empty($chantier['localisation'])): ?>
                                <p class="text-muted">
                                    <ion-icon name="location-outline"></ion-icon>
                                    <?= htmlspecialchars($chantier['localisation']) ?>
                                </p>
                            <?php endif; ?>

                            <?php if (!empty($chantier['date_debut'])): ?>
                                <p class="text-muted">
                                    <ion-icon name="calendar-outline"></ion-icon>
                                    Début : <?= date('d/m/Y', strtotime($chantier['date_debut'])) ?>
                                    <?php if (!empty($chantier['date_fin'])): ?>
                                        - Fin : <?= date('d/m/Y', strtotime($chantier['date_fin'])) ?>
                                    <?php endif; ?>
                                </p>
                            <?php endif; ?>

                            <span class="badge 
                                <?php 
                                    switch ($chantier['statut']) {
                                        case 'actif': echo 'bg-success'; break;
                                        case 'planifie': echo 'bg-warning'; break;
                                        case 'termine': echo 'bg-secondary'; break;
                                        default: echo 'bg-primary';
                                    }
                                ?>">
                                <?= ucfirst(htmlspecialchars($chantier['statut'])) ?>
                            </span>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-12">
                <div class="alert alert-info text-center">
                    <h4>Aucun chantier disponible</h4>
                    <p>Il n'y a actuellement aucun chantier de fouilles disponible.</p>
                    <?php if (isset($_SESSION['userIsLoggedIn']) && $_SESSION['userIsLoggedIn']): ?>
                        <?php
                        // Vérifier si l'utilisateur est admin
                        $stmt = $pdo->prepare("SELECT is_admin FROM users WHERE id = ?");
                        $stmt->execute([$_SESSION['user_id']]);
                        $user = $stmt->fetch();
                        if ($user && $user['is_admin'] == 1): ?>
                            <a href="create-chantier.php" class="btn btn-primary">
                                <ion-icon name="add-outline"></ion-icon> Créer le premier chantier
                            </a>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
            </div>
        <?php endif; ?>
    </div>
</main>

<?php require 'footer.php'; ?>
<script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
<script src="./assets/JS/script.js"></script>
</body>
</html>