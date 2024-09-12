<?php declare(strict_types=1);

namespace Osumi\OsumiFramework\App\Service;

use Osumi\OsumiFramework\Core\OService;
use Osumi\OsumiFramework\DB\ODB;
use Osumi\OsumiFramework\App\Model\ScenarioObjectDrop;
use Osumi\OsumiFramework\App\Model\Background;
use Osumi\OsumiFramework\App\Model\ScenarioObject;
use Osumi\OsumiFramework\App\Model\Connection;
use Osumi\OsumiFramework\App\Model\Character;
use Osumi\OsumiFramework\App\Model\Item;
use Osumi\OsumiFramework\App\Model\Equipment;
use Osumi\OsumiFramework\App\Model\Narrative;
use Osumi\OsumiFramework\App\Model\BackgroundCategory;
use Osumi\OsumiFramework\App\Model\Scenario;
use Osumi\OsumiFramework\App\Model\ScenarioData;
use Osumi\OsumiFramework\App\Model\ItemFrame;
use Osumi\OsumiFramework\App\Model\Tag;
use Osumi\OsumiFramework\App\Model\CharacterFrame;
use Osumi\OsumiFramework\App\Model\World;
use Osumi\OsumiFramework\App\Model\ScenarioObjectFrame;
use Osumi\OsumiFramework\App\Model\Asset;
use Osumi\OsumiFramework\App\Model\AssetTag;

class AdminService extends OService {
	/**
	 * Load service tools
	 */
	function __construct() {
		$this->loadService();
	}

	/**
	 * Función para obtener el listado de mundos
	 *
	 * @return array Listado de mundos
	 */
	public function getWorlds(): array {
		$db = new ODB();
		$sql = "SELECT * FROM `world` ORDER BY `name` ASC";
		$db->query($sql);
		$ret = [];

		while ($res=$db->next()) {
			$world = new World();
			$world->update($res);
			array_push($ret, $world);
		}

		return $ret;
	}

	/**
	 * Función para borrar un mundo y todas sus relaciones
	 *
	 * @param World $world Mundo a borrar
	 *
	 * @param World $origin_world Mundo de origen, por si borro un mundo donde ya haya algún usuario
	 *
	 * @return void
	 */
	public function deleteWorld(World $world, World $origin_world): void {
		$db = new ODB();
		$origin_world_initial_scenario = $origin_world->getInitialScenario();
		$origin_world_initial_scenario_id = null;
		if (!is_null($origin_world_initial_scenario)) {
			$origin_world_initial_scenario_id = $origin_world_initial_scenario->get('id');
		}

		foreach ($world->getScenarios() as $scenario) {
			// Todos los que estuviesen en un escenario del mundo a borrar, los mando al escenario inicial
			$sql = "UPDATE `game` SET `id_scenario` = ? WHERE `id_scenario` = ?";
			$db->query($sql, [$origin_world_initial_scenario_id, $scenario->get('id')]);
			// Borro el escenario
			$scenario->deleteFull();
		}

		// Borro todos los mundos desbloqueados
		$sql = "DELETE FROM `world_unlocked` WHERE `id_world` = ?";
		$db->query($sql, [$world->get('id')]);

		// Borro el mundo
		$world->delete();
	}

	/**
	 * Función para obtener el listado de escenarios de un mundo
	 *
	 * @param int $id_world Id del mundo del que obtener los escenarios
	 *
	 * @return array Listado de escenarios
	 */
	public function getScenarios(int $id_world): array {
		$db = new ODB();
		$sql = "SELECT * FROM `scenario` WHERE `id_world` = ?";
		$db->query($sql, [$id_world]);
		$ret = [];

		while ($res = $db->next()) {
			$scenario = new Scenario();
			$scenario->update($res);
			array_push($ret, $scenario);
		}

		return $ret;
	}

	/**
	 * Función para borrar un escenario y todas sus relaciones
	 *
	 * @param Scenario $scenario Escenario a borrar
	 *
	 * @param World $origin_world Mundo de origen, por si borro un escenario donde ya haya algún usuario
	 *
	 * @return void
	 */
	public function deleteScenario(Scenario $scenario, World $origin_world): void {
		$db = new ODB();
		$origin_world_initial_scenario = $origin_world->getInitialScenario();
		$origin_world_initial_scenario_id = null;
		if (!is_null($origin_world_initial_scenario)) {
			$origin_world_initial_scenario_id = $origin_world_initial_scenario->get('id');
		}

		// Todos los que estuviesen en un escenario a borrar, los mando al escenario inicial
		$sql = "UPDATE `game` SET `id_scenario` = ? WHERE `id_scenario` = ?";
		$db->query($sql, [$origin_world_initial_scenario_id, $scenario->get('id')]);

		// Borro el escenario
		$scenario->deleteFull();
	}

	/**
	 * Función para obtener la lista completa de categorías de fondos
	 *
	 * @return array Lista de categorías de fondos
	 */
	public function getBackgroundCategories(): array {
		$db = new ODB();
		$sql = "SELECT * FROM `background_category` ORDER BY `name`";
		$db->query($sql);
		$ret = [];

		while ($res=$db->next()) {
			$background_category = new BackgroundCategory();
			$background_category->update($res);
			array_push($ret, $background_category);
		}

		return $ret;
	}

	/**
	 * Función para obtener la lista completa de fondos
	 *
	 * @return array Lista de fondos
	 */
	public function getBackgrounds(): array {
		$db = new ODB();
		$sql = "SELECT * FROM `background` ORDER BY `name`";
		$db->query($sql);
		$ret = [];

		while ($res=$db->next()) {
			$background = new Background();
			$background->update($res);
			array_push($ret, $background);
		}

		return $ret;
	}

	/**
	 * Función para obtener la lista completa de tags
	 *
	 * @return array Lista de tags
	 */
	public function getTags(): array {
		$db = new ODB();
		$sql = "SELECT * FROM `tag` ORDER BY `name`";
		$db->query($sql);
		$ret = [];

		while ($res=$db->next()) {
			$tag = new Tag();
			$tag->update($res);
			array_push($ret, $tag);
		}

		return $ret;
	}

	/**
	 * Función para obtener la lista completa de recursos
	 *
	 * @return array Lista de recursos
	 */
	public function getAssets(): array {
		$db = new ODB();
		$sql = "SELECT * FROM `asset` ORDER BY `name`";
		$db->query($sql);
		$ret = [];

		while ($res=$db->next()) {
			$asset = new Asset();
			$asset->update($res);
			array_push($ret, $asset);
		}

		return $ret;
	}

	/**
	 * Función para obtener la extensión de un archivo a partir de una cadena de texto en Base64
	 *
	 * @param string $url Archivo en formato Base64
	 *
	 * @return string Extensión del tipo de archivo
	 */
	public function getFileExt(string $url): string {
		$info = explode(';', $url);
		$file_data = explode('/', $info[0]);

		return $file_data[1];
	}

	/**
	 * Función para guardar un archivo pasado como Base64
	 *
	 * @param Asset $asset Recurso al que pertenece la imagen
	 *
	 * @param string $url Archivo en formato Base64
	 *
	 * @return void
	 */
	public function saveAssetImage(Asset $asset, string $url): void {
		$route = $this->getConfig()->getDir('assets').$asset->get('id').'.'.$asset->get('ext');
		$this->getLog()->debug($url);
		OTools::base64ToFile($url, $route);
	}

	/**
	 * Función para actualizar las tags de un asset
	 *
	 * @param Asset $asset Recurso al que actualizar las tags
	 *
	 * @param string $tags Lista de tags separadas por comas
	 *
	 * @return void
	 */
	public function updateAssetTags(Asset $asset, string $tags): void {
		$db = new ODB();
		$tag_list = explode(',', $tags);
		$asset_tag_list = [];

		// Busco o creo las tags introducidas
		foreach ($tag_list as $str_tag) {
			$str_tag = trim($str_tag);
			$tag = new Tag();
			if (!$tag->find(['name'=>$str_tag])) {
				$tag->set('name', $str_tag);
				$tag->save();
			}
			array_push($asset_tag_list, $tag);
		}

		// Borro todas las relaciones entre tags y asset
		$this->cleanAssetTags($asset);

		// Creo las relaciones de las tags actuales
		foreach ($asset_tag_list as $tag) {
			$asset_tag = new AssetTag();
			$asset_tag->set('id_asset', $asset->get('id'));
			$asset_tag->set('id_tag', $tag->get('id'));
			$asset_tag->save();
		}

		// Borro tags que ya no se usan
		$this->cleanUnnusedTags();
	}

	/**
	 * Función para borrar la relación entre un recurso y sus tags
	 *
	 * @return void
	 */
	public function cleanAssetTags(Asset $asset): void {
		$db = new ODB();
		$sql = "DELETE FROM `asset_tag` WHERE `id_asset` = ?";
		$db->query($sql, [$asset->get('id')]);
	}

	/**
	 * Función para borrar tags que ya no se usan
	 *
	 * @return void
	 */
	public function cleanUnnusedTags(): void {
		$db = new ODB();
		$sql = "DELETE FROM `tag` WHERE `id` NOT IN (SELECT DISTINCT(`id_tag`) FROM `asset_tag`)";
		$db->query($sql);
	}

	/**
	 * Función para borrar un asset, antes de borrarlo comprueba si está en uso y no lo borra oara avisar
	 *
	 * @param int $id Id del asset a borrar
	 *
	 * @return array Estado de la operación y mensaje en caso de error
	 */
	public function deleteAsset(int $id): array {
		$ret = ['status' => 'ok', 'message' => ''];
		$asset = new Asset();
		$asset->find(['id' => $id]);

		$db = new ODB();
		$messages = [];

		// Backgrounds
		$sql = "SELECT * FROM `background` WHERE `id_asset` = ?";
		$db->query($sql, [$id]);
		while ($res = $db->next()) {
			$background = new Background();
			$background->update($res);
			array_push($messages, 'Fondo '.$background->get('name').' ('.$background->get('id').')');
		}

		// Character
		$sql = "SELECT * FROM `character` WHERE `id_asset_up` = ? OR `id_asset_down` = ? OR `id_asset_left` = ? OR `id_asset_right` = ?";
		$db->query($sql, [$id, $id, $id, $id]);
		while ($res = $db->next()) {
			$character = new Character();
			$character->update($res);
			array_push($messages, 'Personaje '.$character->get('name').' ('.$character->get('id').')');
		}

		// Character frame
		$sql = "SELECT * FROM `character_frame` WHERE `id_asset` = ?";
		$db->query($sql, [$id]);
		while ($res = $db->next()) {
			$character_frame = new CharacterFrame();
			$character_frame->update($res);
			$character = $character_frame->getCharacter();
			array_push($messages, 'Personaje '.$character->get('name').' ('.$character->get('id').') - Frame '.$character_frame->get('id'));
		}

		// Item
		$sql = "SELECT * FROM `item` WHERE `id_asset` = ?";
		$db->query($sql, [$id]);
		while ($res = $db->next()) {
			$item = new Item();
			$item->update($res);
			array_push($messages, 'Item '.$item->get('name').' ('.$item->get('id').')');
		}

		// Scenario object
		$sql = "SELECT * FROM `scenario_object` WHERE `id_asset` = ? OR `id_asset_active` = ?";
		$db->query($sql, [$id, $id]);
		while ($res = $db->next()) {
			$scenario_object = new ScenarioObject();
			$scenario_object->update($res);
			array_push($messages, 'Objeto de escenario '.$scenario_object->get('name').' ('.$scenario_object->get('id').')');
		}

		// Scenario object frame
		$sql = "SELECT * FROM `scenario_object_frame` WHERE `id_asset` = ?";
		$db->query($sql, [$id]);
		while ($res = $db->next()) {
			$scenario_object_frame = new ScenarioObjectFrame();
			$scenario_object_frame->update($res);
			$scenario_object = $scenario_object_frame->getScenarioObject();
			array_push($messages, 'Objeto de escenario '.$scenario_object->get('name').' ('.$scenario_object->get('id').') - Frame '.$scenario_object_frame->get('id'));
		}

		if (count($messages)>0) {
			$ret['status'] = 'in-use';
			$ret['messages'] = implode(', ', $messages);
		}
		else {
			$this->cleanAssetTags($asset);
			$this->cleanUnnusedTags();
			$asset->deleteFull();
		}

		return $ret;
	}

	/**
	 * Función que comprueba si una categoría de fondo está en uso y sino la borra
	 *
	 * @param BackgroundCategory $background_category Categoría de fondo a borrar
	 *
	 * @return array Estado de la operación y mensaje en caso de error
	 */
	public function deleteBackgroundCategory(BackgroundCategory $background_category): array {
		$ret = ['status' => 'ok', 'message' => ''];
		$messages = [];

		$background_list = $background_category->getBackgrounds();
		if (count($background_list)>0) {
			$ret['status'] = 'in-use';
			foreach ($background_list as $background) {
				array_push($messages, 'Fondo '.$background->get('name').' ('.$background->get('id').')');
			}
			$ret['messages'] = implode(', ', $messages);
		}
		else {
			$background_category->delete();
		}

		return $ret;
	}

	/**
	 * Función que comprueba si un fondo está en uso y sino lo borra
	 *
	 * @param Background $background Fondo a borrar
	 *
	 * @return array Estado de la operación y mensaje en caso de error
	 */
	public function deleteBackground(Background $background): array {
		$ret = ['status' => 'ok', 'message' => ''];
		$messages = [];
		$db = new ODB();
		$sql = "SELECT * FROM `scenario_data` WHERE `id_background` = ?";
		$db->query($sql, [$background->get('id')]);

		while ($res = $db->next()) {
			$scenario_data = new ScenarioData();
			$scenario_data->update($res);
			array_push($messages, 'Escenario '.$scenario_data->getScenario()->get('name').' ('.$scenario_data->getScenario()->get('id').')');
		}

		if (count($messages)>0) {
			$ret['status'] = 'in-use';
			$ret['messages'] = implode(', ', $messages);
		}
		else {
			$background->delete();
		}

		return $ret;
	}

	/**
	 * Función para obtener la lista completa de items
	 *
	 * @return array Lista de items
	 */
	public function getItems(): array {
		$db = new ODB();
		$sql = "SELECT * FROM `item` ORDER BY `name`";
		$db->query($sql);
		$ret = [];

		while ($res=$db->next()) {
			$item = new Item();
			$item->update($res);
			array_push($ret, $item);
		}

		return $ret;
	}

	/**
	 * Función para actualizar la lista de frames de un item
	 *
	 * @param Item $item Item al que actualizar la lista de frames
	 *
	 * @param array $frames Lista de frames
	 *
	 * @return void
	 */
	public function updateItemFrames(Item $item, array $frames): void {
		$updated_list = [];
		foreach ($frames as $frame) {
			$item_frame = new ItemFrame();
			if (!is_null($frame['id'])) {
				$item_frame->find(['id' => $frame['id']]);
			}
			$item_frame->set('id_item', $item->get('id'));
			$item_frame->set('id_asset', $frame['idAsset']);
			$item_frame->set('order', $frame['order']);
			$item_frame->save();

			array_push($updated_list, $item_frame->get('id'));
		}

		$frame_list = $item->getFrames();
		foreach ($frame_list as $item_frame) {
			if (!in_array($item_frame->get('id'), $updated_list)) {
				$item_frame->delete();
			}
		}
	}

	/**
	 * Función para borrar un item, antes de borrarlo comprueba si está en uso y no lo borra oara avisar
	 *
	 * @param int $id Id del item a borrar
	 *
	 * @return array Estado de la operación y mensaje en caso de error
	 */
	public function deleteItem(int $id): array {
		$ret = ['status' => 'ok', 'message' => ''];
		$item = new Item();
		$item->find(['id' => $id]);

		$db = new ODB();
		$messages = [];

		// Inventory
		$sql = "SELECT * FROM `inventory` WHERE `id_item` = ?";
		$db->query($sql, [$id]);
		while ($res = $db->next()) {
			$inventory = new Inventory();
			$inventory->update($res);
			array_push($messages, 'Inventario '.$inventory->get('id'));
		}

		// Character
		$sql = "SELECT * FROM `character` WHERE `drop_id_item` = ?";
		$db->query($sql, [$id]);
		while ($res = $db->next()) {
			$character = new Character();
			$character->update($res);
			array_push($messages, 'Personaje '.$character->get('name').' lo suelta');
		}

		// Scenario object drop
		$sql = "SELECT * FROM `scenario_object_drop` WHERE `id_item` = ?";
		$db->query($sql, [$id]);
		while ($res = $db->next()) {
			$scenario_object_drop = new ScenarioObjectDrop();
			$scenario_object_drop->update($res);
			array_push($messages, 'Objeto de escenario '.$scenario_object_drop->getScenarioObject()->get('name').' lo suelta');
		}

		// Equipment
		$sql = "SELECT * FROM `equipment` WHERE `head` = ? OR `necklace` = ? OR `body` = ? OR `boots` = ? OR `weapon` = ?";
		$db->query($sql, [$id, $id, $id, $id, $id]);
		while ($res = $db->next()) {
			$equipment = new Equipment();
			$equipment->update($res);
			array_push($messages, 'Partida '.$equipment->get('id'));
		}

		if (count($messages)>0) {
			$ret['status'] = 'in-use';
			$ret['messages'] = implode(', ', $messages);
		}
		else {
			$item->delete();
		}

		return $ret;
	}

	/**
	 * Función para obtener el listado de personajes
	 *
	 * @return array Listado de Personajes
	 */
	public function getCharacters(): array {
		$db = new ODB();
		$sql = "SELECT * FROM `character` ORDER BY `name`";
		$db->query($sql);
		$ret = [];

		while ($res = $db->next()) {
			$character = new Character();
			$character->update($res);
			array_push($ret, $character);
		}

		return $ret;
	}

	/**
	 * Función para actualizar la lista de frames de un personaje
	 *
	 * @param Character $character Personaje al que actualizar la lista de frames
	 *
	 * @param array $frames Lista de frames
	 *
	 * @param string $sent Orientación de los frames
	 *
	 * @return void
	 */
	public function updateCharacterFrames(Character $character, array $frames, string $sent): void {
		$updated_list = [];
		foreach ($frames as $frame) {
			$character_frame = new CharacterFrame();
			if (!is_null($frame['id'])) {
				$character_frame->find(['id' => $frame['id']]);
			}
			$character_frame->set('id_character', $character->get('id'));
			$character_frame->set('id_asset', $frame['idAsset']);
			$character_frame->set('orientation', $sent);
			$character_frame->set('order', $frame['order']);
			$character_frame->save();

			array_push($updated_list, $character_frame->get('id'));
		}

		$frame_list = $character->getFrames($sent);
		foreach ($frame_list as $character_frame) {
			if (!in_array($character_frame->get('id'), $updated_list)) {
				$character_frame->delete();
			}
		}
	}

	/**
	 * Función para actualizar las narrativas de un personaje
	 */
	public function updateCharacterNarratives(Character $character, array $narratives): void {
		$updated_list = [];
		foreach ($narratives as $narrative) {
			$character_narrative = new Narrative();
			if (!is_null($narrative['id'])) {
				$character_narrative->find(['id' => $narrative['id']]);
			}
			$character_narrative->set('id_character', $character->get('id'));
			$character_narrative->set('dialog', $narrative['dialog']);
			$character_narrative->set('order', $narrative['order']);
			$character_narrative->save();

			array_push($updated_list, $character_narrative->get('id'));
		}

		$narrative_list = $character->getNarratives();
		foreach ($narrative_list as $character_narrative) {
			if (!in_array($character_narrative->get('id'), $updated_list)) {
				$character_narrative->delete();
			}
		}
	}

	/**
	 * Función para borrar un personaje, antes de borrarlo comprueba si está en uso y no lo borra oara avisar
	 *
	 * @param int $id Id del personaje a borrar
	 *
	 * @return array Estado de la operación y mensaje en caso de error
	 */
	public function deleteCharacter(int $id): array {
		$ret = ['status' => 'ok', 'message' => ''];
		$character = new Character();
		$character->find(['id' => $id]);

		$db = new ODB();
		$messages = [];

		// Scenario Data
		$sql = "SELECT * FROM `scenario_data` WHERE `id_character` = ?";
		$db->query($sql, [$id]);
		while ($res = $db->next()) {
			$scenario_data = new ScenarioData();
			$scenario_data->update($res);
			array_push($messages, 'Escenario '.$scenario_data->getScenario()->get('name'));
		}

		if (count($messages)>0) {
			$ret['status'] = 'in-use';
			$ret['messages'] = implode(', ', $messages);
		}
		else {
			$character->delete();
		}

		return $ret;
	}

	/**
	 * Función para obtener el listado de objetos de escenario
	 *
	 * @return array Listado de Objetos de escenario
	 */
	public function getScenarioObjects(): array {
		$db = new ODB();
		$sql = "SELECT * FROM `scenario_object` ORDER BY `name`";
		$db->query($sql);
		$ret = [];

		while ($res = $db->next()) {
			$scenario_object = new ScenarioObject();
			$scenario_object->update($res);
			array_push($ret, $scenario_object);
		}

		return $ret;
	}

	/**
	 * Función para actualizar la lista de frames de un objeto de escenario
	 *
	 * @param ScenarioObject $scenario_object Objeto de escenario al que actualizar la lista de frames
	 *
	 * @param array $frames Lista de frames
	 *
	 * @return void
	 */
	public function updateScenarioObjectFrames(ScenarioObject $scenario_object, array $frames): void {
		$updated_list = [];
		foreach ($frames as $frame) {
			$scenario_object_frame = new ScenarioObjectFrame();
			if (!is_null($frame['id'])) {
				$scenario_object_frame->find(['id' => $frame['id']]);
			}
			$scenario_object_frame->set('id_scenario_object', $scenario_object->get('id'));
			$scenario_object_frame->set('id_asset', $frame['idAsset']);
			$scenario_object_frame->set('order', $frame['order']);
			$scenario_object_frame->save();

			array_push($updated_list, $scenario_object_frame->get('id'));
		}

		$frame_list = $scenario_object->getFrames();
		foreach ($frame_list as $scenario_object_frame) {
			if (!in_array($scenario_object_frame->get('id'), $updated_list)) {
				$scenario_object_frame->delete();
			}
		}
	}

	/**
	 * Función para actualizar la lista de drops de un objeto de escenario
	 *
	 * @param ScenarioObject $scenario_object Objeto de escenario al que actualizar la lista de drops
	 *
	 * @param array $drops Lista de drops
	 *
	 * @return void
	 */
	public function updateScenarioObjectDrops(ScenarioObject $scenario_object, array $drops): void {
		$updated_list = [];
		foreach ($drops as $drop) {
			$scenario_object_drop = new ScenarioObjectDrop();
			if (!is_null($drop['id'])) {
				$scenario_object_drop->find(['id' => $drop['id']]);
			}
			$scenario_object_drop->set('id_scenario_object', $scenario_object->get('id'));
			$scenario_object_drop->set('id_item', $drop['idItem']);
			$scenario_object_drop->set('num', $drop['num']);
			$scenario_object_drop->save();

			array_push($updated_list, $scenario_object_drop->get('id'));
		}

		$drop_list = $scenario_object->getDrops();
		foreach ($drop_list as $scenario_object_drop) {
			if (!in_array($scenario_object_drop->get('id'), $updated_list)) {
				$scenario_object_drop->delete();
			}
		}
	}

	/**
	 * Función para borrar un objeto de escenario, antes de borrarlo comprueba si está en uso y no lo borra oara avisar
	 *
	 * @param int $id Id del objeto de escenario a borrar
	 *
	 * @return array Estado de la operación y mensaje en caso de error
	 */
	public function deleteScenarioObject(int $id): array {
		$ret = ['status' => 'ok', 'message' => ''];
		$scenario_object = new ScenarioObject();
		$scenario_object->find(['id' => $id]);

		$db = new ODB();
		$messages = [];

		// Scenario Data
		$sql = "SELECT * FROM `scenario_data` WHERE `id_scenario_object` = ?";
		$db->query($sql, [$id]);
		while ($res = $db->next()) {
			$scenario_data = new ScenarioData();
			$scenario_data->update($res);
			array_push($messages, 'Escenario '.$scenario_data->getScenario()->get('name'));
		}

		if (count($messages)>0) {
			$ret['status'] = 'in-use';
			$ret['messages'] = implode(', ', $messages);
		}
		else {
			$character->delete();
		}

		return $ret;
	}

	/**
	 * Crea o actualiza una conexión de un escenario a otro
	 *
	 * @param int $id_from Desde qué escenario se conecta
	 *
	 * @param int $id_to Escenario al que conecta
	 *
	 * @param string $orientation Desde qué lado del escenario se conecta
	 */
	public function updateConnection(int $id_from, int $id_to, string $orientation): void {
		$this->deleteConnection($id_from, $id_to, $orientation);

		$connection = new Connection();
		$connection->set('id_from', $id_from);
		$connection->set('id_to', $id_to);
		$connection->set('orientation', $orientation);
		$connection->save();
	}

	/**
	 * Borra una conexión de un escenario a otro
	 *
	 * @param int $id_from Desde qué escenario se conecta
	 *
	 * @param int $id_to Escenario al que conecta
	 *
	 * @param string $orientation Desde qué lado del escenario se conecta
	 */
	public function deleteConnection(int $id_from, int $id_to, string $orientation): void {
		$db = new ODB();
		$sql = "DELETE FROM `connection` WHERE `id_from` = ? AND `id_to` = ? AND `orientation` = ?";
		$db->query($sql, [$id_from, $id_to, $orientation]);
	}

	/**
	 * Función que comprueba si un mundo ya tiene un escenario inicial
	 *
	 * @param Scenario $scenario Escenario en el que se está intentando poner un punto de inicio
	 *
	 * @return array Estado de la operación y escenario inicial del mundo en caso de ya existir
	 */
	public function checkWorldStart(Scenario $scenario): array {
		$ret = ['status' => 'ok', 'message' => ''];
		$db = new ODB();
		$sql = "SELECT * FROM `scenario` WHERE `id_world` = ? AND `id` != ? AND `initial` = 1";
		$db->query($sql, [$scenario->get('id_world'), $scenario->get('id')]);

		if ($res = $db->next()) {
			$scenario_check = new Scenario();
			$scenario_check->update($res);

			$ret['status'] = 'in-use';
			$ret['message'] = $scenario_check->get('name');
		}

		return $ret;
	}

	/**
	 * Función para borrar el punto inicial de un mundo
	 *
	 * @param Scenario $scenario Escenario en el que se está intentando poner un punto de inicio
	 *
	 * @return void
	 */
	public function clearWorldStart(Scenario $scenario): void {
		$db = new ODB();
		$sql = "UPDATE `scenario` SET `initial` = 0, `start_x` = NULL, `start_y` = NULL WHERE `id_world` = ?";
		$db->query($sql, [$scenario->get('id_world')]);
	}
}
