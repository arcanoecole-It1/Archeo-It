<?php
require_once 'database.php';
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

<div class="container mt-5">
    <h2>Contact</h2>

    <?php if ($success): ?>
        <div class="alert alert-success"><?= $success ?></div>
    <?php endif; ?>

    <?php if ($error): ?>
        <div class="alert alert-danger"><?= $error ?></div>
    <?php endif; ?>

    <form method="POST" action="contact.php">
        <div class="mb-3">
            <label>Nom :</label>
            <input type="text" name="last_name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Prénom :</label>
            <input type="text" name="first_name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Email :</label>
            <input type="email" name="email" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Sujet :</label>
            <select name="subject" class="form-control" required>
                <option value="">-- Choisissez un sujet --</option>
                <option value="Demande d’infos">Demande d’infos</option>
                <option value="Demande de Rendez-vous">Demande de Rendez-vous</option>
                <option value="Autre">Autre</option>
            </select>
        </div>
        <div class="mb-3">
            <label>Message :</label>
            <textarea name="comment" class="form-control" rows="4" required></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Envoyer</button>
    </form>
</div>

<?php include 'footer.php'; ?>