<?php declare(strict_types=1);
class Connection extends OModel {
	/**
	 * Configures current model object based on data-base table structure
	 */
	function __construct() {
		$table_name  = 'connection';
		$model = [
			'id_from' => [
				'type'    => OCore::PK,
				'incr' => false,
				'comment' => 'Id de la categoría en la que está el producto'
			],
			'id_to' => [
				'type'    => OCore::PK,
				'incr' => false,
				'comment' => 'Id del producto'
			],
			'direction' => [
				'type'    => OCore::NUM,
				'nullable' => false,
				'default' => null,
				'comment' => 'Id del producto'
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