<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chantiers de Fouilles</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="./assets/css/header.css">
    <link rel="stylesheet" href="./assets/css/footer.css">
    <link rel="stylesheet" href="./assets/css/chantier.css">
</head>
<body>
    <?php require 'header.php'; ?>
    <main class="container">
        <div class="img-chantier">
            <img src="./assets/images/chantier.jpeg" alt="chantier">
        </div>
        <h1 class="text-center mb-4">Nos Chantiers de Fouilles</h1>
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <img src="./assets/images/carnac.webp" class="card-img-top" alt="Chantier 1">
                    <div class="card-body">
                        <h5 class="card-title">Chantier de Carnac</h5>
                        <p class="card-text">Découvrez les célèbres alignements de Carnac et participez à leur préservation.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <img src="./assets/images/lascaux.jpg" class="card-img-top" alt="Chantier 2">
                    <div class="card-body">
                        <h5 class="card-title">Chantier de Lascaux</h5>
                        <p class="card-text">Explorez les grottes de Lascaux et contribuez à la recherche sur l'art préhistorique.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <img src="./assets/images/gergovie.jpg" class="card-img-top" alt="Chantier 3">
                    <div class="card-body">
                        <h5 class="card-title">Chantier de Gergovie</h5>
                        <p class="card-text">Participez aux fouilles du site historique de la bataille de Gergovie.</p>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <?php require 'footer.php'; ?>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>
</html>