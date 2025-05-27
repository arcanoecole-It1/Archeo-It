<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
};
?>
<head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
</head>
<header >
    <div class="navigation">
        <a style="text-decoration: none" href="index.php">
            <h1 class="nav-title">ARCHEO - IT</h1>
        </a>
        <ul>
            <li class="list act">
                <a class="navLinks" href="index.php">
                    <span class="icons">
                        <ion-icon name="home-outline"></ion-icon>
                    </span>
                    <span class="title">Accueil</span>
                </a>
            </li>
            <li class="list">
                <a class="navLinks" href="chantiers.php">
                    <span class="icons">
                        <ion-icon name="map-outline"></ion-icon>
                    </span>
                    <span class="title">Chantiers</span>
                </a>
            </li>
            <li class="list">
                <a class="navLinks" href="news.php">
                    <span class="icons">
                        <ion-icon name="newspaper-outline"></ion-icon>
                    </span>
                    <span class="title">Actualités</span>
                </a>
            </li>
            <li class="list">
                <a class="navLinks" href="contact.php">
                    <span class="icons">
                        <ion-icon name="mail-outline"></ion-icon>
                    </span>
                    <span class="title">Contact</span>
                </a>
            </li>
        </ul>
        <div class="auth-buttons">
        <?php
        // Verifie si l'utilisateur est connecter et actualisé le header en fonction
        if (isset($_SESSION['userIsLoggedIn']) && $_SESSION['userIsLoggedIn']) {
            echo '<span class="user"><ion-icon class="profile" name="person-circle-outline"></ion-icon>' . htmlspecialchars($_SESSION['username']) .'</span>';
            echo '<a href="logout.php"><button class="sign-out">Se déconnecter</button></a>';
        } else {
            echo '<a href="login.php"><button class="sign-in">Sign In</button></a>';
            echo '<a href="inscription.php"><button class="sign-up">Sign Up</button></a>';
        }
        ?>
        </div>
    </div>
</header>