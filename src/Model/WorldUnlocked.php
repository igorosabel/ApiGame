<?php declare(strict_types=1);

namespace Osumi\OsumiFramework\App\Model;

use Osumi\OsumiFramework\ORM\OModel;
use Osumi\OsumiFramework\ORM\OPK;
use Osumi\OsumiFramework\ORM\OField;
use Osumi\OsumiFramework\ORM\OCreatedAt;
use Osumi\OsumiFramework\ORM\OUpdatedAt;

class WorldUnlocked extends OModel {
	#[OPK(
	  comment: 'Id de la partida',
	  ref: 'game.id'
	)]
	public ?int $id_game;

	#[OPK(
	  comment: 'Id del mundo desbloqueado',
	  ref: 'world.id'
	)]
	public ?int $id_world;

	#[OCreatedAt(
	  comment: 'Fecha de creación del registro'
	)]
	public ?string $created_at;

	#[OUpdatedAt(
	  comment: 'Fecha de última modificación del registro'
	)]
	public ?string $updated_at;
}
