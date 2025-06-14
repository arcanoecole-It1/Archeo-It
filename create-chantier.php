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
    $nom = htmlspecialchars(trim($_POST["nom"]));
    $description = htmlspecialchars(trim($_POST["description"]));
    $localisation = htmlspecialchars(trim($_POST["localisation"]));
    $date_debut = $_POST["date_debut"];
    $date_fin = !empty($_POST["date_fin"]) ? $_POST["date_fin"] : null;
    $statut = $_POST["statut"];

    if (!empty($nom) && !empty($description) && !empty($localisation) && !empty($date_debut) && !empty($statut)) {
        // Gestion de l'image
        $image_path = null;
        if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
            $target_dir = "uploads/chantiers/";
            
            // Créer le dossier s'il n'existe pas
            if (!file_exists($target_dir)) {
                mkdir($target_dir, 0777, true);
            }
            
            $file_extension = strtolower(pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION));
            $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif'];
            
            if (in_array($file_extension, $allowed_extensions)) {
                $new_filename = 'chantier_' . uniqid() . '.' . $file_extension;
                $target_file = $target_dir . $new_filename;
                
                if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                    $image_path = $target_file;
                } else {
                    $error = "Erreur lors de l'upload de l'image.";
                }
            } else {
                $error = "Format d'image non autorisé. Utilisez JPG, PNG ou GIF.";
            }
        }
        
        if (empty($error)) {
            try {
                $stmt = $pdo->prepare("INSERT INTO chantiers (nom, description, image, localisation, date_debut, date_fin, statut) VALUES (?, ?, ?, ?, ?, ?, ?)");
                $stmt->execute([$nom, $description, $image_path, $localisation, $date_debut, $date_fin, $statut]);
                $success = "Chantier créé avec succès !";
                
                // Réinitialiser les champs
                $nom = '';
                $description = '';
                $localisation = '';
            } catch (PDOException $e) {
                $error = "Erreur lors de la création du chantier.";
            }
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
    <title>Archeo - It Création Chantier</title>
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
        <i class="bi bi-geo-alt-fill me-2"></i> CRÉER UN CHANTIER
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
    <form method="POST" action="" enctype="multipart/form-data">
        <div class="mb-3">
            <label class="form-label"><i class="bi bi-building me-1"></i>Nom du chantier :</label>
            <input type="text" name="nom" class="form-control" required 
                   value="<?= isset($nom) ? htmlspecialchars($nom) : '' ?>">
        </div>
        <div class="mb-3">
            <label class="form-label"><i class="bi bi-text-paragraph me-1"></i>Description :</label>
            <textarea name="description" class="form-control" rows="4" required><?= isset($description) ? htmlspecialchars($description) : '' ?></textarea>
        </div>
        <div class="mb-3">
            <label class="form-label"><i class="bi bi-pin-map-fill me-1"></i>Localisation :</label>
            <input type="text" name="localisation" class="form-control" placeholder="Ex: Carnac, Bretagne" required
                   value="<?= isset($localisation) ? htmlspecialchars($localisation) : '' ?>">
        </div>
        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label"><i class="bi bi-calendar-event me-1"></i>Date de début :</label>
                <input type="date" name="date_debut" class="form-control" required
                       value="<?= isset($date_debut) ? $date_debut : '' ?>">
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label"><i class="bi bi-calendar-check me-1"></i>Date de fin (optionnel) :</label>
                <input type="date" name="date_fin" class="form-control"
                       value="<?= isset($date_fin) ? $date_fin : '' ?>">
            </div>
        </div>
        <div class="mb-3">
            <label class="form-label"><i class="bi bi-flag-fill me-1"></i>Statut :</label>
            <select name="statut" class="form-control" required>
                <option value="">-- Choisissez un statut --</option>
                <option value="planifie" <?= (isset($statut) && $statut == 'planifie') ? 'selected' : '' ?>>Planifié</option>
                <option value="actif" <?= (isset($statut) && $statut == 'actif') ? 'selected' : '' ?>>Actif</option>
                <option value="termine" <?= (isset($statut) && $statut == 'termine') ? 'selected' : '' ?>>Terminé</option>
            </select>
        </div>
        
        <div class="mb-3">
            <label class="form-label"><i class="bi bi-image me-1"></i>Image du chantier (optionnel) :</label>
            <input type="file" name="image" class="form-control" accept="image/*">
            <small class="form-text text-muted">Formats acceptés : JPG, PNG, GIF. Taille max : 5MB</small>
        </div>
                <div class="d-flex justify-content-between">
            <button type="submit" class="btn btn-send">
                <i class="bi bi-plus-circle me-1"></i>CRÉER LE CHANTIER
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