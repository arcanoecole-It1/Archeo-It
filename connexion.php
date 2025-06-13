<?php
session_start();
include 'database.php';
include 'header.php';
$success = '';
$error = '';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = htmlspecialchars(trim($_POST["username"]));
    $password = trim($_POST["password"]);
    if (!empty($username) && !empty($password)) {
        try {
            $stmt = $pdo->prepare("SELECT id, username,password, is_admin FROM users WHERE username = ? OR email = ?");
            $stmt->execute([$username, $username]);
            $user = $stmt->fetch();
            if ($user && password_verify($password, $user['password'])) {
                // Connexion réussie - Stocker TOUTES les infos dans la session
                $_SESSION['userIsLoggedIn'] = true;
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['is_admin'] = $user['is_admin']; 
                header("Location: index.php");
                exit;
            } else {
                $error = "Nom d'utilisateur ou mot de passe incorrect.";
            }
        } catch (PDOException $e) {
            $error = "Erreur de connexion. Veuillez réessayer.";
        }
    } else {
        $error = "Veuillez remplir tous les champs.";
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Archeo - It Connexion</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="./assets/css/header.css">
    <link rel="stylesheet" href="./assets/css/footer.css">
    <link rel="stylesheet" href="./assets/css/contact.css">
</head>
<body>
<div class="contact-container">
    <h2 class="text-center mb-4">
        <i class="bi bi-box-arrow-in-right me-2"></i> CONNEXION
    </h2>

    <?php if ($success): ?>
        <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
    <?php endif; ?>

    <?php if ($error): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="POST" action="connexion.php">
        <div class="mb-3">
            <label class="form-label"><i class="bi bi-person-fill me-1"></i>Nom d'utilisateur ou Email :</label>
            <input type="text" name="username" class="form-control" required>
        </div>
        
        <div class="mb-3">
            <label class="form-label"><i class="bi bi-lock-fill me-1"></i>Mot de passe :</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        
        <button type="submit" class="btn btn-send">SE CONNECTER</button>
        
        <div class="text-center mt-3">
            <p>Pas encore de compte ? <a href="inscription.php" class="text-decoration-none">S'inscrire</a></p>
        </div>
    </form>
</div>
<?php include 'footer.php'; ?>
</body>
</html>
<script src="./assets/JS/script.js"></script>
<script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
