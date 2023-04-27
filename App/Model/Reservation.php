<?php

namespace App\Model;
use LidemFramework\Model;

class Reservation extends Model
{
    public string $date_debut;
    public string $date_fin;
    public int $logement_id;
    public int $user_id;
}