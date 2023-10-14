<?php

namespace App\Covoiturage\Modele\Repository;

abstract class UtilisateurGeneriqueRepository extends AbstractRepository
{

    public function getOngletsMenus() {
        $sql = "SELECT M.nomOnglet 
                FROM Site_OngletsMenus M
                JOIN Site_AvoirAcces A ON A.nomOnglet = M.nomOnglet
                JOIN Site_Roles R ON R.idRole = A.idRole
                WHERE nomRole = :roleNameTag;";

        $pdoStatement = ConnexionBaseDeDonnee::getPdo()->prepare($sql);

        $values = array("roleNameTag" => $this->getRole());

        $pdoStatement -> execute($values);

        return $pdoStatement->fetch();

    }
}