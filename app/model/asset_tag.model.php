<?php declare(strict_types=1);

namespace OsumiFramework\App\Model;

use OsumiFramework\OFW\DB\OModel;

class AssetTag extends OModel {
	function __construct() {
		$model = [
			'id_asset' => [
				'type'    => OModel::PK,
				'incr' => false,
				'ref' => 'asset.id',
				'comment' => 'Id del recurso'
			],
			'id_tag' => [
				'type'    => OModel::PK,
				'incr' => false,
				'ref' => 'tag.id',
				'comment' => 'Id de la tag'
			],
			'created_at' => [
				'type'    => OModel::CREATED,
				'comment' => 'Fecha de creación del registro'
			],
			'updated_at' => [
				'type'    => OModel::UPDATED,
				'nullable' => true,
				'default' => null,
				'comment' => 'Fecha de última modificación del registro'
			]
		];

		parent::load($model);
	}
}
