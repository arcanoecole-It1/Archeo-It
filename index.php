<?php
require 'database.php';
// Traitement du formulaire de commentaire
$comment_success = '';
$comment_error = '';
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit_comment'])) {
    $nom = htmlspecialchars(trim($_POST["nom"]));
    $email = htmlspecialchars(trim($_POST["email"]));
    $commentaire = htmlspecialchars(trim($_POST["commentaire"]));
    
    if (!empty($nom) && !empty($email) && !empty($commentaire)) {
        try {
            $stmt = $pdo->prepare("INSERT INTO commentaires (nom, email, commentaire, date_creation) VALUES (?, ?, ?, NOW())");
            $stmt->execute([$nom, $email, $commentaire]);
            $comment_success = "Merci pour votre commentaire !";
        } catch (PDOException $e) {
            $comment_error = "Erreur lors de l'envoi du commentaire.";
        }
    } else {
        $comment_error = "Veuillez remplir tous les champs.";
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Archeo - It site d'archéologie</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./assets/css/header.css">
    <link rel="stylesheet" href="./assets/css/respoheader.css">
    <link rel="stylesheet" href="./assets/css/footer.css">
    <link rel="stylesheet" href="./assets/css/style.css">
</head>
<?php include 'header.php'; ?>
<?php include 'respoheader.php'; ?>
<body>
    <section class="welcome-section">
        <div class="welcome-overlay"></div>
        <div class="welcome-content">
            <h1>Bienvenue sur Archeo - IT</h1>
            <p>Découvrez nos chantiers de fouilles et les dernières actualités du monde de l'archéologie. 
            Nous vous invitons à explorer nos projets et à en apprendre davantage sur notre passion pour l'archéologie.
            Nous espérons que vous trouverez notre site informatif et inspirant.</p>
        </div>
    </section>
    <div class="main-container">
        <div class="content-grid">
            <div class="actualites-section">
                <h2 class="mb-4"><i class="bi bi-newspaper me-2"></i>Actualités</h2>
                <?php
                try {
                    // Si connecté, afficher toutes les actualités, sinon seulement 3
                    $limit = (isset($_SESSION['userIsLoggedIn']) && $_SESSION['userIsLoggedIn']) ? "" : " LIMIT 3";
                    $stmt = $pdo->query("SELECT * FROM actualites ORDER BY date_creation DESC" . $limit);
                    $actualites = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    
                    if (!empty($actualites)) {
                        foreach ($actualites as $actualite) {
                            ?>
                            <div class="actualite-card">
                                <h4><?= htmlspecialchars($actualite['titre']) ?></h4>
                                <p class="actualite-date">
                                    <i class="bi bi-calendar3"></i> 
                                    <?= date('d/m/Y', $actualite['date_creation']) ?>
                                </p>
                                <p><?= htmlspecialchars(substr($actualite['description'], 0, 200)) ?>...</p>
                            </div>
                            <?php
                        }
                        
                        // Si non connecté, afficher bouton pour voir plus
                        if (!isset($_SESSION['userIsLoggedIn']) || !$_SESSION['userIsLoggedIn']) {
                            ?>
                            <div class="text-center mt-4">
                                <button class="btn btn-primary" onclick="showLoginMessage()">
                                    <i class="bi bi-lock me-2"></i>Connectez-vous pour voir toutes les actualités
                                </button>
                            </div>
                            <?php
                        }
                    } else {
                        echo '<p class="text-muted">Aucune actualité pour le moment.</p>';
                    }
                } catch (PDOException $e) {
                    echo '<p class="text-danger">Erreur lors du chargement des actualités.</p>';
                }
                ?>
            </div>
            <div class="agenda-section">
                <h3><i class="bi bi-calendar-event me-2"></i>Agenda</h3>
                <?php
                if (isset($_SESSION['is_admin']) && $_SESSION['is_admin'] == 1) {
                    echo '<a href="create-event.php" class="btn btn-sm btn-success mb-3">
                            <i class="bi bi-plus-circle me-1"></i>Ajouter
                          </a>';
                }  
                try {
                    $stmt = $pdo->query("SELECT * FROM agenda WHERE date_evenement >= CURDATE() ORDER BY date_evenement ASC LIMIT 5");
                    $evenements = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    if (!empty($evenements)) {
                        foreach ($evenements as $evenement) {
                            ?>
                            <div class="agenda-item">
                                <span class="agenda-date-badge">
                                    <?= date('d/m/Y', strtotime($evenement['date_evenement'])) ?>
                                </span>
                                <h6 class="mt-2"><?= htmlspecialchars($evenement['titre']) ?></h6>
                                <p class="mb-1 small"><?= htmlspecialchars($evenement['description']) ?></p>
                                <?php if (!empty($evenement['lieu'])): ?>
                                    <p class="mb-0 text-muted small">
                                        <i class="bi bi-geo-alt"></i> <?= htmlspecialchars($evenement['lieu']) ?>
                                    </p>
                                <?php endif; ?>
                            </div>
                            <?php
                        }
                    } else {
                        echo '<p class="text-muted">Aucun événement programmé.</p>';
                    }
                } catch (PDOException $e) {
                    echo '<p class="text-danger">Erreur lors du chargement.</p>';
                }
                ?>
            </div>
        </div>
    </div>
    <section class="comment-section">
        <div class="main-container">
            <div class="comment-form">
                <h3 class="text-center mb-4">
                    <i class="bi bi-chat-dots me-2"></i>Laissez-nous un commentaire
                </h3>
                <?php if ($comment_success): ?>
                    <div class="alert alert-success"><?= $comment_success ?></div>
                <?php endif; ?>
                
                <?php if ($comment_error): ?>
                    <div class="alert alert-danger"><?= $comment_error ?></div>
                <?php endif; ?>
                <form method="POST" action="">
                    <div class="mb-3">
                        <label class="form-label">Votre nom</label>
                        <input type="text" name="nom" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Votre email</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Votre commentaire</label>
                        <textarea name="commentaire" class="form-control" rows="4" required></textarea>
                    </div>
                    <button type="submit" name="submit_comment" class="btn btn-primary w-100">
                        <i class="bi bi-send me-2"></i>Envoyer
                    </button>
                </form>
            </div>
        </div>
    </section>
    <section class="cta-contact">
        <div class="main-container">
            <h2>Une question ? Un projet ?</h2>
            <p class="mb-4">N'hésitez pas à nous contacter pour toute demande d'information</p>
            <a href="contact.php" class="btn-contact">
                <i class="bi bi-envelope me-2"></i>Contactez-nous
            </a>
        </div>
    </section>
    <div class="modal fade" id="loginModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="bi bi-info-circle me-2"></i>Connexion requise</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>Connectez-vous pour accéder à toutes les actualités de notre site.</p>
                </div>
                <div class="modal-footer">
                    <a href="login.php" class="btn btn-primary">Se connecter</a>
                    <a href="inscription.php" class="btn btn-outline-primary">S'inscrire</a>
                </div>
            </div>
        </div>
    </div>
    <?php include 'footer.php'; ?>
</body>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</html>