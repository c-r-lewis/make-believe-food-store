<?php

require_once __DIR__ . '/../src/Lib/Psr4AutoloaderClass.php';
// initialisation
$loader = new App\Covoiturage\Lib\Psr4AutoloaderClass();
$loader->register();
// enregistrement d'une association "espace de nom" → "dossier"
$loader->addNamespace('App\Covoiturage', __DIR__ . '/../src');


