<?php

require_once __DIR__ . '/../src/Lib/Psr4AutoloaderClass.php';

$loader = new App\Magasin\Lib\Psr4AutoloaderClass();
$loader->register();
// enregistrement d'une association "espace de nom" → "dossier"
$loader->addNamespace('App\Magasin', __DIR__ . '/../src');

use App\Magasin\Controleurs\ControleurClient as ControleurClient;

ControleurClient::loadMenu();