<?php

namespace App\Magasin\Modeles\Repository;
use App\Magasin\Modeles\DataObject\AbstractDataObject as AbstractDataObject;
use PDOException;

abstract class AbstractRepository
{
    abstract protected function getNomTable(): string;

    abstract protected function getNomsColonnes(): array;

    abstract protected function getClePrimaire(): string;

    public function sauvegarder(AbstractDataObject $object): void
    {
        try {
            $sql = "INSERT INTO " . $this -> getNomTable() . "(";
            $sqlTag = "";
            $listeAttributs = $this -> getNomsColonnes();
            for ($i=0; $i<sizeof($listeAttributs)-1; $i++) {
                $sql .= $listeAttributs[$i] . ", ";
                $sqlTag .= ":" . $listeAttributs[$i] . "Tag, ";
            }
            $sql .= $listeAttributs[sizeof($listeAttributs)-1] . ") VALUES (" . $sqlTag . ":" . $listeAttributs[$i] . "Tag);";
            var_dump($sql);
            $pdoStatement = ConnexionBaseDeDonnee::getPdo()->prepare($sql);

            $values = $object->formatTableau();
            $pdoStatement->execute($values);
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return;
        }
    }

    abstract protected function construireDepuisTableau(array $objetFormatTableau) : AbstractDataObject;

    public function recuperer(): array
    {
        $table = $this->getNomTable();
        $sql = "SELECT * FROM $table";
        $pdoStatement = ConnexionBaseDeDonnee::getPdo()->query($sql);
        $objets = [];
        foreach ($pdoStatement as $objetFormatTableau) {
            $this->construireDepuisTableau($objetFormatTableau);
        }
        return $objets;
    }

    public function recupererParClePrimaire(string $clePrimaire): AbstractDataObject {
        $nomTable = $this->getNomTable();
        $nomClePrimaire = $this->getClePrimaire();
        $tag = $nomClePrimaire . "Tag";
        $sql = "SELECT * FROM $nomTable WHERE $nomClePrimaire = :$tag";

        $pdoStatement = ConnexionBaseDeDonnee::getPdo()->prepare($sql);

        $values = array(
            $tag => $clePrimaire
        );

        $pdoStatement ->execute($values);
        return $this->construireDepuisTableau($pdoStatement->fetch());
    }
}