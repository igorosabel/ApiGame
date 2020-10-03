<?php declare(strict_types=1);
class Tag extends OModel {
	/**
	 * Configures current model object based on data-base table structure
	 */	function __construct() {
		$table_name  = 'tag';
		$model = [
			'id' => [
				'type'    => OCore::PK,
				'comment' => 'Id único para cada tag'
			],
			'name' => [
				'type'    => OCore::TEXT,
				'nullable' => false,
				'default' => null,
				'size' => 50,
				'comment' => 'Texto de la tag'
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