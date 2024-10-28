<?php declare(strict_types=1);

namespace Osumi\OsumiFramework\App\Service;

use Osumi\OsumiFramework\Core\OService;
use Osumi\OsumiFramework\ORM\ODB;
use Osumi\OsumiFramework\App\Model\Game;
use Osumi\OsumiFramework\App\Model\World;
use Osumi\OsumiFramework\App\Model\User;

class WebService extends OService {
	/**
	 * Función para iniciar sesión en el juego
	 *
	 * @param string $email Email del usuario
	 *
	 * @param string $pass Contraseña del usuario
	 *
	 * @return ?User Devuelve el usuario si los datos son correctos o null en caso contrario
	 */
	public function userLogin(string $email, string $pass): ?User {
		$user = User::findOne(['email' => $email]);
		if (!is_null($user) && password_verify($pass, $user->pass)) {
				return $user;
		}
		return null;
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
		return World::findOne(['word_one' => $word_one, 'word_two' => $word_two, 'word_three' => $word_three]);
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
		return Game::where(['id_user' => $id_user]);
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
			$world = World::from($res);
			$worlds[] = $world;
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
		$db->query($sql, [$game->id]);
		$sql = "DELETE FROM `equipment` WHERE `id_game` = ?";
		$db->query($sql, [$game->id]);
		$sql = "DELETE FROM `world_unlocked` WHERE `id_game` = ?";
		$db->query($sql, [$game->id]);

		$game->name        = null;
		$game->id_scenario = null;
		$game->position_x  = null;
		$game->position_y  = null;
		$game->orientation = null;
		$game->money       = null;
		$game->health      = $this->getConfig()->getExtra('start_health');
		$game->max_health  = null;
		$game->attack      = null;
		$game->defense     = null;
		$game->speed       = null;
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
			$max_health += (!is_null($item->health)  ? $item->health  : 0);
			$attack     += (!is_null($item->attack)  ? $item->attack  : 0);
			$defense    += (!is_null($item->defense) ? $item->defense : 0);
			$speed      += (!is_null($item->speed)   ? $item->speed   : 0);
		}

		$game->max_health = $max_health;
		$game->attack     = $attack;
		$game->defense    = $defense;
		$game->speed      = $speed;
		$game->save();
	}
}
