<?php

use App\App;

// Raccourci pour le séparateur de dossier (qui change en fonction de la config du serveur)
const DS = DIRECTORY_SEPARATOR;
// Constante pour obtenir où que ce soit, le chemin absolu vers la racine du projet
define( 'APP_ROOT_PATH', dirname(__FILE__ ). DS );

require_once 'vendor/autoload.php';

App::get()->start();
