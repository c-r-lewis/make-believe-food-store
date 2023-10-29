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
        <a href="controleurFrontal.php?action=afficherConnexion"><img src="../ressources/images/connexion-logo.png" alt="Se connecter"/></a>
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