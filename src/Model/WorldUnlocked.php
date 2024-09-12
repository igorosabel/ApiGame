<?php declare(strict_types=1);

namespace Osumi\OsumiFramework\App\Model;

use Osumi\OsumiFramework\DB\OModel;
use Osumi\OsumiFramework\DB\OModelGroup;
use Osumi\OsumiFramework\DB\OModelField;

class WorldUnlocked extends OModel {
	function __construct() {
		$model = new OModelGroup(
			new OModelField(
				name: 'id_game',
				type: OMODEL_PK,
				incr: false,
				ref: 'game.id',
				comment: 'Id de la partida'
			),
			new OModelField(
				name: 'id_world',
				type: OMODEL_PK,
				incr: false,
				ref: 'world.id',
				comment: 'Id del mundo desbloqueado'
			),
			new OModelField(
				name: 'created_at',
				type: OMODEL_CREATED,
				comment: 'Fecha de creación del registro'
			),
			new OModelField(
				name: 'updated_at',
				type: OMODEL_UPDATED,
				nullable: true,
				default: null,
				comment: 'Fecha de última modificación del registro'
			)
		);

		parent::load($model);
	}
}
