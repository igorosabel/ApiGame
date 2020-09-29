<?php declare(strict_types=1);
class webService extends OService {
	/**
	 * Load service tools
	 */
	function __construct() {
		$this->loadService();
	}

	/**
	 * Obtiene la lista de partidas de un usuario
	 *
	 * @param int $id_user Id del usuario
	 *
	 * @return array Lista de partidas
	 */
	public function getGames(int $id_user): array {
		$ret = [];
		$db = new ODB();
		$sql = "SELECT * FROM `game` WHERE `id_user` = ?";
		$db->query($sql, [$id_user]);

		while ($res = $db->next()) {
			$game = new Game();
			$game->update($res);

			array_push($ret, $game);
		}

		return $ret;
	}

	/**
	 * Obtiene el escenario inicial
	 *
	 * @return Scenario Escenario inicial del juego
	 */
	public function getStartScenario(): Scenario {
		$db = new ODB();
		$sql = "SELECT * FROM `scenario` WHERE `initial` = 1";
		$db->query($sql);

		$res = $db->next();
		$scn = new Scenario();
		$scn->update($res);

		return $scn;
	}

	/**
	 * Obtiene la lista de categorías de fondos
	 *
	 * @return array Lista de categorías de fondos
	 */
	public function getBackgroundCategories(): array {
		$db = new ODB();
		$sql = "SELECT * FROM `background_category`";
		$db->query($sql);
		$bckcs = [];
		while ($res=$db->next()) {
			$bckc = new BackgroundCategory();
			$bckc->update($res);

			$bckcs['bckc_'.$bckc->get('id')] = $bckc;
		}

		return $bckcs;
	}

	/**
	 * Obtiene la lista de categorías de fondos y carga sus datos
	 *
	 * @return array Lista de categorías de fondos con sus datos cargados
	 */
	public function getBackgrounds(): array {
		$ret = [];
		$db = new ODB();
		$sql = "SELECT * FROM `background_category` ORDER BY `name`";
		$db->query($sql);

		while ($res=$db->next()) {
			$bckc = new BackgroundCategory();
			$bckc->update($res);
			$bckc->loadBackgrounds();

			array_push($ret, $bckc);
		}

		return $ret;
	}

	/**
	 * Obtiene la información de las categorías de fondos que se le pasan con sus datos en formato array
	 *
	 * @return array Lista con la información de las categorías de fondos
	 */
	public function getBackgroundsData(array $list): array {
		$data = [];
		$all = [];

		foreach ($list as $bckc) {
			$item = [
				'id' => $bckc->get('id'),
				'name' => urlencode($bckc->get('name')),
				'list' => array()
			];

			foreach ($bckc->getBackgrounds() as $bck) {
				$item_bck = [
					'id' => $bck->get('id'),
					'name' => urlencode($bck->get('name')),
					'class' => $bck->get('file'),
					'crossable' => $bck->get('crossable')
				];
				array_push($item['list'], $bck->get('id'));
				$all['bck_'.$bck->get('id')] = $item_bck;
			}

			$data['bckc_'.$item['id']] = $item;
		}
		$data['list'] = $all;
		return $data;
	}

	/**
	 * Obtiene todos los assets/sprites de un escenario
	 *
	 * @param string $scn Datos del escenario del que obtener los recursos
	 *
	 * @return array Lista de assets/sprites del escenario
	 */
	public function getAssetsData(string $scn): array {
		$ret = ['assets' => [], 'bck' => [], 'spr' => []];
		$ids = ['bck' => [], 'spr' => []];

		$scenario = json_decode($scn, true);
		for ($y=0; $y<count($scenario); $y++) {
			for ($x=0; $x < count($scenario[$y]); $x++) {
				foreach ($scenario[$y][$x] as $type => $val) {
					$temp = ['type' => $type, 'x' => ($x + 1), 'y' => ($y + 1), 'id' => $val];
					array_push($ret['assets'], $temp);
					if (!in_array($val, $ids[$type])) {
						array_push($ids[$type], $val);
					}
				}
			}
		}

		$db = new ODB();
		if (count($ids['bck'])>0) {
			$bckcs = $this->getBackgroundCategories();

			$sql = 'SELECT * FROM `background` WHERE `id` IN ('.implode(',', $ids['bck']).')';
			$db->query($sql);

			while ($res=$db->next()) {
				$bck = new Background();
				$bck->update($res);
				$ret['bck']['bck_'.$bck->get('id')] = [
					'url' => $bckcs['bckc_'.$bck->get('id_category')]->get('slug').'/'.$bck->get('file'),
					'crossable' => $bck->get('crossable')
				];
			}
		}
		if (count($ids['spr'])>0) {
			$sprcs = $this->getSpriteCategories();

			$sql = 'SELECT * FROM `sprite` WHERE `id` IN ('.implode(',', $ids['spr']).')';
			$db->query($sql);

			while ($res=$db->next()) {
				$spr = new Sprite();
				$spr->update($res);
				$ret['spr']['spr_'.$spr->get('id')] = [
					'url' => $sprcs['sprc_'.$spr->get('id_category')]->get('slug').'/'.$spr->get('file'),
					'crossable' => $spr->get('crossable')
				];
			}
		}

		return $ret;
	}

	/**
	 * Obtiene la lista de categorías de sprites
	 *
	 * @return array Lista de categorías de sprites
	 */
	public function getSpriteCategories(): array {
		$db = new ODB();
		$sql = "SELECT * FROM `sprite_category`";
		$db->query($sql);
		$sprcs = [];
		while ($res=$db->next()){
			$sprc = new SpriteCategory();
			$sprc->update($res);

			$sprcs['sprc_'.$sprc->get('id')] = $sprc;
		}

		return $sprcs;
	}

	/**
	 * Obtiene la lista de categorías de sprites ordenadas por nombre y carga sus datos
	 *
	 * @return Lista de categorías de sprites ordenadas por nombre con sus datos cargados
	 */
	public function getSprites(): array {
		$ret = [];
		$db = new ODB();
		$sql = "SELECT * FROM `sprite_category` ORDER BY `name`";
		$db->query($sql);

		while ($res=$db->next()) {
			$sprc = new SpriteCategory();
			$sprc->update($res);
			$sprc->loadSprites();

			array_push($ret, $sprc);
		}

		return $ret;
	}

	/**
	 * Obtiene la información de los sprites de una lista de categorías de sprites
	 *
	 * @param array $list Lista de categorías de sprites
	 *
	 * @return array Lista con la información de las categorías de sprites
	 */
	public function getSpritesData(array $list): array {
		$data = [];
		$all = [];

		foreach ($list as $sprc) {
			$item = [
				'id' => $sprc->get('id'),
				'name' => urlencode($sprc->get('name')),
				'list' => []
			];

			foreach ($sprc->getSprites() as $spr) {
				$item_spr = [
					'id' => $spr->get('id'),
					'name' => urlencode($spr->get('name')),
					'class' => $spr->get('file'),
					'crossable' => $spr->get('crossable'),
					'breakable' => $spr->get('breakable'),
					'grabbable' => $spr->get('breakable')
				];
				array_push($item['list'], $spr->get('id'));
				$all['spr_'.$spr->get('id')] = $item_spr;
			}

			$data['sprc_'.$item['id']] = $item;
		}
		$data['list'] = $all;
		return $data;
	}

	/**
	 * Obtiene la lista de elementos interactivos
	 *
	 * @return array Lista de elementos interactivos
	 */
	public function getInteractives(): array {
		$ret = [];
		$db = new ODB();
		$sql = "SELECT * FROM `interactive` ORDER BY `name`";
		$db->query($sql);

		while ($res=$db->next()) {
			$int = new Interactive();
			$int->update($res);
			$int->loadSpriteStart();

			array_push($ret, $int);
		}

		return $ret;
	}

	/**
	 * Obtiene la información de una lista de elementos interactivos
	 *
	 * @param array $list Lista de elementos interactivos
	 *
	 * @return array Lista con la información de los elementos interactivos
	 */
	public function getInteractivesData(array $list): array {
		$data = [];

		foreach ($list as $int) {
			$item_int = [
				'id' => $int->get('id'),
				'name' => urlencode($int->get('name')),
				'sprite_start' => $int->get('sprite_start'),
				'sprite_end' => $int->get('sprite_end'),
				'start_url' => '/assets/sprite/'.$int->getSpriteStart()->getCategory()->get('slug').'/'.$int->getSpriteStart()->get('file').'.png'
			];
			$data['int_'.$item_int['id']] = $item_int;
		}

		return $data;
	}

	/**
	 * Guarda una imagen que viene en base64 como un archivo binario en la ruta indicada
	 *
	 * @param string $ruta Ruta donde guardar la imagen
	 *
	 * @param string $base64_string Contenido de la imagen en base64
	 *
	 * @return void
	 */
	public function saveImage(string $ruta, string $base64_string): void {
		if (file_exists($ruta)) {
			unlink($ruta);
		}

		$ifp = fopen($ruta, 'wb');
		$data = explode(',', $base64_string);
		fwrite($ifp, base64_decode($data[1]));
		fclose($ifp);
	}
}