<?php

namespace App\Covoiturage\Modele\Repository;

class ClientRepository extends UtilisateurConnecteRepository
{
    protected function construireDepuisTableau(array $objetFormatTableau): Client
    {
        $utilisateur = new Client();
        $utilisateur->setNom($objetFormatTableau['nom']);
        $utilisateur->setMdp($objetFormatTableau['mdp']);
        $utilisateur->setEmail($objetFormatTableau['email']);
        $utilisateur->setPrenom($objetFormatTableau['prenom']);
        return $utilisateur;
    }

    protected static function getOngletsMenu() {
        $sql = "SELECT";
    }

}