<?php

namespace LidemFramework;

use PDO;

abstract class Repository
{
	protected abstract function getTable(): string;
	protected abstract function getModel(): string;

	public function __construct(
		protected readonly PDO $pdo
	)
	{ }

	public function findAll(): array
	{
		$q = 'SELECT * FROM '. call_user_func( [ $this, 'getTable' ] );
		$stmt = $this->pdo->query( $q );

		$stmt->execute();

		$arr_result = [];

		$model = call_user_func( [ $this, 'getModel' ] );

		while( $data = $stmt->fetch() ) {
			$arr_result[] = new $model( $data );
		};

		return $arr_result;
	}

	public function findById( int $id ): ?Model
	{
		$q = 'SELECT * FROM '. call_user_func( [ $this, 'getTable' ] ) .' WHERE id=:id';
		$stmt = $this->pdo->prepare( $q );

		$stmt->execute([
			'id' => $id
		]);

		$model = call_user_func( [ $this, 'getModel' ] );
		$data = $stmt->fetch();

		return $data ? new $model( $data ) : null;
	}
}