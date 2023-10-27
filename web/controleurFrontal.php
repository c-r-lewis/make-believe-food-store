<?php

require_once __DIR__ . '/../src/Lib/Psr4AutoloaderClass.php';
// initialisation
$loader = new App\Magasin\Lib\Psr4AutoloaderClass();
$loader->register();
// enregistrement d'une association "espace de nom" → "dossier"
$loader->addNamespace('App\Covoiturage', __DIR__ . '/../src');

if (isset($_GET['controleur'])) {
    $controleur = $_GET['controleur'];
} else {
    $controleur = "voiture";
}

$nomDeClasseControleur = '\App\Covoiturage\Controleur\Controleur' . ucfirst($controleur);

if (class_exists($nomDeClasseControleur)) {
    // On récupère l'action passée dans l'URL
    if (isset($_GET['action'])) {
        $action = $_GET['action'];
    } else {
        $action = "afficherListe";
    }
    if (!in_array($action, get_class_methods($nomDeClasseControleur))) {
        $nomDeClasseControleur::afficherErreur(" L'action n'existe pas dans " . $nomDeClasseControleur);
    } else {
        // Appel de la méthode statique $action du contrôleur
        $nomDeClasseControleur::$action();
    }
}


