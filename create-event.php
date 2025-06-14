<?php
session_start();
// Vérification de connexion
if (!isset($_SESSION['userIsLoggedIn']) || !$_SESSION['userIsLoggedIn']) {
    header("Location: login.php");
    exit;
}
// Vérification admin
if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] != 1) {
    header("Location: index.php");
    exit;
}
include 'database.php';
$success = '';
$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $titre = htmlspecialchars(trim($_POST["titre"]));
    $description = htmlspecialchars(trim($_POST["description"]));
    $date_evenement = $_POST["date_evenement"];
    $heure_evenement = !empty($_POST["heure_evenement"]) ? $_POST["heure_evenement"] : null;
    $lieu = htmlspecialchars(trim($_POST["lieu"]));
    $created_by = $_SESSION['user_id'];

    if (!empty($titre) && !empty($description) && !empty($date_evenement)) {
        try {
            $stmt = $pdo->prepare("INSERT INTO agenda (titre, description, date_evenement, heure_evenement, lieu, created_by) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->execute([$titre, $description, $date_evenement, $heure_evenement, $lieu, $created_by]);
            $success = "Événement créé avec succès !";
            
            // Réinitialiser les champs
            $titre = '';
            $description = '';
            $lieu = '';
        } catch (PDOException $e) {
            $error = "Erreur lors de la création de l'événement.";
        }
    } else {
        $error = "Veuillez remplir tous les champs obligatoires.";
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Archeo - It Création Événement</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./assets/css/header.css">
    <link rel="stylesheet" href="./assets/css/respoheader.css">
    <link rel="stylesheet" href="./assets/css/footer.css">
    <link rel="stylesheet" href="./assets/css/contact.css">
</head>
<body>
<?php include 'header.php'; ?>
<?php include 'respoheader.php'; ?>
<div class="contact-container">
    <h2 class="text-center mb-4">
        <i class="bi bi-calendar-plus me-2"></i> CRÉER UN ÉVÉNEMENT
    </h2>
    <?php if ($success): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= htmlspecialchars($success) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <?php if ($error): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?= htmlspecialchars($error) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>
    <form method="POST" action="">
        <div class="mb-3">
            <label class="form-label"><i class="bi bi-type me-1"></i>Titre de l'événement :</label>
            <input type="text" name="titre" class="form-control" required 
                   value="<?= isset($titre) ? htmlspecialchars($titre) : '' ?>">
        </div>
        
        <div class="mb-3">
            <label class="form-label"><i class="bi bi-text-paragraph me-1"></i>Description :</label>
            <textarea name="description" class="form-control" rows="4" required><?= isset($description) ? htmlspecialchars($description) : '' ?></textarea>
        </div>
        
        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label"><i class="bi bi-calendar me-1"></i>Date :</label>
                <input type="date" name="date_evenement" class="form-control" required 
                       min="<?= date('Y-m-d') ?>"
                       value="<?= isset($date_evenement) ? $date_evenement : '' ?>">
            </div>
            
            <div class="col-md-6 mb-3">
                <label class="form-label"><i class="bi bi-clock me-1"></i>Heure (optionnel) :</label>
                <input type="time" name="heure_evenement" class="form-control"
                       value="<?= isset($heure_evenement) ? $heure_evenement : '' ?>">
            </div>
        </div>
        
        <div class="mb-3">
            <label class="form-label"><i class="bi bi-geo-alt me-1"></i>Lieu :</label>
            <input type="text" name="lieu" class="form-control" 
                   placeholder="Ex: Musée d'Archéologie, Paris"
                   value="<?= isset($lieu) ? htmlspecialchars($lieu) : '' ?>">
        </div>
        <div class="d-flex justify-content-between">
            <button type="submit" class="btn btn-send">
                <i class="bi bi-plus-circle me-1"></i>CRÉER L'ÉVÉNEMENT
            </button>
        </div>
        <div class="text-center mt-3">
            <a href="creation.php" class="text-decoration-none">← Retour au panneau d'administration</a>
        </div>
    </form>
</div>
</body>
<?php include 'footer.php'; ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
<script src="./assets/JS/script.js"></script>
</html>