<?php declare(strict_types=1);
class Item extends OModel {
	/**
	 * Configures current model object based on data-base table structure
	 */	function __construct() {
		$table_name  = 'item';
		$model = [
			'id' => [
				'type'    => OCore::PK,
				'comment' => 'Id único para cada item'
			],
			'type' => [
				'type'    => OCore::NUM,
				'nullable' => false,
				'default' => null,
				'comment' => 'Tipo de item 0 moneda 1 arma 2 poción 3 equipamiento 4 objeto'
			],
			'id_asset' => [
				'type'    => OCore::NUM,
				'nullable' => false,
				'default' => null,
				'ref' => 'asset.id',
				'comment' => 'Id del recurso usado para el item'
			],
			'name' => [
				'type'    => OCore::TEXT,
				'nullable' => false,
				'default' => null,
				'size' => 50,
				'comment' => 'Nombre del item'
			],
			'money' => [
				'type'    => OCore::NUM,
				'nullable' => true,
				'default' => null,
				'comment' => 'Número de monedas que vale al ser comprado o vendido, NULL si no se puede comprar o vender'
			],
			'health' => [
				'type'    => OCore::NUM,
				'nullable' => true,
				'default' => null,
				'comment' => 'Puntos de daño que cura el item si es una poción o NULL si no lo es'
			],
			'attack' => [
				'type'    => OCore::NUM,
				'nullable' => true,
				'default' => null,
				'comment' => 'Puntos de daño que hace el item si es un arma o NULL si no lo es'
			],
			'defense' => [
				'type'    => OCore::NUM,
				'nullable' => true,
				'default' => null,
				'comment' => 'Puntos de defensa que otorga el item si es un equipamiento o NULL si no lo es'
			],
			'speed' => [
				'type'    => OCore::NUM,
				'nullable' => true,
				'default' => null,
				'comment' => 'Puntos de velocidad que otorga el item si es un equipamiento o NULL si no lo es'
			],
			'wearable' => [
				'type'    => OCore::NUM,
				'nullable' => true,
				'default' => null,
				'comment' => 'Indica donde se puede equipar en caso de ser equipamiento Cabeza 0 Cuello 1 Cuerpo 2 Botas 3 o NULL si no se puede equipar'
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