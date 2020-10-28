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

	/**
	 * Obtiene el mundo origen
	 *
	 * @return World Mundo origen
	 */
	public function getOriginWorld(): World {
		return $this->getWorldByWords(
			$this->getConfig()->getExtra('origin_word_one'),
			$this->getConfig()->getExtra('origin_word_two'),
			$this->getConfig()->getExtra('origin_word_three')
		);
	}

	/**
	 * Función para obtener la lista de partidas de un jugador
	 *
	 * @param int $id_user Id del jugador
	 *
	 * @return array Lista de partidas
	 */
	public function getGames(int $id_user): array {
		$db = new ODB();
		$sql = "SELECT * FROM `game` WHERE `id_user` = ?";
		$db->query($sql, [$id_user]);
		$games = [];

		while ($res = $db->next()) {
			$game = new Game();
			$game->update($res);
			array_push($games, $game);
		}

		return $games;
	}

	/**
	 * Función para obtener la lista de mundos que un jugador ha desbloqueado en una partida
	 *
	 * @param int $id_game Id de la partida
	 *
	 * @return array Lista de mundos
	 */
	public function getUnlockedWorlds($id_game): array {
		$db = new ODB();
		$sql = "SELECT w.* FROM `world` w, `world_unlocked` wu, `game` g WHERE w.`id` = wu.`id_world` AND wu.`id_game` = g.`id` AND g.`id` = ?";
		$db->query($sql, [$id_game]);
		$worlds = [];

		while ($res = $db->next()) {
			$world = new World();
			$world->update($res);
			array_push($worlds, $world);
		}

		return $worlds;
	}
}