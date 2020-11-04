<?php declare(strict_types=1);
class resetCharactersTask extends OTask {
	public function __toString() {
		return "resetCharacters: Tarea para resetear la salud de los enemigos";
	}

	public function run(array $options=[]): void {
		$db = new ODB();
		$sql = "SELECT * FROM `scenario_data` WHERE `id_character` IS NOT NULL";
		$db->query($sql);
		$scenario_datas = $db->fetchAll();
		$time = time();
		$updated = 0;

		echo "Compruebo ".count($scenario_datas)." personajes.\n\n";
		foreach ($scenario_datas as $res) {
			$scenario_data = new ScenarioData();
			$scenario_data->update($res);

			$character = $scenario_data->getCharacter();
			if ($scenario_data->get('character_health') != $character->get('health')) {
				echo "Salud actual del personaje: ".$scenario_data->get('character_health')." - Salud del personaje: ".$character->get('health')."\n";
				$last_update = strtotime($scenario_data->get('updated_at'));
				echo "  Última actualización: ".$last_update."\n";
				echo "  Respawn: ".$character->get('respawn')."\n";
				echo "  Comprobación: ".($last_update + $character->get('respawn'))."\n";
				echo "  Hora actual: ".$time."\n";
				if (($last_update + $character->get('respawn')) < $time) {
					$updated++;
					echo "    Actualizo salud del personaje\n";
					$scenario_data->set('character_health', $character->get('health'));
					$scenario_data->save();
				}
				echo "\n";
			}
		}
		echo "\nPersonajes actualizados: ".$updated."\n\n";
	}
}