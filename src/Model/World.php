<?php declare(strict_types=1);

namespace Osumi\OsumiFramework\App\Model;

use Osumi\OsumiFramework\ORM\OModel;
use Osumi\OsumiFramework\ORM\OPK;
use Osumi\OsumiFramework\ORM\OField;
use Osumi\OsumiFramework\ORM\OCreatedAt;
use Osumi\OsumiFramework\ORM\OUpdatedAt;
use Osumi\OsumiFramework\App\Model\Scenario;

class World extends OModel {
	#[OPK(
	  comment: 'Id único para cada mundo'
	)]
	public ?int $id;

	#[OField(
	  comment: 'Nombre del mundo',
	  nullable: false,
	  max: 50,
	  default: null
	)]
	public ?string $name;

	#[OField(
	  comment: 'Descripción del mundo',
	  nullable: true,
	  default: null,
	  type: OField::LONGTEXT
	)]
	public ?string $description;

	#[OField(
	  comment: 'Primera palabra para acceder al mundo',
	  nullable: false,
	  max: 20,
	  default: null
	)]
	public ?string $word_one;

	#[OField(
	  comment: 'Segunda palabra para acceder al mundo',
	  nullable: false,
	  max: 20,
	  default: null
	)]
	public ?string $word_two;

	#[OField(
	  comment: 'Tercera palabra para acceder al mundo',
	  nullable: false,
	  max: 20,
	  default: null
	)]
	public ?string $word_three;

	#[OField(
	  comment: 'Indica si el mundo es amistoso',
	  nullable: false,
	  default: false
	)]
	public ?bool $friendly;

	#[OCreatedAt(
	  comment: 'Fecha de creación del registro'
	)]
	public ?string $created_at;

	#[OUpdatedAt(
	  comment: 'Fecha de última modificación del registro'
	)]
	public ?string $updated_at;

	private ?array $scenarios = null;

	/**
	 * Función para obtener los escenarios de un mundo
	 *
	 * @return array Lista de escenarios del mundo
	 */
	public function getScenarios(): array {
		if (is_null($this->scenarios)) {
			$this->loadScenarios();
		}
		return $this->scenarios;
	}

	/**
	 * Función para guardar los escenarios de un mundo
	 *
	 * @param array $scenarios Lista de escenarios
	 *
	 * @return void
	 */
	public function setScenarios(array $scenarios): void {
		$this->scenarios = $scenarios;
	}

	/**
	 * Función para cargar los escenarios de un mundo
	 *
	 * @return void
	 */
	public function loadScenarios(): void {
		$list = Scenario::where(['id_world' => $this->id]);
		$this->setScenarios($list);
	}

	private ?Scenario $initial_scenario = null;

	/**
	 * Función para obtener el escenario inicial del mundo
	 *
	 * @return Scenario Escenario inicial del mundo
	 */
	public function getInitialScenario(): ?Scenario {
		if (is_null($this->initial_scenario)) {
			$this->loadInitialScenario();
		}
		return $this->initial_scenario;
	}

	/**
	 * Función para guardar el escenario inicial del mundo
	 *
	 * @param Scenario Escenario inicial
	 *
	 * @return void
	 */
	public function setInitialScenario(Scenario $scenario): void {
		$this->initial_scenario = $scenario;
	}

	/**
	 * Función para cargar el escenario inicial del mundo
	 *
	 * @return void
	 */
	public function loadInitialScenario(): void {
		$scenario = Scenario::findOne(['id_world' => $this->id, 'initial' => 1]);
		$this->setInitialScenario($scenario);
	}
}
