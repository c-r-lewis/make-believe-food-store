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
        Hello world
    </header>

    <div>
        <main>
            <!-- Télécharger la vue correspondante ic -->
        </main>
    </div>
</div>

<div class="left">
    <aside>
        <nav>
            <?php
            /** @var string $cheminBody */
            require __DIR__ ."/{$cheminBody}";
            ?>
        </nav>
    </aside>
</div>

<script src="../../ressources/scripts/fonctionsBasiques.js"></script>
</body>
</html>