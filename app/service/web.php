<?php declare(strict_types=1);
class webService extends OService {
	/**
	 * Load service tools
	 */
	function __construct() {
		$this->loadService();
	}

	/**
	 * Función para obtener un mundo a partir de sus tres palabras
	 *
	 * @param string $word_one Primera palabra del mundo
	 *
	 * @param string $word_two Segunda palabra del mundo
	 *
	 * @param string $word_three Tercera palabra del mundo
	 *
	 * @return World Mundo cuyas tres palabras coincidan, si lo hay
	 */
	public function getWorldByWords($word_one, $word_two, $word_three): ?World {
		$db = new ODB();
		$sql = "SELECT * FROM `world` WHERE `word_one` = ? AND `word_two` = ? AND `word_three` = ?";
		$db->query($sql, [$word_one, $word_two, $word_three]);

		if ($res = $db->next()) {
			$world = new World();
			$world->update($res);

			return $world;
		}

		return null;
	}
}