<?php declare(strict_types=1);

namespace OsumiFramework\App\Model;

use OsumiFramework\OFW\DB\OModel;
use OsumiFramework\OFW\DB\OModelGroup;
use OsumiFramework\OFW\DB\OModelField;

class Connection extends OModel {
	function __construct() {
		$model = new OModelGroup(
			new OModelField(
				name: 'id_from',
				type: OMODEL_PK,
				incr: false,
				ref: 'scenario.id',
				comment: 'Id de un escenario'
			),
			new OModelField(
				name: 'id_to',
				type: OMODEL_PK,
				incr: false,
				ref: 'scenario.id',
				comment: 'Id del escenario con el que conecta'
			),
			new OModelField(
				name: 'orientation',
				type: OMODEL_TEXT,
				nullable: false,
				default: null,
				size: 5,
				comment: 'Sentido de la conexión up / down / left / right'
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
		$from = new Scenario();
		$from->find(['id' => $this->get('id_from')]);
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
		$to = new Scenario();
		$to->find(['id' => $this->get('id_to')]);
		$this->setTo($to);
	}
}
