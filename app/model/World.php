<?php declare(strict_types=1);
class World extends OModel {
	/**
	 * Configures current model object based on data-base table structure
	 */	function __construct() {
		$table_name  = 'world';
		$model = [
			'id' => [
				'type'    => OCore::PK,
				'comment' => 'Id único para cada mundo'
			],
			'name' => [
				'type'    => OCore::TEXT,
				'nullable' => false,
				'default' => null,
				'size' => 50,
				'comment' => 'Nombre del mundo'
			],
			'description' => [
				'type'    => OCore::LONGTEXT,
				'nullable' => true,
				'default' => null,
				'comment' => 'Descripción del mundo'
			],
			'word_one' => [
				'type'    => OCore::TEXT,
				'nullable' => false,
				'default' => null,
				'size' => 20,
				'comment' => 'Primera palabra para acceder al mundo'
			],
			'word_two' => [
				'type'    => OCore::TEXT,
				'nullable' => false,
				'default' => null,
				'size' => 20,
				'comment' => 'Segunda palabra para acceder al mundo'
			],
			'word_three' => [
				'type'    => OCore::TEXT,
				'nullable' => false,
				'default' => null,
				'size' => 20,
				'comment' => 'Tercera palabra para acceder al mundo'
			],
			'friendly' => [
				'type' => OCore::BOOL,
				'nullable' => false,
				'default' => false,
				'comment' => 'Indica si el mundo es amistoso'
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