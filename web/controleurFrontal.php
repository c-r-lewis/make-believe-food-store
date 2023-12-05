<?php

use App\Magasin\Controleurs\ControleurProduit;
use App\Magasin\Lib\MessageFlash;

require_once __DIR__ . '/../src/Lib/Psr4AutoloaderClass.php';

$loader = new App\Magasin\Lib\Psr4AutoloaderClass();
$loader->register();
$loader->addNamespace('App\Magasin', __DIR__ . '/../src');

if (isset($_POST["controleur"])) {
    $controleur = $_POST["controleur"];
} else {
    $controleur = "produit";
}
$nomDeClasseControleur = '\App\Magasin\Controleurs\Controleur' . ucfirst($controleur);

if (class_exists($nomDeClasseControleur)) {
    if (isset($_POST["action"])) {
        $action = $_POST["action"];
    } elseif (isset($_GET["action"])) {
        $action = $_GET["action"];
    } else {
        $action = "afficherCatalogue";
    }

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