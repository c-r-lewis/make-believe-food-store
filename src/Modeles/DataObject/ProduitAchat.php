<?php

namespace App\Magasin\Modeles\DataObject;

class ProduitAchat extends AbstractDataObject {

    private $idProduit;
    private $idAchat;
    private $quantite;
    private $prixProduitUnitaire;

    public function __construct($idProduit, $idAchat, $quantite, $prixProduitUnitaire)
    {
        $this->idProduit = $idProduit;
        $this->idAchat = $idAchat;
        $this->quantite = $quantite;
        $this->prixProduitUnitaire = $prixProduitUnitaire;
    }

    public function getIdProduit()
    {
        return $this->idProduit;
    }

    public function getIdAchat()
    {
        return $this->idAchat;
    }

    public function getQuantite()
    {
        return $this->quantite;
    }

    public function getPrixProduitUnitaire()
    {
        return $this->prixProduitUnitaire;
    }

    public function formatTableau()
    {
        return [
            'idProduit' => $this->idProduit,
            'idAchat' => $this->idAchat,
            'quantite' => $this->quantite,
            'prixProduitUnitaire' => $this->prixProduitUnitaire,
        ];
    }
}