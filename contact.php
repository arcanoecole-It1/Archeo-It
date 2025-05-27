<?php
include 'database.php';
include 'header.php';

$success = '';
$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $last_name = htmlspecialchars(trim($_POST["last_name"]));
    $first_name = htmlspecialchars(trim($_POST["first_name"]));
    $email = htmlspecialchars(trim($_POST["email"]));
    $subject = htmlspecialchars(trim($_POST["subject"]));
    $comment = htmlspecialchars(trim($_POST["comment"]));

    if (!empty($last_name) && !empty($first_name) && !empty($email) && !empty($subject) && !empty($comment)) {
        try {
            $stmt = $pdo->prepare("INSERT INTO contact (last_name, first_name, email, subject, comment) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$last_name, $first_name, $email, $subject, $comment]);
            $success = "Message envoyé avec succès.";
        } catch (PDOException $e) {
            $error = "Erreur : " . $e->getMessage();
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
    <title> Archeo - It Contact</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="./assets/css/header.css">
    <link rel="stylesheet" href="./assets/css/footer.css">
    <link rel="stylesheet" href="./assets/css/contact.css">
  
</head>
<body>
 <div class="contact-container">
    <h2 class="text-center mb-4">
        <i class="bi bi-telephone-fill me-2"></i> CONTACTEZ NOUS
    </h2>

    <?php if ($success): ?>
        <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
    <?php endif; ?>

    <?php if ($error): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="POST" action="contact.php">
        <div class="mb-3">
            <label class="form-label"><i class="bi bi-person-fill me-1"></i>Votre Nom :</label>
            <input type="text" name="last_name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label"><i class="bi bi-person"></i> Prénom :</label>
            <input type="text" name="first_name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label"><i class="bi bi-envelope-fill me-1"></i>Email :</label>
            <input type="email" name="email" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label"><i class="bi bi-list-ul me-1"></i>Sujets :</label>
            <select name="subject" class="form-control" required>
                <option value="">-- Choisissez un sujet --</option>
                <option value="Demande d’infos">Demande d’infos</option>
                <option value="Demande de Rendez-vous">Demande de Rendez-vous</option>
                <option value="Autre">Autre</option>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label"><i class="bi bi-chat-text me-1"></i>Votre Message :</label>
            <textarea name="comment" class="form-control" rows="4" required></textarea>
        </div>
        <button type="submit" class="btn btn-send">ENVOYER</button>
    </form>
</div>

    </body>
</html>
 <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>

<?php include 'footer.php'; ?>