<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
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

<div class="offcanvas sidebar-nav" tabindex="-1" id="sidebar-nav">
    <div class="offcanvas-body p-0">
        <nav>
            <ul class="navbar-nav">
            <?php
            if (ConnexionUtilisateur::estConnecte()) {
                echo '<li class="nav-item">
                    <a class="nav-link px-3 my-3 text-white" href="controleurFrontal.php?action=afficherParametres&controleur=utilisateurGenerique">
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
                </li>';
            }

            /** @var array $onglets */
            foreach($onglets as $onglet => $lien) {
                echo '<li class="nav-item active">
                    <a class="nav-link px-3 p-3 text-white" href="'.$lien .'">
                        <span class="me-2">
                            <img src="catalogue.png" alt="' . $onglet. '" class="icon">
                        </span>
                        <span>
                            ' . $onglet. '
                        </span>
                    </a>
                </li>';
            }
            ?>
            </ul>
        </nav>
    </div>
</div>

<div class="row flash-message">
    <div class="col-12">

    </div>
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
<?php
/** @var string $cheminVueBody */
require __DIR__ ."/$cheminVueBody";
?>
<script src="../ressources/scripts/fonctionsBasiques.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>