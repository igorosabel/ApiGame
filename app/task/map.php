<?php declare(strict_types=1);
class mapTask extends OTask {
	public function __toString() {
		return "map: Nueva tarea map";
	}

	private $tile_size = 32;
	private $rows = 20;
	private $cols = 25;

	private function getResource(string $file, string $ext) {
		switch ($ext) {
			case 'jpg': {
				return imagecreatefromjpeg($file);
			}
			break;
			case 'jpeg': {
				return imagecreatefromjpeg($file);
			}
			break;
			case 'png': {
				return imagecreatefrompng($file);
			}
			break;
			case 'gif': {
				return imagecreatefromgif($file);
			}
		}
	}

	private function calculatePosition(int $start_x, int $start_y, int $width, int $height): array {
		$ret = [
			'x' => ($start_x * $this->tile_size) - (($width-1) * $this->tile_size),
			'y' => $start_y * $this->tile_size - (($height-1) * $this->tile_size),
			'width' => $width * $this->tile_size,
			'height' => $height * $this->tile_size
		];

		return $ret;
	}

	public function run(array $options=[]): void {
		if (count($options)==0) {
			echo "\n  ERROR: Debes indicar el id del escenario del que crear el mapa.\n\n";
			exit;
		}

		$id_scenario = intval($options[0]);
		$silent = false;
		if (count($options)==2 && $options[1]=='true') {
			$silent = true;
		}

		$scenario = new Scenario();
		if (!$scenario->find(['id' => $id_scenario])) {
			echo "\n  ERROR: No se ha encontrado el escenario indicado: ".$id_scenario."\n\n";
			exit;
		}

		$map_file = $this->getConfig()->getDir('maps').$scenario->get('id_world').'-'.$scenario->get('id').'.png';
		if (file_exists($map_file)) {
			unlink($map_file);
		}
		$outputImage = imagecreatetruecolor(($this->cols * $this->tile_size), ($this->rows * $this->tile_size));
		$data = $scenario->getData();

		// Background
		foreach ($data as $scenario_data) {
			$this->getLog()->debug("X: ".$scenario_data->get('x')." - Y: ".$scenario_data->get('y'));
			$bg_file = $scenario_data->getBackground()->getAsset()->getFile();
			$bg_file_ext = $scenario_data->getBackground()->getAsset()->get('ext');
			list($width, $height) = getimagesize($bg_file);
			$bg = $this->getResource($bg_file, $bg_file_ext);

			imagecopyresized($outputImage, $bg, ($scenario_data->get('y') * $this->tile_size), ($scenario_data->get('x') * $this->tile_size), 0, 0, $this->tile_size, $this->tile_size, $width, $height);
		}

		// Scenario objects
		foreach ($data as $scenario_data) {
			if (!is_null($scenario_data->getScenarioObject())) {
				$so_file = $scenario_data->getScenarioObject()->getAsset()->getFile();
				$so_file_ext = $scenario_data->getScenarioObject()->getAsset()->get('ext');
				list($width, $height) = getimagesize($so_file);
				$so = $this->getResource($so_file, $so_file_ext);
				$so_position = $this->calculatePosition(
					$scenario_data->get('y'),
					$scenario_data->get('x'),
					$scenario_data->getScenarioObject()->get('width'),
					$scenario_data->getScenarioObject()->get('height')
				);

				imagecopyresized($outputImage, $so, $so_position['x'], $so_position['y'], 0, 0, $so_position['width'], $so_position['height'], $width, $height);
			}
		}

		imagepng($outputImage, $map_file);
		imagedestroy($outputImage);
		if (!$silent) {
			echo "  \nNueva imagen \"".$map_file."\" creada.\n\n";
		}
	}
}