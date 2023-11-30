<?php

namespace App\Magasin\Modeles\Repository;

use App\Magasin\Modeles\DataObject\AbstractDataObject as AbstractDataObject;
use PDOException;

abstract class AbstractRepository
{
    abstract protected function getNomTable(): string;

    abstract protected function getNomsColonnes(): array;

    abstract protected function getClePrimaire(): array;

    public function mettreAJour(AbstractDataObject $object): void
    {
        $sql = "UPDATE " . $this->getNomTable() . " SET ";
        $listeAttributs = $this->getNomsColonnes();
        $listeClesPrimaires = $this->getClePrimaire();

        for ($i = 0; $i < sizeof($listeAttributs) - 1; $i++) {
            $sql .= $listeAttributs[$i] . " = :" . $listeAttributs[$i] . "Tag, ";
        }

        $sql .= $listeAttributs[sizeof($listeAttributs) - 1] . " = :" . $listeAttributs[sizeof($listeAttributs) - 1] . "Tag ";

        if (!empty($listeClesPrimaires)) {
            $sql .= "WHERE ";

            foreach ($listeClesPrimaires as $clePrimaire) {
                $sql .= $clePrimaire . " = :" . $clePrimaire . "Tag AND ";
            }

            $sql = rtrim($sql, 'AND ');
        }

        $pdoStatement = ConnexionBaseDeDonnee::getPdo()->prepare($sql);

        $pdoStatement->execute($object->formatTableau());
    }


    public function supprimerParAbstractDataObject(AbstractDataObject $object): void
    {
        $clePrimaire = $this->getClePrimaire();
        $sql = "DELETE FROM " . $this->getNomTable() . " WHERE ";

        foreach ($clePrimaire as $attribut) {
            $tag = $attribut . "Tag";
            $sql .= $attribut . " = :" . $tag . " AND ";
            $values[":" . $tag] = $object->formatTableau()[$tag];
        }

        $sql = rtrim($sql, ' AND ');

        $pdoStatement = ConnexionBaseDeDonnee::getPdo()->prepare($sql);

        $pdoStatement->execute($values);
    }


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
        $nomsClesPrimaire = $this->getClePrimaire();

        if (count($clePrimaire) !== count($nomsClesPrimaire)) {
            throw new InvalidArgumentException("Attention au nombre d'arguments pour la clé primaire");
        }

        $conditions = [];
        $values = [];
        $i = 0;
        foreach ($nomsClesPrimaire as $clePrimaireNom) {
            $tag = $clePrimaireNom . "Tag";

            if (!isset($clePrimaire[$i])) {
                throw new InvalidArgumentException("La valeur pour la clé primaire est manquante.");
            }

            $conditions[] = "$clePrimaireNom = :$tag";
            $values[":$tag"] = $clePrimaire[$i];
            $i++;
        }

        $sql = "SELECT * FROM $nomTable WHERE " . implode(' AND ', $conditions);

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
        $nomsClePrimaire = $this->getClePrimaire();

        if (count($clePrimaire) !== count($nomsClePrimaire)) {
            throw new InvalidArgumentException("Attention au nombre d'arguments pour la clé primaire");
        }

        $conditions = [];
        $values = [];
        foreach ($nomsClePrimaire as $index => $nomClePrimaire) {
            $tag = $nomClePrimaire . "Tag";
            $conditions[] = "$nomClePrimaire = :$tag";
            $values[":$tag"] = $clePrimaire[$index];
        }

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