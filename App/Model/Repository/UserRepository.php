<?php

namespace App\Model\Repository;

use LidemFramework\Repository;

use App\Model\User;

class UserRepository extends Repository
{
	protected function getTable(): string
	{
		return 'users';
	}

	protected function getModel(): string
	{
		return User::class;
	}

	public function create( User $new_user ): void
	{
		$q = 'INSERT INTO '. $this->getTable() .' (nom, prenom, email, password, role_id) ';
		$q .= 'VALUES (:nom, :prenom, :email, :password, :role_id)';

		$stmt = $this->pdo->prepare( $q );

		$stmt->execute([
			'nom' => $new_user->nom,
			'prenom' => $new_user->prenom,
			'email' => $new_user->email,
			'password' => $new_user->password,
			'role_id' => $new_user->role_id
		]);
	}
}