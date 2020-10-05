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
}