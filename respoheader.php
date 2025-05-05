<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}
?>
<nav id="responsive" class="navbar navbar-dark fixed-top" style="background-color: #2c2cb2;">
  <div class="container-fluid">
    <a class="navbar-brand" href="index.php">
      <h1 class="nav-title">GeekQuiz</h1>
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
            <a class="nav-link respoNavLinks" href="game.php">
              <span class="icons"><ion-icon name="game-controller-outline"></ion-icon></span>
              <span class="title">Quizz</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link respoNavLinks" href="rankings.php">
              <span class="icons"><ion-icon name="podium-outline"></ion-icon></span>
              <span class="title">Classement</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link respoNavLinks" href="new.php">
              <span class="icons"><ion-icon name="folder-open-outline"></ion-icon></span>
              <span class="title">Nouveau</span>
            </a>
          </li>
          <?php if (isset($_SESSION['userIsLoggedIn']) && $_SESSION['userIsLoggedIn']): ?>
          <li class="nav-item">
            <a class="nav-link respoNavLinks" href="list.php">
              <span class="icons"><ion-icon name="list-outline"></ion-icon></span>
              <span class="title">List</span>
            </a>
          </li>
          <?php endif; ?>
          <li class="nav-item">
            <a class="nav-link respoNavLinks" href="aide.php">
              <span class="icons"><ion-icon name="help-circle-outline"></ion-icon></span>
              <span class="title">Aide</span>
            </a>
          </li>
        </ul>
        <div class="mt-3">
          <?php
          if (isset($_SESSION['userIsLoggedIn']) && $_SESSION['userIsLoggedIn']) {
              echo '<span class="user-tab user text-white me-2"><ion-icon class="profile" name="person-circle-outline"></ion-icon>' . htmlspecialchars($_SESSION['username']) .'</span>';
              echo '<a href="logout.php" style="display: block;width: fit-content;margin: auto;" class=" btn btn-outline-danger">Se déconnecter</a>';
          } else {
              echo '<a href="login.php" class="btn btn-outline-light me-2">Sign In</a>';
              echo '<a href="sign.php" class="btn btn-light">Sign Up</a>';
          }
          ?>
        </div>
      </div>
    </div>
  </div>
</nav>