<?php declare(strict_types=1);
class mapTask extends OTask {
	public function __toString() {
		return "map: Nueva tarea map";
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
		$outputImage = imagecreatetruecolor(800, 600);
		$data = $scenario->getData();
		
		$new_width = 32;
		$new_height = 36;
		
		foreach ($data as $scenario_data) {
			echo "X: ".$scenario_data->get('x')." - Y: ".$scenario_data->get('y')."\n";
			$this->getLog()->debug("X: ".$scenario_data->get('x')." - Y: ".$scenario_data->get('y'));
			$bg_file = $scenario_data->getBackground()->getAsset()->getFile();
			list($width, $height) = getimagesize($bg_file);
			$bg = imagecreatefrompng($bg_file);
			
			echo "  WIDTH: ".$width."\n";
			$this->getLog()->debug("  WIDTH: ".$width);
			echo "  HEIGHT: ".$height."\n";
			$this->getLog()->debug("  HEIGHT: ".$height);
			echo "  POS X: ".($scenario_data->get('x') * $new_width)."\n";
			$this->getLog()->debug("  POS X: ".($scenario_data->get('x') * $new_width));
			echo "  POS Y: ".($scenario_data->get('y') * $new_height)."\n\n";
			$this->getLog()->debug("  POS Y: ".($scenario_data->get('y') * $new_height));
			
			imagecopyresized($outputImage, $bg, ($scenario_data->get('y') * $new_height), ($scenario_data->get('x') * $new_width), 0, 0, $new_width, $new_height, $width, $height);
		}
		
		imagepng($outputImage, $map_file);
		imagedestroy($outputImage);
	}
}