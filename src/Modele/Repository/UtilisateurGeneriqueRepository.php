<?php

namespace App\Covoiturage\Modele\Repository;

abstract class UtilisateurGeneriqueRepository extends AbstractRepository
{

    protected function getOngletsMenus() {
        $sql = sprintf("SELECT M.nomOnglet 
                FROM Site_OngletsMenus M
                JOIN Site_AvoirAcces A ON A.nomOnglet = M.nomOnglet
                JOIN Site_Roles R ON R.idRole = A.idRole
                WHERE nomRole = '%s';", $this->getRole());
    }
}