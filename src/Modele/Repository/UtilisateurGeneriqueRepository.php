<?php

namespace App\Covoiturage\Modele\Repository;

abstract class UtilisateurGeneriqueRepository extends AbstractRepository
{

    protected abstract static function getOngletsMenu();
}