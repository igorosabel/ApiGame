<?php declare(strict_types=1);
class User extends OModel {
	/**
	 * Configures current model object based on data-base table structure
	 */	function __construct() {
		$table_name  = 'user';
		$model = [
			'id' => [
				'type'    => OCore::PK,
				'comment' => 'Id único de cada usuario'
			],
			'email' => [
				'type'    => OCore::TEXT,
				'nullable' => false,
				'default' => null,
				'size' => 50,
				'comment' => 'Email del usuario'
			],
			'pass' => [
				'type'    => OCore::TEXT,
				'nullable' => false,
				'default' => null,
				'size' => 100,
				'comment' => 'Contraseña del usuario'
			],
			'admin' => [
				'type' => OCore::BOOL,
				'nullable' => false,
				'default' => false,
				'comment' => 'Indica si el usuario es administrador'
			],
			'created_at' => [
				'type'    => OCore::CREATED,
				'comment' => 'Fecha de creación del registro'
			],
			'updated_at' => [
				'type'    => OCore::UPDATED,
				'nullable' => true,
				'default' => null,
				'comment' => 'Fecha de última modificación del registro'
			]
		];

		parent::load($table_name, $model);
	}

	public function login(string $email, string $pass): bool {
		if ($this->find(['email' => $email])) {
			return password_verify($pass, $this->get('pass'));
		}
		else {
			return false;
		}
	}
}