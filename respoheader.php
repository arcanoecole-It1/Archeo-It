<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}
include 'database.php';
?>

<head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<nav id="responsive" class="navbar navbar-dark fixed-top" style="background-color: #2c2cb2;">
  <div class="container-fluid">
    <a class="navbar-brand" href="index.php">
      <h1 class="nav-title">ARCHEO - IT</h1>
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="offcanvas offcanvas-end text-white" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel" style="background-color: #1a1a2e;">
      <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="offcanvasNavbarLabel">Menu</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
      </div>
      <div class="offcanvas-body">
        <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
          <li class="nav-item">
            <a class="nav-link respoNavLinks" aria-current="page" href="index.php">
              <span class="icons"><ion-icon name="home-outline"></ion-icon></span>
              <span class="title">Accueil</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link respoNavLinks" href="chantiers.php">
              <span class="icons"><ion-icon name="map-outline"></ion-icon></span>
              <span class="title">Chantiers</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link respoNavLinks" href="actualites.php">
              <span class="icons"><ion-icon name="newspaper-outline"></ion-icon></span>
              <span class="title">Actualités</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link respoNavLinks" href="contact.php">
              <span class="icons"><ion-icon name="mail-outline"></ion-icon></span>
              <span class="title">Contact</span>
            </a>
          </li>
          <?php if (isset($_SESSION['userIsLoggedIn']) && $_SESSION['userIsLoggedIn'] && $pdo): ?>
            <?php
            $stmt = $pdo->prepare("SELECT is_admin FROM users WHERE id = ?");
            $stmt->execute([$_SESSION['user_id']]);
            $user = $stmt->fetch();

            if ($user && $user['is_admin'] == 1): ?>
              <li class="nav-item">
                <a class="nav-link respoNavLinks" href="creation.php">
                  <span class="icons"><ion-icon name="add-circle-outline"></ion-icon></span>
                  <span class="title">Création</span>
                </a>
              </li>
            <?php endif; ?>
          <?php endif; ?>
        </ul>
        <div class="mt-3">
          <?php
          if (isset($_SESSION['userIsLoggedIn']) && $_SESSION['userIsLoggedIn']) {
              echo '<span class="user-tab user text-white me-2"><ion-icon class="profile" name="person-circle-outline"></ion-icon>' . htmlspecialchars($_SESSION['username']) .'</span>';
              echo '<a href="deconnexion.php" style="display: block;width: fit-content;margin: auto;" class="btn btn-outline-danger">Se déconnecter</a>';
          } else {
              echo '<a href="connexion.php" class="btn btn-outline-light me-2">Sign In</a>';
              echo '<a href="inscription.php" class="btn btn-light">Sign Up</a>';
          }
          ?>
        </div>
      </div>
    </div>
  </div>
</nav>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>