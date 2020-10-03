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
}