<?php

namespace App\Magasin\Modeles\Repository;

use App\Magasin\Modeles\DataObject\Utilisateur as Utilisateur;

class UtilisateurRepository extends AbstractRepository
{


    protected function getNomTable(): string
    {
        return "Site_UtilisateursConnectes";
    }

    protected function construireDepuisTableau(array $objetFormatTableau): Utilisateur
    {
        $utilisateur = new Utilisateur($objetFormatTableau['email'],$objetFormatTableau['nom'],$objetFormatTableau['prenom'],$objetFormatTableau['mdp']);
        return $utilisateur;
    }

    protected function getNomsColonnes(): array
    {
        return
            [
                "email",
                "nom",
                "prenom",
                "mdp",
                "estAdmin"
            ];
    }

    protected function getClePrimaire(): string
    {
        return "email";
    }

    public function emailExiste(String $email): bool {
        $sql = "SELECT * FROM Site_UtilisateursConnectes WHERE email=:emailTag";
        $pdostatment = ConnexionBaseDeDonnee::getPdo()->prepare($sql);

        $values = array("emailTag"=>$email);

        $pdostatment->execute($values);

        return $pdostatment->fetch()!==false;
    }
}