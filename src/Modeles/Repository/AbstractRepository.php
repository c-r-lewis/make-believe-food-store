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
            $sql = "INSERT INTO " . $this->getNomTable() . "(";
            $sqlTag = "";
            $listeAttributs = $this->getNomsColonnes();
            for ($i = 0; $i < sizeof($listeAttributs) - 1; $i++) {
                $sql .= $listeAttributs[$i] . ", ";
                $sqlTag .= ":" . $listeAttributs[$i] . "Tag, ";
            }
            $sql .= $listeAttributs[sizeof($listeAttributs) - 1] . ") VALUES (" . $sqlTag . ":" . $listeAttributs[$i] . "Tag);";
            $pdoStatement = ConnexionBaseDeDonnee::getPdo()->prepare($sql);

            $values = $object->formatTableau();
            $pdoStatement->execute($values);
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return;
        }
    }

    abstract protected function construireDepuisTableau(array $objetFormatTableau): AbstractDataObject;

    public function recuperer(): array
    {
        $table = $this->getNomTable();
        $sql = "SELECT * FROM $table";
        $pdoStatement = ConnexionBaseDeDonnee::getPdo()->query($sql);
        $objets = [];
        foreach ($pdoStatement as $objetFormatTableau) {
            $objets[] = $this->construireDepuisTableau($objetFormatTableau);
        }
        return $objets;
    }

    public function recupererParClePrimaire(string $clePrimaire): AbstractDataObject
    {
        $nomTable = $this->getNomTable();
        $nomClePrimaire = $this->getClePrimaire();
        $tag = $nomClePrimaire . "Tag";
        $sql = "SELECT * FROM $nomTable WHERE $nomClePrimaire = :$tag";

        $pdoStatement = ConnexionBaseDeDonnee::getPdo()->prepare($sql);

        $values = array(
            $tag => $clePrimaire
        );

        $pdoStatement->execute($values);
        return $this->construireDepuisTableau($pdoStatement->fetch());
    }

    public function clePrimaireExiste(mixed $clePrimaire): bool
    {
        $nomTable = $this->getNomTable();
        $nomClePrimaire = $this->getClePrimaire();
        $tag = $nomClePrimaire . "Tag";
        $sql = "SELECT * FROM $nomTable WHERE $nomClePrimaire=:$tag";

        $pdostatment = ConnexionBaseDeDonnee::getPdo()->prepare($sql);

        $values = array($tag => $clePrimaire);

        $pdostatment->execute($values);

        return $pdostatment->fetch() !== false;
    }

    public function mettreAJour(string $clePrimaire, array $nouvellesValeurs)
    {
        try {
            $nouvellesValeurs['clePrimaire'] = $clePrimaire;
            $sql = "UPDATE " . $this->getNomTable() . " SET ";
            $sqlTag = "";
            $listeAttributs = $this->getNomsColonnes();
            for ($i = 0; $i < sizeof($listeAttributs) - 1; $i++) {
                if (
                    isset($nouvellesValeurs[$listeAttributs[$i]])
                    && $nouvellesValeurs[$listeAttributs[$i]] != ""
                ) {
                    $sql .= $listeAttributs[$i] . " = ";
                    $sqlTag = ":" . $listeAttributs[$i] . ", ";
                    $sql .= $sqlTag;
                }
            }
            $sql = rtrim($sql, ', ');
            $nomClePrimaire = $this->getClePrimaire();
            $sql .= " WHERE $nomClePrimaire = :clePrimaire";
            $pdoStatment = ConnexionBaseDeDonnee::getPdo()->prepare($sql);
            $pdoStatment->execute($nouvellesValeurs);
        } catch (PDOException $e) {
            echo $e->getMessage();
    }
    }
}