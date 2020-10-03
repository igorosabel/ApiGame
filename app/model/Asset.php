<?php declare(strict_types=1);
class Asset extends OModel {
	/**
	 * Configures current model object based on data-base table structure
	 */	function __construct() {
		$table_name  = 'asset';
		$model = [
			'id' => [
				'type'    => OCore::PK,
				'comment' => 'Id único de cada recurso'
			],
			'id_world' => [
				'type'    => OCore::NUM,
				'nullable' => false,
				'default' => null,
				'ref' => 'world.id',
				'comment' => 'Id del mundo en el que se usa el recurso o NULL si sirve para todos'
			],
			'name' => [
				'type'    => OCore::TEXT,
				'nullable' => false,
				'default' => null,
				'size' => 50,
				'comment' => 'Nombre del recurso'
			],
			'file' => [
				'type'    => OCore::TEXT,
				'nullable' => false,
				'default' => null,
				'size' => 100,
				'comment' => 'URL al archivo del recurso'
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