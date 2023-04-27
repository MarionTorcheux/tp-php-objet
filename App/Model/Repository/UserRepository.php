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


    public function checkAuth(string $email, string $password): ?User
    {
        $q = sprintf(
            'SELECT * FROM `%s` WHERE `email`=:email AND `password`=:password',
            $this->getTable()
        );

        $stmt = $this->pdo->prepare($q);
        if (!$stmt) return null;

        $stmt->execute(['email' => $email, 'password' => $password]);

        $user_data = $stmt->fetch();

        return empty($user_data) ? null : new User($user_data);
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