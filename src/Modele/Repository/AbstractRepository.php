<?php

namespace App\Magasin\Modele\Repository;

use App\Magasin\Modele\DataObject\AbstractDataObject as AbstractDataObject;

abstract class AbstractRepository
{
    abstract protected function getNomTable(): string;

    abstract protected function sauvegarder(AbstractDataObject $dataObject);
    abstract protected function construireDepuisTableau(array $objetFormatTableau);

    public function recuperer(): array {
        $table = $this->getNomTable();
        $sql = "SELECT * FROM $table";
        $pdoStatement = ConnexionBaseDeDonnee::getPdo()->query($sql);
        $objets = [];
        foreach($pdoStatement as $objetFormatTableau) {
            $this->construireDepuisTableau($objetFormatTableau);
        }
        return $objets;
    }
}