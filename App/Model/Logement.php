<?php

namespace App\Model;
use LidemFramework\Model;
class Logement extends Model
{
        public string $pays;
        public string $adresse;
        public string $ville;
        public float $prix;
        public string $surface;
        public string $description;
        public int $couchage;
        public string $photo;
        public string $titre;

        public array $type_logement;


}