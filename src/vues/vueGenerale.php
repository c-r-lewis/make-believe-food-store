<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>A changer en fonction de la vue</title>
    <link rel="stylesheet" type="text/css" href="../ressources/css/style.css">
</head>
<body>
<div class="right">
    <header>
        <?php
            use App\Magasin\Lib\ConnexionUtilisateur as ConnexionUtilisateur;
            $imageSrc = "../ressources/images/connexion-logo.png";
            $alt = "Se connecter";
            $action = "afficherConnexion";
            if (ConnexionUtilisateur::estConnecte()) {
                $imageSrc = "../ressources/images/logo-quitter.png";
                $alt = "Se déconnecter";
                $action = "deconnexion";
            }
            echo '<a href="controleurFrontal.php?action='.$action.'&controleur=utilisateurGenerique"><img src="'.$imageSrc.'" alt="'.$alt.'"/></a>';
        ?>
    </header>

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
                    <a href="controleurFrontal.php?action=afficherParametres"><img src="../ressources/images/logo-client.png"></a>
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
</body>
</html>