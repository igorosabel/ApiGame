<?php declare(strict_types=1);
class mapTask extends OTask {
	public function __toString() {
		return "map: Nueva tarea map";
	}

	public function run(array $options=[]): void {
		if (count($options)==0) {
			echo "ERROR: Debes indicar el id del escenario del que crear el mapa.\n\n";
			exit;
		}

		$id_scenario = intval($options[0]);

		$scenario = new Scenario();
		if (!$scenario->find(['id' => $id_scenario])) {
			echo "ERROR: No se ha encontrado el escenario indicado: ".$id_scenario."\n\n";
			exit;
		}

		var_dump($scenario);
	}
}