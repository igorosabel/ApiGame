<?php declare(strict_types=1);

namespace Osumi\OsumiFramework\App\Task;

use Osumi\OsumiFramework\Core\OTask;
use Osumi\OsumiFramework\App\Model\Scenario;

class MapTask extends OTask {
	public function __toString() {
		return "map: Tarea para generar imagen de mapa de un escenario";
	}

	private $scenario_width = null;
	private $scenario_height = null;
	private $tile_width = null;
	private $tile_height = null;
	private $rows = null;
	private $cols = null;

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
			'x' => ($start_x * $this->tile_width) - (($width-1) * $this->tile_width),
			'y' => $start_y * $this->tile_height - (($height-1) * $this->tile_height),
			'width' => $width * $this->tile_width,
			'height' => $height * $this->tile_height
		];

		return $ret;
	}

	public function run(array $options=[]): void {
		if (count($options) === 0) {
			echo "\n  ERROR: Debes indicar el id del escenario del que crear el mapa.\n\n";
			exit;
		}

		$id_scenario = intval($options['id_scenario']);
		$silent = false;
		if (count($options) === 2 && $options['silent']=='true') {
			$silent = true;
		}

		$scenario = new Scenario();
		if (!$scenario->find(['id' => $id_scenario])) {
			echo "\n  ERROR: No se ha encontrado el escenario indicado: ".$id_scenario."\n\n";
			exit;
		}

		$this->scenario_width = $this->getConfig()->getExtra('scenario_width');
		$this->scenario_height = $this->getConfig()->getExtra('scenario_height');
		$this->rows = $this->getConfig()->getExtra('height');
		$this->cols = $this->getConfig()->getExtra('width');
		$this->tile_width = $this->scenario_width / $this->cols;
		$this->tile_height = $this->scenario_height / $this->rows;

		$map_file = $this->getConfig()->getDir('maps').$scenario->get('id_world').'-'.$scenario->get('id').'.png';
		if (file_exists($map_file)) {
			unlink($map_file);
		}
		$outputImage = imagecreatetruecolor($this->scenario_width, $this->scenario_height);
		$data = $scenario->getData();

		// Background
		foreach ($data as $scenario_data) {
			$bg_file = $scenario_data->getBackground()->getAsset()->getFile();
			$bg_file_ext = $scenario_data->getBackground()->getAsset()->get('ext');
			list($width, $height) = getimagesize($bg_file);
			$bg = $this->getResource($bg_file, $bg_file_ext);

			imagecopyresized($outputImage, $bg, ($scenario_data->get('x') * $this->tile_width), ($scenario_data->get('y') * $this->tile_height), 0, 0, $this->tile_width, $this->tile_height, $width, $height);
		}

		// Scenario objects
		foreach ($data as $scenario_data) {
			if (!is_null($scenario_data->getScenarioObject()) && $scenario_data->getScenarioObject()->get('crossable')) {
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

				imagecopyresized($outputImage, $so, $so_position['y'], $so_position['x'], 0, 0, $so_position['width'], $so_position['height'], $width, $height);
			}
		}

		imagepng($outputImage, $map_file);
		imagedestroy($outputImage);
		if (!$silent) {
			echo "  \nNueva imagen \"".$map_file."\" creada.\n\n";
		}
	}
}
