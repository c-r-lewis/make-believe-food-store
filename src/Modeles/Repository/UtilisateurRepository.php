<?php

namespace App\Magasin\Modeles\Repository;

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

    protected function getClePrimaire(): string
    {
        return "idUtilisateur";
    }
}