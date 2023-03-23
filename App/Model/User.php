<?php

namespace App\Model;

use LidemFramework\Model;

class User extends Model
{
	public const ROLE_ANNONCEUR = 1;
	public const ROLE_LOCATAIRE = 2;

    public string $nom;
    public string $prenom;
    public string $email;
    public string $password;
    public int $role_id;
}