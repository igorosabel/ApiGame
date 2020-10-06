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
}