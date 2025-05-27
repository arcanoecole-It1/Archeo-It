<?php
include 'database.php';
$message = '';
$success = '';
$generated_password = '';

// Génération de mot de passe depuis bouton
if (isset($_POST["generate"])) {
    $niveau = $_POST["niveau"] ?? 'complexe';
    $output = shell_exec("python3 generate_password.py " . escapeshellarg($niveau));
    $generated_password = trim($output);
}

// Traitement du formulaire d’inscription
if (isset($_POST["register"])) {
    $username = htmlspecialchars(trim($_POST["username"]));
    $email = htmlspecialchars(trim($_POST["email"]));
    $password = $_POST["password"];
    $confirm_password = $_POST["confirm_password"];

    if (!empty($username) && !empty($email) && !empty($password)) {
        if ($password === $confirm_password) {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            try {
                $stmt = $pdo->prepare("INSERT INTO users (username, email, password, is_admin) VALUES (?, ?, ?, 0)");
                $stmt->execute([$username, $email, $hash]);
                $success = "Inscription réussie !";
            } catch (PDOException $e) {
                $message = "Erreur : " . $e->getMessage();
            }
        } else {
            $message = "Les mots de passe ne correspondent pas.";
        }
    } else {
        $message = "Tous les champs sont obligatoires.";
    }
}
?>

<?php include 'header.php'; ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chantiers de Fouilles</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="./assets/css/header.css">
    <link rel="stylesheet" href="./assets/css/footer.css">
    <link rel="stylesheet" href="./assets/css/inscription.css">
<div class="register-container">
    <h2 class="text-center mb-4"><i class="bi bi-person-plus-fill me-2"></i>Créer un compte</h2>

    <?php if ($message): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($message) ?></div>
    <?php endif; ?>
    <?php if ($success): ?>
        <div class="alert alert-success"><?= $success ?></div>
    <?php endif; ?>

    <!-- Formulaire d'inscription -->
    <form method="POST" action="inscription.php">
        <div class="mb-3">
            <label><i class="bi bi-person-fill me-1"></i>Nom d'utilisateur :</label>
            <input type="text" name="username" class="form-control" required value="<?= $_POST['username'] ?? '' ?>">
        </div>
        <div class="mb-3">
            <label><i class="bi bi-envelope-fill me-1"></i>Email :</label>
            <input type="email" name="email" class="form-control" required value="<?= $_POST['email'] ?? '' ?>">
        </div>

        <div class="mb-3">
            <label><i class="bi bi-shield-lock-fill me-1"></i>Mot de passe :</label>
            <input type="text" name="password" class="form-control" id="password" required value="<?= $generated_password ?>">
        </div>

        <div class="mb-3">
            <label><i class="bi bi-shield-lock-fill me-1"></i>Confirmer le mot de passe :</label>
            <input type="password" name="confirm_password" class="form-control" required>
        </div>

        <div class="mb-3">
            <label><i class="bi bi-gear-fill me-1"></i>Sécurité du mot de passe à générer :</label>
            <select name="niveau" class="form-control">
                <option value="alpha">Alphabétique</option>
                <option value="alphanum">Alphanumérique</option>
                <option value="complexe">Alphanumérique + caractères spéciaux</option>
            </select>
        </div>

        <div class="d-grid gap-2 d-md-flex justify-content-md-between">
            <button type="submit" name="generate" class="btn btn-secondary">Suggérer un mot de passe</button>
            <button type="submit" name="register" class="btn btn-register">S'inscrire</button>
        </div>
    </form>

    <p class="text-center mt-3">Déjà un compte ? <a href="connexion.php">Se connecter</a></p>
</div>

<?php include 'footer.php'; ?>