<?php
include 'database.php';
include 'header.php';
$success = '';
$error = '';
$generated_password = '';

// Générer un mot de passe si demandé
if (isset($_POST['generate_password'])) {
    $password_type = $_POST['password_type'];
    $password_length = $_POST['password_length'] ?? 12;
    $script_path = __DIR__ . '/generate_password.py';
    
    if (file_exists($script_path)) {
        // Essayer différentes commandes Python
        $commands = [
            "python \"$script_path\" $password_type $password_length 2>&1",
            "python3 \"$script_path\" $password_type $password_length 2>&1",
            "py \"$script_path\" $password_type $password_length 2>&1",
        ];
        
        foreach ($commands as $cmd) {
            $command = escapeshellcmd($cmd);
            $result = shell_exec($command);
            
            if ($result !== null && !empty(trim($result))) {
                $generated_password = trim($result);
                break;
            }
        }
    }
}
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['register'])) {
    $username = htmlspecialchars(trim($_POST["username"]));
    $email = htmlspecialchars(trim($_POST["email"]));
    $password = trim($_POST["password"]);
    $confirm_password = trim($_POST["confirm_password"]);
    $first_name = htmlspecialchars(trim($_POST["first_name"]));
    $last_name = htmlspecialchars(trim($_POST["last_name"]));

    if (!empty($username) && !empty($email) && !empty($password) && !empty($confirm_password) && !empty($first_name) && !empty($last_name)) {
        if ($password === $confirm_password) {
            try {
                // Vérifier si l'utilisateur existe déjà
                $stmt = $pdo->prepare("SELECT id FROM users WHERE username = ? OR email = ?");
                $stmt->execute([$username, $email]);
                
                if ($stmt->rowCount() > 0) {
                    $error = "Ce nom d'utilisateur ou cet email existe déjà.";
                } else {
                    // Hasher le mot de passe
                    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                    // Insérer le nouvel utilisateur
                    $stmt = $pdo->prepare("INSERT INTO users (username, email, password, first_name, last_name, is_admin) VALUES (?, ?, ?, ?, ?, 0)");
                    $stmt->execute([$username, $email, $hashed_password, $first_name, $last_name]);
                    
                    $success = "Inscription réussie ! Vous pouvez maintenant vous connecter.";
                }
            } catch (PDOException $e) {
                $error = "Erreur lors de l'inscription. Veuillez réessayer.";
            }
        } else {
            $error = "Les mots de passe ne correspondent pas.";
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
    <title>Archeo - It Inscription</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="./assets/css/header.css">
    <link rel="stylesheet" href="./assets/css/footer.css">
    <link rel="stylesheet" href="./assets/css/contact.css">
    <link rel="stylesheet" href="./assets/css/inscription.css">
</head>
<body>
<div class="contact-container">
    <h2 class="text-center mb-4">
        <i class="bi bi-person-plus-fill me-2"></i> INSCRIPTION
    </h2>

    <?php if ($success): ?>
        <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
    <?php endif; ?>

    <?php if ($error): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>
    <div class="password-generator">
        <h5 class="mb-3"><i class="bi bi-key-fill me-2"></i>Générateur de mot de passe sécurisé</h5>
        <form method="POST" action="">
            <div class="password-options mb-3">
                <label class="form-label">Type de mot de passe :</label>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="password_type" id="type1" value="1" 
                           <?= (!isset($_POST['password_type']) || $_POST['password_type'] == '1') ? 'checked' : '' ?>>
                    <label class="form-check-label" for="type1">
                        <i class="bi bi-type me-1"></i>Alphabétique seulement (Majuscules + Minuscules)
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="password_type" id="type2" value="2"
                           <?= (isset($_POST['password_type']) && $_POST['password_type'] == '2') ? 'checked' : '' ?>>
                    <label class="form-check-label" for="type2">
                        <i class="bi bi-123 me-1"></i>Alphabétique et numérique
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="password_type" id="type3" value="3"
                           <?= (isset($_POST['password_type']) && $_POST['password_type'] == '3') ? 'checked' : '' ?>>
                    <label class="form-check-label" for="type3">
                        <i class="bi bi-shield-check me-1"></i>Alphabétique, numérique et caractères spéciaux
                    </label>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-6">
                    <label class="form-label">Longueur du mot de passe :</label>
                    <select name="password_length" class="form-control">
                        <option value="8" <?= (isset($_POST['password_length']) && $_POST['password_length'] == '8') ? 'selected' : '' ?>>8 caractères</option>
                        <option value="12" <?= (!isset($_POST['password_length']) || $_POST['password_length'] == '12') ? 'selected' : '' ?>>12 caractères</option>
                        <option value="16" <?= (isset($_POST['password_length']) && $_POST['password_length'] == '16') ? 'selected' : '' ?>>16 caractères</option>
                        <option value="20" <?= (isset($_POST['password_length']) && $_POST['password_length'] == '20') ? 'selected' : '' ?>>20 caractères</option>
                    </select>
                </div>
                <div class="col-md-6 d-flex align-items-end">
                    <button type="submit" name="generate_password" value="1" class="btn btn-generate w-100">
                        <i class="bi bi-arrow-repeat me-2"></i>Générer
                    </button>
                </div>
            </div>
        </form>
        
        <?php if (!empty($generated_password)): ?>
            <div class="mt-3">
                <label class="form-label">Mot de passe généré :</label>
                <div class="input-group">
                    <input type="text" id="generatedPassword" class="form-control password-display" 
                           value="<?= htmlspecialchars($generated_password) ?>" readonly>
                    <button type="button" class="btn btn-secondary" onclick="copyPassword()">
                        <i class="bi bi-clipboard"></i> Copier
                    </button>
                </div>
                <small class="text-muted">Cliquez sur "Copier" pour utiliser ce mot de passe</small>
            </div>
        <?php endif; ?>
    </div>

    <!-- Formulaire d'inscription -->
    <form method="POST" action="">
        <input type="hidden" name="register" value="1">
        
        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <label class="form-label"><i class="bi bi-person-fill me-1"></i>Nom :</label>
                    <input type="text" name="last_name" class="form-control" required 
                           value="<?= isset($_POST['last_name']) ? htmlspecialchars($_POST['last_name']) : '' ?>">
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label class="form-label"><i class="bi bi-person me-1"></i>Prénom :</label>
                    <input type="text" name="first_name" class="form-control" required
                           value="<?= isset($_POST['first_name']) ? htmlspecialchars($_POST['first_name']) : '' ?>">
                </div>
            </div>
        </div>
        
        <div class="mb-3">
            <label class="form-label"><i class="bi bi-at me-1"></i>Nom d'utilisateur :</label>
            <input type="text" name="username" class="form-control" required
                   value="<?= isset($_POST['username']) ? htmlspecialchars($_POST['username']) : '' ?>">
        </div>
        
        <div class="mb-3">
            <label class="form-label"><i class="bi bi-envelope-fill me-1"></i>Email :</label>
            <input type="email" name="email" class="form-control" required
                   value="<?= isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '' ?>">
        </div>
        
        <div class="mb-3">
            <label class="form-label"><i class="bi bi-lock-fill me-1"></i>Mot de passe :</label>
            <input type="password" name="password" id="password" class="form-control" required>
            <small class="form-text text-muted">Utilisez le générateur ci-dessus ou créez votre propre mot de passe</small>
        </div>
        
        <div class="mb-3">
            <label class="form-label"><i class="bi bi-lock me-1"></i>Confirmer le mot de passe :</label>
            <input type="password" name="confirm_password" class="form-control" required>
        </div>
        
        <button type="submit" class="btn btn-send">S'INSCRIRE</button>
        
        <div class="text-center mt-3">
            <p>Déjà un compte ? <a href="login.php" class="text-decoration-none">Se connecter</a></p>
        </div>
    </form>
</div>

<?php include 'footer.php'; ?>
</body>
</html>
<script src="./assets/JS/password.js"></script>
<script src="./assets/JS/script.js"></script>
<script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
