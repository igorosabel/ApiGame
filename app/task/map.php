<?php declare(strict_types=1);
class mapTask extends OTask {
	public function __toString() {
		return "map: Nueva tarea map";
	}

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

	public function run(array $options=[]): void {
		if (count($options)==0) {
			echo "\n  ERROR: Debes indicar el id del escenario del que crear el mapa.\n\n";
			exit;
		}

		$id_scenario = intval($options[0]);

		$scenario = new Scenario();
		if (!$scenario->find(['id' => $id_scenario])) {
			echo "\n  ERROR: No se ha encontrado el escenario indicado: ".$id_scenario."\n\n";
			exit;
		}

		$map_file = $this->getConfig()->getDir('maps').$scenario->get('id_world').'-'.$scenario->get('id').'.png';
		if (file_exists($map_file)) {
			unlink($map_file);
		}
		$outputImage = imagecreatetruecolor(800, 592);
		$data = $scenario->getData();

		$new_width = 32;
		$new_height = 37;

		foreach ($data as $scenario_data) {
			$this->getLog()->debug("X: ".$scenario_data->get('x')." - Y: ".$scenario_data->get('y'));
			$bg_file = $scenario_data->getBackground()->getAsset()->getFile();
			$bg_file_ext = $scenario_data->getBackground()->getAsset()->get('ext');
			list($width, $height) = getimagesize($bg_file);
			$bg = $this->getResource($bg_file, $bg_file_ext);

			imagecopyresized($outputImage, $bg, ($scenario_data->get('y') * $new_width), ($scenario_data->get('x') * $new_height), 0, 0, $new_width, $new_height, $width, $height);

			if (!is_null($scenario_data->getScenarioObject())) {
				$so_file = $scenario_data->getScenarioObject()->getAsset()->getFile();
				$so_file_ext = $scenario_data->getScenarioObject()->getAsset()->get('ext');
				list($width, $height) = getimagesize($so_file);
				$so = $this->getResource($so_file, $so_file_ext);

				imagecopyresized($outputImage, $so, ($scenario_data->get('y') * $new_width), ($scenario_data->get('x') * $new_height), 0, 0, $new_width, $new_height, $width, $height);
			}
		}

		imagepng($outputImage, $map_file);
		imagedestroy($outputImage);
		echo "  \nNueva imagen \"".$map_file."\" creada.\n\n";
	}
}