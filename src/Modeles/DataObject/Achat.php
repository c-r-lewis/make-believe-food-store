<?php

namespace App\Magasin\Modeles\DataObject;

class Achat extends AbstractDataObject {

    private $idAchat;
    private $date;
    private $email;

    public function __construct($idAchat, $date, $email)
    {
        $this->idAchat = $idAchat;
        $this->date = $date;
        $this->email = $email;
    }

    public function __construct1($idAchat, $email)
    {
        $this->idAchat = $idAchat;
        $this->date = date("Y-m-d H:i:s");
        $this->email = $email;
    }

    public function getIdAchat()
    {
        return $this->idAchat;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getIdProduit()
    {
        return $this->idProduit;
    }

    public function getQuantite()
    {
        return $this->quantite;
    }

    public function getDate()
    {
        return $this->date;
    }

    public function formatTableau()
    {
        return [
            'idAchat' => $this->idAchat,
            'date' => $this->date,
            'email' => $this->email
        ];
    }
}