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
    $date_creation = time();
    if (!empty($titre) && !empty($description)) {
        // Gestion de l'image
        $image_path = null;
        if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
            $target_dir = "uploads/actualites/";
            // Créer le dossier s'il n'existe pas
            if (!file_exists($target_dir)) {
                mkdir($target_dir, 0777, true);
            }
            $file_extension = strtolower(pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION));
            $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif'];
            
            if (in_array($file_extension, $allowed_extensions)) {
                $new_filename = 'actualite_' . uniqid() . '.' . $file_extension;
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
                $stmt = $pdo->prepare("INSERT INTO actualites (titre, description, image, date_creation) VALUES (?, ?, ?, ?)");
                $stmt->execute([$titre, $description, $image_path, $date_creation]);
                $success = "Actualité créée avec succès !";
                // Réinitialiser les champs
                $titre = '';
                $description = '';
            } catch (PDOException $e) {
                $error = "Erreur lors de la création de l'actualité.";
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
    <title>Archeo - It Création Actualité</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./assets/css/header.css">
    <link rel="stylesheet" href="./assets/css/footer.css">
    <link rel="stylesheet" href="./assets/css/contact.css">
</head>
<body>
<?php include 'header.php'; ?>
<div class="contact-container">
    <h2 class="text-center mb-4">
        <i class="bi bi-newspaper me-2"></i> CRÉER UNE ACTUALITÉ
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
            <label class="form-label"><i class="bi bi-card-heading me-1"></i>Titre de l'actualité :</label>
            <input type="text" name="titre" class="form-control" required 
                   value="<?= isset($titre) ? htmlspecialchars($titre) : '' ?>">
        </div>
        
        <div class="mb-3">
            <label class="form-label"><i class="bi bi-text-left me-1"></i>Description :</label>
            <textarea name="description" class="form-control" rows="5" required><?= isset($description) ? htmlspecialchars($description) : '' ?></textarea>
        </div>
        
        <div class="mb-3">
            <label class="form-label"><i class="bi bi-image me-1"></i>Image (optionnel) :</label>
            <input type="file" name="image" class="form-control" accept="image/*">
            <small class="form-text text-muted">Formats acceptés : JPG, PNG, GIF. Taille max : 5MB</small>
        </div>
        <div class="d-flex justify-content-between">
            <button type="submit" class="btn btn-send">
                <i class="bi bi-plus-circle me-1"></i>PUBLIER L'ACTUALITÉ
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