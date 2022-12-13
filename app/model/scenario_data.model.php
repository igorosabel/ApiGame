<?php declare(strict_types=1);

namespace OsumiFramework\App\Model;

use OsumiFramework\OFW\DB\OModel;
use OsumiFramework\OFW\DB\OModelGroup;
use OsumiFramework\OFW\DB\OModelField;
use OsumiFramework\App\Model\Background;
use OsumiFramework\App\Model\ScenarioObject;
use OsumiFramework\App\Model\Character;
use OsumiFramework\App\Model\Scenario;

class ScenarioData extends OModel {
	function __construct() {
		$model = new OModelGroup(
			new OModelField(
				name: 'id',
				type: OMODEL_PK,
				comment: 'Id único para cada dato'
			),
			new OModelField(
				name: 'id_scenario',
				type: OMODEL_NUM,
				nullable: false,
				default: null,
				ref: 'scenario.id',
				comment: 'Id del escenario al que pertenece el dato'
			),
			new OModelField(
				name: 'x',
				type: OMODEL_NUM,
				nullable: false,
				default: null,
				comment: 'Coordenada X del dato en el escenario'
			),
			new OModelField(
				name: 'y',
				type: OMODEL_NUM,
				nullable: false,
				default: null,
				comment: 'Coordenada Y del dato en el escenario'
			),
			new OModelField(
				name: 'id_background',
				type: OMODEL_NUM,
				nullable: false,
				default: null,
				ref: 'background.id',
				comment: 'Id del fondo del escenario'
			),
			new OModelField(
				name: 'id_scenario_object',
				type: OMODEL_NUM,
				nullable: true,
				default: null,
				ref: 'scenario_object.id',
				comment: 'Id del objeto relacionado que va en el escenario'
			),
			new OModelField(
				name: 'id_character',
				type: OMODEL_NUM,
				nullable: true,
				default: null,
				ref: 'character.id',
				comment: 'Id del personaje que va en el escenario'
			),
			new OModelField(
				name: 'character_health',
				type: OMODEL_NUM,
				nullable: true,
				default: null,
				comment: 'Salud del personaje'
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

	private ?Scenario $scenario = null;

	/**
	 * Obtiene el escenario al que pertenecen los datos
	 *
	 * @return Scenario Escenario al que pertenecen los datos
	 */
	public function getScenario(): Scenario {
		if (is_null($this->scenario)) {
			$this->loadScenario();
		}
		return $this->scenario;
	}

	/**
	 * Guarda el escenario al que pertenecen los datos
	 *
	 * @param Scenario $scenario Escenario al que pertenecen los datos
	 *
	 * @return void
	 */
	public function setScenario(Scenario $scenario): void {
		$this->scenario = $scenario;
	}

	/**
	 * Carga el escenario al que pertenecen los datos
	 *
	 * @return void
	 */
	public function loadScenario(): void {
		$scenario = new Scenario();
		$scenario->find(['id' => $this->get('id_scenario')]);
		$this->setScenario($scenario);
	}

	private ?Background $background = null;

	/**
	 * Obtiene el fondo de la casilla, si lo tiene
	 *
	 * @return Background Elemento de fondo de la casilla
	 */
	public function getBackground(): ?Background {
		if (is_null($this->background) && !is_null($this->get('id_background'))) {
			$this->loadBackground();
		}
		return $this->background;
	}

	/**
	 * Guarda el elemento de fondo de la casilla
	 *
	 * @param Background $background Elemento de fondo de la casilla
	 *
	 * @return void
	 */
	public function setBackground(Background $background): void {
		$this->background = $background;
	}

	/**
	 * Carga el elemento de fondo de la casilla
	 *
	 * @return void
	 */
	public function loadBackground(): void {
		$background = new Background();
		$background->find(['id' => $this->get('id_background')]);
		$this->setBackground($background);
	}

	private ?ScenarioObject $scenario_object = null;

	/**
	 * Obtiene el objeto de la casilla, si lo tiene
	 *
	 * @return ScenarioObject Objeto de la casilla
	 */
	public function getScenarioObject(): ?ScenarioObject {
		if (is_null($this->scenario_object) && !is_null($this->get('id_scenario_object'))) {
			$this->loadScenarioObject();
		}
		return $this->scenario_object;
	}

	/**
	 * Guarda el objeto de la casilla
	 *
	 * @param ScenarioObject $scenario_object Objeto de la casilla
	 *
	 * @return void
	 */
	public function setScenarioObject(ScenarioObject $scenario_object): void {
		$this->scenario_object = $scenario_object;
	}

	/**
	 * Carga el objeto de la casilla
	 *
	 * @return void
	 */
	public function loadScenarioObject(): void {
		$scenario_object = new ScenarioObject();
		$scenario_object->find(['id' => $this->get('id_scenario_object')]);
		$this->setScenarioObject($scenario_object);
	}

	private ?Character $character = null;

	/**
	 * Obtiene el personaje de la casilla, si lo tiene
	 *
	 * @return Character Personaje de la casilla
	 */
	public function getCharacter(): ?Character {
		if (is_null($this->character) && !is_null($this->get('id_character'))) {
			$this->loadCharacter();
		}
		return $this->character;
	}

	/**
	 * Guarda el personaje de la casilla
	 *
	 * @param Character $character Personaje de la casilla
	 *
	 * @return void
	 */
	public function setCharacter(Character $character): void {
		$this->character = $character;
	}

	/**
	 * Carga el personaje de la casilla
	 *
	 * @return void
	 */
	public function loadCharacter(): void {
		$character = new Character();
		$character->find(['id' => $this->get('id_character')]);
		$this->setCharacter($character);
	}
}
