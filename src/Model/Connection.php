<?php declare(strict_types=1);

namespace Osumi\OsumiFramework\App\Model;

use Osumi\OsumiFramework\ORM\OModel;
use Osumi\OsumiFramework\ORM\OPK;
use Osumi\OsumiFramework\ORM\OField;
use Osumi\OsumiFramework\ORM\OCreatedAt;
use Osumi\OsumiFramework\ORM\OUpdatedAt;

class Connection extends OModel {
	#[OPK(
	  comment: 'Id de un escenario',
	  ref: 'scenario.id'
	)]
	public ?int $id_from;

	#[OPK(
	  comment: 'Id del escenario con el que conecta',
	  ref: 'scenario.id'
	)]
	public ?int $id_to;

	#[OField(
	  comment: 'Sentido de la conexión up / down / left / right',
	  nullable: false,
	  max: 5,
	  default: null
	)]
	public ?string $orientation;

	#[OCreatedAt(
	  comment: 'Fecha de creación del registro'
	)]
	public ?string $created_at;

	#[OUpdatedAt(
	  comment: 'Fecha de última modificación del registro'
	)]
	public ?string $updated_at;

	private ?Scenario $from = null;

	/**
	 * Obtiene el escenario desde el que conecta
	 *
	 * @return Scenario Escenario desde el que conecta
	 */
	public function getFrom(): Scenario {
		if (is_null($this->from)) {
			$this->loadFrom();
		}
		return $this->from;
	}

	/**
	 * Guarda el escenario desde el que conecta
	 *
	 * @param Scenario $from Escenario desde el que conecta
	 *
	 * @return void
	 */
	public function setFrom(Scenario $from): void {
		$this->from = $from;
	}

	/**
	 * Carga el escenario desde el que conecta
	 *
	 * @return void
	 */
	public function loadFrom(): void {
		$from = Scenario::findOne(['id' => $this->id_from]);
		$this->setFrom($from);
	}

	private ?Scenario $to = null;

	/**
	 * Obtiene el escenario al que conecta
	 *
	 * @return Scenario Escenario al que conecta
	 */
	public function getTo(): Scenario {
		if (is_null($this->to)) {
			$this->loadTo();
		}
		return $this->to;
	}

	/**
	 * Guarda el escenario al que conecta
	 *
	 * @param Scenario $to Escenario al que conecta
	 *
	 * @return void
	 */
	public function setTo(Scenario $to): void {
		$this->to = $to;
	}

	/**
	 * Carga el escenario al que conecta
	 *
	 * @return void
	 */
	public function loadTo(): void {
		$to = Scenario::findOne(['id' => $this->id_to]);
		$this->setTo($to);
	}
}
