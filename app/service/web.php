<?php declare(strict_types=1);

namespace OsumiFramework\App\Service;

use OsumiFramework\OFW\Core\OService;
use OsumiFramework\OFW\DB\ODB;
use OsumiFramework\App\Model\Game;
use OsumiFramework\App\Model\World;

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
	public function getUnlockedWorlds(int $id_game): array {
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

	/**
	 * Borra una partida y todos sus datos asociados
	 *
	 * @param Game $game Partida a borrar
	 *
	 * @return void
	 */
	public function deleteGame(Game $game): void {
		$db = new ODB();
		$sql = "DELETE FROM `inventory_item` WHERE `id_game` = ?";
		$db->query($sql, [$game->get('id')]);
		$sql = "DELETE FROM `equipment` WHERE `id_game` = ?";
		$db->query($sql, [$game->get('id')]);
		$sql = "DELETE FROM `world_unlocked` WHERE `id_game` = ?";
		$db->query($sql, [$game->get('id')]);

		$game->set('name',        null);
		$game->set('id_scenario', null);
		$game->set('position_x',  null);
		$game->set('position_y',  null);
		$game->set('orientation', null);
		$game->set('money',       null);
		$game->set('health',      $this->getConfig()->getExtra('start_health'));
		$game->set('max_health',  null);
		$game->set('attack',      null);
		$game->set('defense',     null);
		$game->set('speed',       null);
		$game->save();

		$this->updateGameStats($game);
	}

	/**
	 * Función para actualizar las estadísticas de una partida
	 *
	 * @param Game $game Partida a actualizar
	 *
	 * @return void
	 */
	public function updateGameStats(Game $game): void {
		$max_health = $this->getConfig()->getExtra('start_health');
		$attack     = $this->getConfig()->getExtra('start_attack');
		$defense    = $this->getConfig()->getExtra('start_defense');
		$speed      = $this->getConfig()->getExtra('start_speed');

		$equipment = $game->getEquipment();
		$items     = $equipment->getAllItems();
		foreach ($items as $item) {
			$max_health += (!is_null($item->get('health'))  ? $item->get('health')  : 0);
			$attack     += (!is_null($item->get('attack'))  ? $item->get('attack')  : 0);
			$defense    += (!is_null($item->get('defense')) ? $item->get('defense') : 0);
			$speed      += (!is_null($item->get('speed'))   ? $item->get('speed')   : 0);
		}
		
		$game->set('max_health',  $max_health);
		$game->set('attack',      $attack);
		$game->set('defense',     $defense);
		$game->set('speed',       $speed);
		$game->save();
	}
}