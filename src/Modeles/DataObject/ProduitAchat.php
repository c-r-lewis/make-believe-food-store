<?php

namespace App\Magasin\Modeles\DataObject;

class ProduitAchat extends AbstractDataObject {

    private $idProduit;
    private $idAchat;
    private $nomProduit;
    private $quantite;
    private $prixProduitUnitaire;

    public function __construct($idProduit, $idAchat, $nomProduit, $quantite, $prixProduitUnitaire)
    {
        $this->idProduit = $idProduit;
        $this->idAchat = $idAchat;
        $this->nomProduit = $nomProduit;
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

    public function getNomProduit()
    {
        return $this->nomProduit;
    }

    public function setNomProduit($nomProduit): void
    {
        $this->nomProduit = $nomProduit;
    }

    public function getPrixProduitUnitaire()
    {
        return $this->prixProduitUnitaire;
    }

    public function formatTableau()
    {
        return [
            'idProduitTag' => $this->idProduit,
            'idAchatTag' => $this->idAchat,
            'nomProduitTag' => $this->nomProduit,
            'quantiteTag' => $this->quantite,
            'prixProduitUnitaireTag' => $this->prixProduitUnitaire,
        ];
    }
}