<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>A changer en fonction de la vue</title>
    <link rel="stylesheet" type="text/css" href="../ressources/css/root.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>

<header class="navbar fixed-top p-3">
    <div class="container-fluid">
        <?php
        use App\Magasin\Lib\ConnexionUtilisateur as ConnexionUtilisateur;
        $action = "afficherConnexion";
        $text = "Se connecter";
        if (ConnexionUtilisateur::estConnecte()) {
            $action = "deconnexion";
            $text = "Se déconnecter";
        }
        echo '
        <button class="navbar-toggler navbar-light" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebar-nav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="text-end">
            <a class="btn btn-outline-light" href="controleurFrontal.php?action='.$action.'&controleur=utilisateurGenerique">'.$text.'</a>
        </div>';
        ?>
    </div>
</header>

<div class="offcanvas offcanvas-start sidebar-nav" tabindex="-1" id="sidebar-nav">
    <div class="offcanvas-body p-0">
        <nav>
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link px-3 my-3 text-white">
                        <span class="me-2">
                            <img src="person-circle.svg" class="icon" alt="Utilisateur">
                        </span>
                        <span>
                            Utilisateur
                        </span>
                    </a>
                </li>
                <li>
                    <hr class="dropdown-divider mt-0 mb-0 white-divider"/>
                </li>
                <li class="nav-item active">
                    <a class="nav-link px-3 p-3 text-white">
                        <span class="me-2">
                            <img src="catalogue.png" alt="Catalogue" class="icon">
                        </span>
                        <span>
                            Catalogue
                        </span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link px-3 p-3 text-white">
                        <span class="me-2">
                            <img src="shopping-cart.png" alt="Panier" class="icon"/>
                        </span>
                        <span>
                            Panier
                        </span>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</div>
<div class="right">
    <div>
        <?php

        use App\Magasin\Lib\MessageFlash;

        $messageFlash = new MessageFlash();

        $messagesFlash = $messageFlash->lireTousMessages();

        foreach ($messagesFlash as $type => $messagesFlashPourUnType) {
            foreach ($messagesFlashPourUnType as $messageFlash) {
                echo <<< HTML
        <div class="alert alert-$type">
           $messageFlash
        </div>
        HTML;
            }
        }

        ?>


    </div>
    <div>
        <main>
            <?php
            /** @var string $cheminVueBody */
            require __DIR__ ."/$cheminVueBody";
            ?>
        </main>
    </div>
</div>

<div class="left">
    <aside>
        <nav>
            <?php
            if (ConnexionUtilisateur::estConnecte()) {
                echo '<div>
                    <a href="controleurFrontal.php?action=afficherParametres&controleur=utilisateurGenerique"><img src="../ressources/images/logo-client.png"></a>
                </div>';
            }

            /** @var array $onglets */
            foreach($onglets as $onglet => $lien) {
                echo '<a href="'.$lien .'">' . $onglet. '</a>';
            }

            ?>
        </nav>
    </aside>
</div>

<script src="../../ressources/scripts/fonctionsBasiques.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>