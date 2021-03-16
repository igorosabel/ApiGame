<?php declare(strict_types=1);

namespace OsumiFramework\App\Model;

use OsumiFramework\OFW\DB\OModel;

class Connection extends OModel {
	/**
	 * Configures current model object based on data-base table structure
	 */	function __construct() {
		$table_name  = 'connection';
		$model = [
			'id_from' => [
				'type'    => OModel::PK,
				'incr' => false,
				'ref' => 'scenario.id',
				'comment' => 'Id de un escenario'
			],
			'id_to' => [
				'type'    => OModel::PK,
				'incr' => false,
				'ref' => 'scenario.id',
				'comment' => 'Id del escenario con el que conecta'
			],
			'orientation' => [
				'type'    => OModel::TEXT,
				'nullable' => false,
				'default' => null,
				'size' => 5,
				'comment' => 'Sentido de la conexión up / down / left / right'
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

		parent::load($table_name, $model);
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