<?php

use App\Magasin\Controleurs\ControleurGenerique;

require_once __DIR__ . '/../src/Lib/Psr4AutoloaderClass.php';

$loader = new App\Magasin\Lib\Psr4AutoloaderClass();
$loader->register();
$loader->addNamespace('App\Magasin', __DIR__ . '/../src');

$controleur = isset($_GET['controleur']) ? $_GET['controleur'] : "produit";
$nomDeClasseControleur = '\App\Magasin\Controleurs\Controleur' . ucfirst($controleur);

if (class_exists($nomDeClasseControleur)) {
    $action = isset($_GET['action']) ? $_GET['action'] : "afficherCatalogue";

    if (method_exists($nomDeClasseControleur, $action)) {
        $nomDeClasseControleur::$action();
    } else {
        (new ControleurGenerique)::erreur("L'action '$action' n'existe pas dans $nomDeClasseControleur.");
    }
} else {
    (new ControleurGenerique)::erreur("Le contrôleur '$controleur' n'existe pas.");
}
