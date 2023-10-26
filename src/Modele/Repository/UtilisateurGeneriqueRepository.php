<?php

namespace App\Magasin\Modele\Repository;

abstract class UtilisateurGeneriqueRepository extends AbstractRepository
{

    public function getOngletsMenus() : array {
        $sql = "SELECT M.nomOnglet 
                FROM Site_OngletsMenus M
                JOIN Site_AvoirAcces A ON A.nomOnglet = M.nomOnglet
                JOIN Site_Roles R ON R.idRole = A.idRole
                WHERE nomRole = :roleNameTag;";

        $pdoStatement = ConnexionBaseDeDonnee::getPdo()->prepare($sql);

        $values = array("roleNameTag" => $this->getRole());

        $pdoStatement -> execute($values);

        $resultat = [];
        $i=0;

        foreach ($pdoStatement as $ligne) {
            $resultat[$i] = $ligne["nomOnglet"];
            $i++;
        }
        return $resultat;

    }
}