<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php
        /** @var string $pagetitle */
        echo $pagetitle; ?>
    </title>
    <link rel="stylesheet" type="text/css" href="../ressources/css/root.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>

<header class="navbar fixed-top p-3">
    <div class="container-fluid d-flex justify-content-between">
        <?php
        use App\Magasin\Lib\ConnexionUtilisateur;
        // Set the default action and text
        $action = "afficherConnexion";
        $text = "Se connecter";

        if (ConnexionUtilisateur::estConnecte()) {
            $action = "deconnexion";
            $text = "Se déconnecter";
        }
        ?>
            <button type="submit" class="navbar-toggler navbar-light" data-bs-toggle="offcanvas" data-bs-target="#sidebar-nav">
                <span class="navbar-toggler-icon"></span>
            </button>

        <form action="controleurFrontal.php" method="post">
            <input type="hidden" name="action" value="<?= urlencode($action) ?>">
            <input type="hidden" name="controleur" value="utilisateurGenerique">

            <div class="text-end">
                <button type="submit" class="btn btn-outline-light">
                    <?= htmlspecialchars($text) ?>
                </button>
            </div>
        </form>
    </div>

</header>

<div class="offcanvas sidebar-nav" tabindex="-1" id="sidebar-nav">
    <div class="offcanvas-body p-0">
        <nav>
            <ul class="navbar-nav ">
                <?php
                if (ConnexionUtilisateur::estConnecte()):
                ?>
                <li class="nav-item">
                    <form action="controleurFrontal.php" method="post">
                        <input type="hidden" name="action" value="afficherParametres">
                        <input type="hidden" name="controleur" value="utilisateurGenerique">
                        <button class="nav-link px-3 my-3 text-white btn btn-link d-flex justify-content-start align-items-center" type="submit" style="width:100%">
                            <span class="me-2">
                                <img src="../ressources/images/logo-utilisateur.png" class="icon" alt="Utilisateur">
                            </span>
                            <span>
                                Utilisateur
                            </span>
                        </button>
                    </form>
                </li>
                <li>
                    <hr class="dropdown-divider mt-0 mb-0 text-white"/>
                </li>
                <?php endif;

                /** @var array $onglets */
                foreach($onglets[0] as $onglet => $lien) :
                ?>
                <li class="nav-item">
                    <form action="controleurFrontal.php" method="post">
                        <button class="nav-link px-3 p-3 text-white btn btn-link d-flex justify-content-start align-items-center" type="submit" style="width:100%">
                            <span class="me-2">
                                <img src="../ressources/images/<?=$onglets[1][$onglet]?>" alt="<?=htmlspecialchars( $onglet)?>" class="icon">
                            </span>
                            <span>
                                <?=htmlspecialchars($onglet)?>
                            </span>
                        </button>
                        <input type="hidden" name="action" value="<?=$onglets[0][$onglet]["action"]?>">
                        <input type="hidden" name="controleur" value="<?=$onglets[0][$onglet]["controleur"]?>">
                    </form>
                </li>
                <?php endforeach; ?>
            </ul>
        </nav>
    </div>
</div>

<div class="row flash-message">
    <?php

    use App\Magasin\Lib\MessageFlash;

    $messageFlash = new MessageFlash();

    $messagesFlash = $messageFlash->lireTousMessages();

    foreach ($messagesFlash as $type => $messagesFlashPourUnType) {
        foreach ($messagesFlashPourUnType as $messageFlash) {
            echo <<< HTML
            <div class="alert alert-$type" id="message-flash">
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