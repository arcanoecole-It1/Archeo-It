<?php
require 'database.php';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Archeo - It site d'archéologie</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="./assets/css/header.css">
    <link rel="stylesheet" href="./assets/css/footer.css">
    <link rel="stylesheet" href="./assets/css/contact.css">
    <link rel="stylesheet" href="./assets/css/style.css">
</head>
<body>
<?php include 'header.php'; ?>
    <div class="image-banner">
        <div class="banner-content">
            <h1 class="text-white">Bienvenue sur Archeo - It</h1>
            <p class="text-white">Votre portail vers le monde de l'archéologie</p>
            <a href="inscription.php" class="btn btn-primary btn-lg">
                <i class="bi bi-person-plus-fill me-2"></i>S'inscrire
            </a>
        </div>
    </div>
    <div class="content-wrapper">
        <div class="actualites-section">
            <h2 class="mb-4"><i class="bi bi-newspaper me-2"></i>Dernières Actualités</h2>
            
            <?php
            try {
                $stmt = $pdo->query("SELECT * FROM actualites ORDER BY date_creation DESC LIMIT 3");
                $actualites = $stmt->fetchAll(PDO::FETCH_ASSOC);
                
                if (!empty($actualites)) {
                    foreach ($actualites as $actualite) {
                        ?>
                        <div class="actualite-card">
                            <h5 class="text-primary"><?= htmlspecialchars($actualite['titre']) ?></h5>
                            <p class="text-muted mb-2">
                                <i class="bi bi-calendar3"></i> 
                                <?= date('d/m/Y', $actualite['date_creation']) ?>
                            </p>
                            <p class="mb-0"><?= htmlspecialchars(substr($actualite['description'], 0, 200)) ?>...</p>
                        </div>
                        <?php
                    }
                    ?>
                    
                    <div class="text-center mt-4">
                        <?php if (isset($_SESSION['userIsLoggedIn']) && $_SESSION['userIsLoggedIn']): ?>
                            <a href="actualites.php" class="btn btn-primary">
                                <i class="bi bi-arrow-right-circle me-2"></i>Voir toutes les actualités
                            </a>
                        <?php else: ?>
                            <button class="btn btn-primary" onclick="showLoginMessage()">
                                <i class="bi bi-arrow-right-circle me-2"></i>Voir toutes les actualités
                            </button>
                        <?php endif; ?>
                    </div>
                    <?php
                } else {
                    echo '<p class="text-muted text-center">Aucune actualité pour le moment.</p>';
                }
            } catch (PDOException $e) {
                echo '<p class="text-danger">Erreur lors du chargement des actualités.</p>';
            }
            ?>
        </div>
        <div class="agenda-section">
            <h2 class="mb-4"><i class="bi bi-calendar-event me-2"></i>Agenda</h2>
            
            <?php
            if (isset($_SESSION['is_admin']) && $_SESSION['is_admin'] == 1) {
                echo '<div class="text-end mb-3">
                        <a href="create-event.php" class="btn btn-success btn-sm">
                            <i class="bi bi-plus-circle me-1"></i>Ajouter
                        </a>
                      </div>';
            }
            try {
                $stmt = $pdo->query("SELECT * FROM agenda WHERE date_evenement >= CURDATE() ORDER BY date_evenement ASC LIMIT 5");
                $evenements = $stmt->fetchAll(PDO::FETCH_ASSOC);
                if (!empty($evenements)) {
                    foreach ($evenements as $evenement) {
                        ?>
                        <div class="agenda-item">
                            <div class="mb-2">
                                <span class="agenda-date">
                                    <?= date('d/m/Y', strtotime($evenement['date_evenement'])) ?>
                                </span>
                                <?php if (!empty($evenement['heure_evenement'])): ?>
                                    <span class="text-muted ms-2">
                                        <i class="bi bi-clock"></i> <?= substr($evenement['heure_evenement'], 0, 5) ?>
                                    </span>
                                <?php endif; ?>
                            </div>
                            <h6 class="text-success mb-1"><?= htmlspecialchars($evenement['titre']) ?></h6>
                            <p class="mb-1"><?= htmlspecialchars($evenement['description']) ?></p>
                            <?php if (!empty($evenement['lieu'])): ?>
                                <p class="mb-0 text-muted small">
                                    <i class="bi bi-geo-alt-fill"></i> <?= htmlspecialchars($evenement['lieu']) ?>
                                </p>
                            <?php endif; ?>
                        </div>
                        <?php
                    }
                } else {
                    echo '<p class="text-muted text-center">Aucun événement programmé.</p>';
                }
            } catch (PDOException $e) {
                echo '<p class="text-danger">Erreur lors du chargement de l\'agenda.</p>';
            }
            ?>
        </div>
    </div>
    <div class="comment-section">
        <div class="comment-form">
            <h2 class="text-center mb-4">
                <i class="bi bi-chat-dots-fill me-2"></i>Laissez un commentaire
            </h2>
            <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit_comment'])) {
                $nom = htmlspecialchars(trim($_POST["nom"]));
                $email = htmlspecialchars(trim($_POST["email"]));
                $commentaire = htmlspecialchars(trim($_POST["commentaire"]));
                
                if (!empty($nom) && !empty($email) && !empty($commentaire)) {
                    try {
                        $stmt = $pdo->prepare("INSERT INTO commentaires (nom, email, commentaire, date_creation) VALUES (?, ?, ?, NOW())");
                        $stmt->execute([$nom, $email, $commentaire]);
                        echo '<div class="alert alert-success">Merci pour votre commentaire !</div>';
                    } catch (PDOException $e) {
                        echo '<div class="alert alert-danger">Erreur lors de l\'envoi du commentaire.</div>';
                    }
                }
            }
            ?>
            <form method="POST" action="">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Votre nom</label>
                        <input type="text" name="nom" class="form-control" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Votre email</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Votre commentaire</label>
                    <textarea name="commentaire" class="form-control" rows="4" required></textarea>
                </div>
                <div class="text-center">
                    <button type="submit" name="submit_comment" class="btn btn-comment">
                        <i class="bi bi-send-fill me-2"></i>ENVOYER
                    </button>
                </div>
            </form>
        </div>
    </div>
    <div class="modal fade" id="loginModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="bi bi-info-circle me-2"></i>Connexion requise</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>Vous devez être connecté pour accéder à toutes les actualités.</p>
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
</html>
<script src="./assets/JS/script.js"></script>
<script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
