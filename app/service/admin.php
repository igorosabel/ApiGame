<?php declare(strict_types=1);
class adminService extends OService {
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
			$ret['status'] = 'in_use';
			$ret['messages'] = implode(', ', $messages);
		}
		else {
			$this->cleanAssetTags($asset);
			$this->cleanUnnusedTags();
			$asset->deleteFull();
		}

		return $ret;
	}
}