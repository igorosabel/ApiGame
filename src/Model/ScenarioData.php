<?php declare(strict_types=1);

namespace Osumi\OsumiFramework\App\Model;

use Osumi\OsumiFramework\ORM\OModel;
use Osumi\OsumiFramework\ORM\OPK;
use Osumi\OsumiFramework\ORM\OField;
use Osumi\OsumiFramework\ORM\OCreatedAt;
use Osumi\OsumiFramework\ORM\OUpdatedAt;
use Osumi\OsumiFramework\App\Model\Background;
use Osumi\OsumiFramework\App\Model\ScenarioObject;
use Osumi\OsumiFramework\App\Model\Character;
use Osumi\OsumiFramework\App\Model\Scenario;

class ScenarioData extends OModel {
	#[OPK(
	  comment: 'Id único para cada dato'
	)]
	public ?int $id;

	#[OField(
	  comment: 'Id del escenario al que pertenece el dato',
	  nullable: false,
	  ref: 'scenario.id',
	  default: null
	)]
	public ?int $id_scenario;

	#[OField(
	  comment: 'Coordenada X del dato en el escenario',
	  nullable: false,
	  default: null
	)]
	public ?int $x;

	#[OField(
	  comment: 'Coordenada Y del dato en el escenario',
	  nullable: false,
	  default: null
	)]
	public ?int $y;

	#[OField(
	  comment: 'Id del fondo del escenario',
	  nullable: false,
	  ref: 'background.id',
	  default: null
	)]
	public ?int $id_background;

	#[OField(
	  comment: 'Id del objeto relacionado que va en el escenario',
	  nullable: true,
	  ref: 'scenario_object.id',
	  default: null
	)]
	public ?int $id_scenario_object;

	#[OField(
	  comment: 'Id del personaje que va en el escenario',
	  nullable: true,
	  ref: 'character.id',
	  default: null
	)]
	public ?int $id_character;

	#[OField(
	  comment: 'Salud del personaje',
	  nullable: true,
	  default: null
	)]
	public ?int $character_health;

	#[OCreatedAt(
	  comment: 'Fecha de creación del registro'
	)]
	public ?string $created_at;

	#[OUpdatedAt(
	  comment: 'Fecha de última modificación del registro'
	)]
	public ?string $updated_at;

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
		$scenario = Scenario::findOne(['id' => $this->id_scenario]);
		$this->setScenario($scenario);
	}

	private ?Background $background = null;

	/**
	 * Obtiene el fondo de la casilla, si lo tiene
	 *
	 * @return Background Elemento de fondo de la casilla
	 */
	public function getBackground(): ?Background {
		if (is_null($this->background) && !is_null($this->id_background)) {
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
		$background = Background::findOne(['id' => $this->id_background]);
		$this->setBackground($background);
	}

	private ?ScenarioObject $scenario_object = null;

	/**
	 * Obtiene el objeto de la casilla, si lo tiene
	 *
	 * @return ScenarioObject Objeto de la casilla
	 */
	public function getScenarioObject(): ?ScenarioObject {
		if (is_null($this->scenario_object) && !is_null($this->id_scenario_object)) {
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
		$scenario_object = ScenarioObject::findOne(['id' => $this->id_scenario_object]);
		$this->setScenarioObject($scenario_object);
	}

	private ?Character $character = null;

	/**
	 * Obtiene el personaje de la casilla, si lo tiene
	 *
	 * @return Character Personaje de la casilla
	 */
	public function getCharacter(): ?Character {
		if (is_null($this->character) && !is_null($this->id_character)) {
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
		$character = Character::findOne(['id' => $this->id_character]);
		$this->setCharacter($character);
	}
}
