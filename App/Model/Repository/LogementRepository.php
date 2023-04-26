<?php

namespace App\Model\Repository;

use LidemFramework\Repository;

use App\Model\Logement;

class LogementRepository extends Repository
{
	protected function getTable(): string
	{
		return 'logements';
	}

	protected function getModel(): string
	{
		return Logement::class;
	}

    public function create( Logement $new_logement): void
    {

        $q = 'INSERT INTO '. $this->getTable() .' (pays, adresse, ville, prix, surface, description, couchage, photo,annonceur_id,type_logement_id,titre) ';
        $q .= 'VALUES (:pays, :adresse, :ville, :prix, :surface, :description, :couchage, :photo, :annonceur_id, :type_logement_id, :titre)';

        $stmt = $this->pdo->prepare( $q );

        $stmt->execute([
            'pays' => $new_logement->pays,
            'adresse' => $new_logement->adresse,
            'ville' => $new_logement->ville,
            'prix' => intval($new_logement->prix),
            'surface' => $new_logement->surface,
            'description' => $new_logement->description,
            'couchage' => $new_logement->couchage,
            'photo' => $new_logement->photo,
            'annonceur_id' => $new_logement->annonceur_id,
            'type_logement_id' => $new_logement->type_logement_id,
            'titre'=>$new_logement->titre
        ]);


    }



    public function findByIdWithInfos($id)
    {
        $q = 'SELECT  logements.*, users.nom, users.prenom, types_logement.libelle FROM logements 
                    INNER JOIN users on users.id = logements.annonceur_id
                    INNER JOIN types_logement on logements.type_logement_id = types_logement.id
                    WHERE logements.id = :id;';

        $stmt = $this->pdo->prepare( $q );

        $stmt->execute([
            'id' => $id
        ]);

        $model = call_user_func( [ $this, 'getModel' ] );
        $data = $stmt->fetch();



        return $data ? new $model( $data ) : null;
    }


}