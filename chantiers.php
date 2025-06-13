<?php
require 'database.php';
// Récupérer tous les chantiers depuis la base de données
try {
    $stmt = $pdo->query("SELECT * FROM chantiers ORDER BY created_at DESC");
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="./assets/css/header.css">
    <link rel="stylesheet" href="./assets/css/style.css">
    <link rel="stylesheet" href="./assets/css/footer.css">
    <link rel="stylesheet" href="./assets/css/chantier.css">
</head>
<?php require 'header.php'; ?>
<body>
<main class="container">
    <h1 class="text-center mb-4">Nos Chantiers de Fouilles</h1>
    <div class="row">
        <?php if (!empty($chantiers)): ?>
            <?php foreach ($chantiers as $chantier): ?>
                <div class="card-chantier">
                    <div class="card">
                        <?php if (!empty($chantier['image'])): ?>
                            <img src="<?= htmlspecialchars($chantier['image']) ?>" class="card-img-top" alt="<?= htmlspecialchars($chantier['nom']) ?>">
                        <?php else: ?>
                            <img src="./assets/images/default-chantier.jpg" class="card-img-top" alt="Image par défaut">
                        <?php endif; ?>
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($chantier['nom']) ?></h5>
                            <p class="card-text"><?= htmlspecialchars($chantier['description']) ?></p>
                            
                            <?php if (!empty($chantier['localisation'])): ?>
                                <p class="text-muted">
                                    <small>
                                        <ion-icon name="location-outline"></ion-icon> 
                                        <?= htmlspecialchars($chantier['localisation']) ?>
                                    </small>
                                </p>
                            <?php endif; ?>
                            
                            <?php if (!empty($chantier['date_debut'])): ?>
                                <p class="text-muted">
                                    <small>
                                        <ion-icon name="calendar-outline"></ion-icon> 
                                        Début : <?= date('d/m/Y', strtotime($chantier['date_debut'])) ?>
                                        <?php if (!empty($chantier['date_fin'])): ?>
                                            - Fin : <?= date('d/m/Y', strtotime($chantier['date_fin'])) ?>
                                        <?php endif; ?>
                                    </small>
                                </p>
                            <?php endif; ?>
                            
                            <span class="badge 
                                <?php 
                                    switch($chantier['statut']) {
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
                        // Vérifier si l'utilisateur est admin pour afficher le lien de création
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