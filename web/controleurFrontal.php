<?php

require_once __DIR__ . '/../src/Lib/Psr4AutoloaderClass.php';

use App\Magasin\Controleurs\ControleurClient as ControleurClient;
use App\Magasin\Controleur\ControleurGenerique as ControleurGenerique;

$loader = new App\Magasin\Lib\Psr4AutoloaderClass();
$loader->register();
// enregistrement d'une association "espace de nom" → "dossier"
$loader->addNamespace('App\Magasin', __DIR__ . '/../src');

ControleurClient::loadMenu();

if (isset($_GET['controleur'])) {
    $controleur = $_GET['controleur'];
} else {
    $controleur = "produit";
}

$nomDeClasseControleur = '\App\Magasin\Controleurs\Controleur' . ucfirst($controleur);


if (class_exists($nomDeClasseControleur)) {
    if (isset($_GET['action'])) {
        $action = $_GET['action'];
    } else {
        $action = "afficherListe";
    }

    if (!in_array($action, get_class_methods($nomDeClasseControleur))) {
        $nomDeClasseControleur::afficherErreur(" L'action n'existe pas dans " . $nomDeClasseControleur);
    } else {
        $nomDeClasseControleur::$action();
    }
} else {
    ControleurGenerique::afficherErreur("Le controleur n'existe pas !");
}