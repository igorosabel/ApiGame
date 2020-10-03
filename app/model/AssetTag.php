<?php declare(strict_types=1);
class AssetTag extends OModel {
	/**
	 * Configures current model object based on data-base table structure
	 */	function __construct() {
		$table_name  = 'asset_tag';
		$model = [
			'id_asset' => [
				'type'    => OCore::PK,
				'incr' => false,
				'ref' => 'asset.id',
				'comment' => 'Id del recurso'
			],
			'id_tag' => [
				'type'    => OCore::PK,
				'incr' => false,
				'ref' => 'tag.id',
				'comment' => 'Id de la tag'
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