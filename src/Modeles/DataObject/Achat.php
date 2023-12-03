<?php

namespace App\Magasin\Modeles\DataObject;

class Achat extends AbstractDataObject {

    private $idAchat;
    private $dateAchat;
    private $email;

    public function __construct($idAchat, $date, $email)
    {
        $this->idAchat = $idAchat;
        $this->dateAchat = $date;
        $this->email = $email;
    }

    public function __construct1($idAchat, $email)
    {
        $this->idAchat = $idAchat;
        $this->dateAchat = date("Y-m-d");
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

    public function getDate()
    {
        return $this->dateAchat;
    }

    public function formatTableau(): array
    {
        return [
            'idAchatTag' => $this->idAchat,
            'dateAchatTag' => $this->dateAchat,
            'emailTag' => $this->email
        ];
    }
}