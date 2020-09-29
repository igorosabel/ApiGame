<?php declare(strict_types=1);
class adminService extends OService {
	/**
	 * Load service tools
	 */
	function __construct() {
		$this->loadService();
	}

	/**
	 * Obtiene la lista de escenarios ordenados por nombre
	 *
	 * @return array Lista de escenarios
	 */
	public function getScenarios(): array {
		$ret = [];
		$db = new ODB();
		$sql = "SELECT * FROM `scenario` ORDER BY `name` ASC";
		$db->query($sql);

		while ($res=$db->next()) {
			$sce = new Scenario();
			$sce->update($res);

			array_push($ret, $sce);
		}

		return $ret;
	}

	/**
	 * Obtiene la lista de usuarios ordenados por email
	 *
	 * @return array Lista de usuarios
	 */
	public function getUsers(): array {
		$ret = [];
		$db = new ODB();
		$sql = "SELECT * FROM `user` ORDER BY `email` ASC";
		$db->query($sql);

		while ($res=$db->next()){
			$usr = new User();
			$usr->update($res);
			$usr->loadGames();

			array_push($ret, $usr);
		}

		return $ret;
	}
}