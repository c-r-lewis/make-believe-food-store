<?php

namespace App\Covoiturage\Modele\Repository;

use AbstractDataObject;
use App\Covoiturage\Modele\Repository\AbstractRepository;
use Utilisateur;

class UtilisateurRepository extends AbstractRepository
{


    protected function getNomTable(): string
    {
        return "Site_Utilisateurs";
    }

    protected function construireDepuisTableau(array $objetFormatTableau): Utilisateur
    {
        $utilisateur = new Utilisateur();
        $utilisateur->setNom($objetFormatTableau['nom']);
        $utilisateur->setMdp($objetFormatTableau['mdp']);
        $utilisateur->setEmail($objetFormatTableau['email']);
        $utilisateur->setPrenom($objetFormatTableau['prenom']);
        return $utilisateur;
    }

    protected function getNomsColonnes(): array
    {
        return
            [
                "idUtilisateur",
                "emailUtilisateur",
                "nomUtilisateur",
                "prenomUtilisateur",
                "mdpUtilisateur"
            ];
    }
}