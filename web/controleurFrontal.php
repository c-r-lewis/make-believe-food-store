<?php

use App\Magasin\Controleurs\ControleurProduit;
use App\Magasin\Lib\MessageFlash;

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
        (new MessageFlash())->ajouter("danger", "L'action '$action' n'existe pas dans $nomDeClasseControleur.");
        (new ControleurProduit())::afficherCatalogue();
    }
} else {
    (new MessageFlash())->ajouter("danger", "Le contrôleur '$controleur' n'existe pas.");
    (new ControleurProduit())::afficherCatalogue();
}