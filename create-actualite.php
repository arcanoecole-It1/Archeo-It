<?php
session_start();
include 'database.php';
include 'header.php';

// Vérification admin
if (!isset($_SESSION['userIsLoggedIn']) || !$_SESSION['is_admin'] != 1) {
    header("Location: index.php");
    exit;
}

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
            if (!file_exists($target_dir)) {
                mkdir($target_dir, 0777, true);
            }
            
            $file_extension = strtolower(pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION));
            $new_filename = uniqid() . '.' . $file_extension;
            $target_file = $target_dir . $new_filename;
            
            $check = getimagesize($_FILES["image"]["tmp_name"]);
            if ($check !== false) {
                if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                    $image_path = $target_file;
                } else {
                    $error = "Erreur lors de l'upload de l'image.";
                }
            } else {
                $error = "Le fichier n'est pas une image.";
            }
        }
        
        if (empty($error)) {
            try {
                $stmt = $pdo->prepare("INSERT INTO actualites (titre, description, image, date_creation) VALUES (?, ?, ?, ?)");
                $stmt->execute([$titre, $description, $image_path, $date_creation]);
                $success = "Actualité créée avec succès.";
            } catch (PDOException $e) {
                $error = "Erreur : " . $e->getMessage();
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="./assets/css/header.css">
    <link rel="stylesheet" href="./assets/css/footer.css">
    <link rel="stylesheet" href="./assets/css/contact.css">
</head>
<body>
<div class="contact-container">
    <h2 class="text-center mb-4">
        <i class="bi bi-newspaper me-2"></i> CRÉER UNE ACTUALITÉ
    </h2>

    <?php if ($success): ?>
        <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
    <?php endif; ?>

    <?php if ($error): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="POST" action="create-actualite.php" enctype="multipart/form-data">
        <div class="mb-3">
            <label class="form-label"><i class="bi bi-card-heading me-1"></i>Titre :</label>
            <input type="text" name="titre" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label"><i class="bi bi-text-left me-1"></i>Description :</label>
            <textarea name="description" class="form-control" rows="4" required></textarea>
        </div>
        <div class="mb-3">
            <label class="form-label"><i class="bi bi-image me-1"></i>Image :</label>
            <input type="file" name="image" class="form-control" accept="image/*">
            <small class="form-text text-muted">Formats acceptés : JPG, PNG, GIF (optionnel)</small>
        </div>
        <button type="submit" class="btn btn-send">PUBLIER L'ACTUALITÉ</button>
    </form>
</div>
<?php include 'footer.php'; ?>
</body>
</html>
<script src="./assets/JS/script.js"></script>
<script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>