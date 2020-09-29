<?php declare(strict_types=1);
class npcResetTask extends OTask {
	/**
	 * Nombre de la tarea
	 */
	public function __toString() {
		return "npcReset: Función para reiniciar el número de objetos que tienen a la venta los NPC.";
	}

	/**
	 * Resetea todos los productos de los NPC tras 24 horas
	 *
	 * @return void
	 */
	public function run(): void {
		echo "Obtengo lista de NPC\n";
		$sql = "SELECT * FROM `npc`";
		$db = new ODB();
		$db->query($sql);
		$npc_list = [];

		while ($res = $db->next()) {
			$npc = new NPC();
			$npc->update($res);
			array_push($npc_list, $npc);
		}

		$common = OTools::getCache('common');
		echo "Tiempo de reset (días): ".$common['npc_reset']."\n";

		echo "Recorro lista de NPC: \n";
		$now = time();
		foreach ($npc_list as $npc) {
			echo "\n  ".$npc->get('id')." - ".$npc->get('name')."\n";
			echo "    Última fecha de reset: ".$npc->get('last_reset')."\n";
			$date = strtotime($npc->get('last_reset'));
			$check_date = $date + ($common['npc_reset'] * 24 * 60 * 60);
			if ($check_date<$now) {
				echo "    Fecha superada, reseteo NPC.\n";
				$npc->set('last_reset', date('Y-m-d H:i:s', $now));
				$npc->save();

				$sql = "SELECT * FROM `npc_ship` WHERE `id_npc` = ?";
				$db->query($sql, [$npc->get('id')]);
				while ($res = $db->next()) {
					$npc_ship = new NPCShip();
					$npc_ship->update($res);

					echo "      Actualizo naves:\n";
					echo "        Valor actual: ".$npc_ship->get('value')." - Valor original: ".$npc_ship->get('start_value')."\n";
					if ($npc_ship->get('value') != $npc_ship->get('start_value')) {
						echo "        Actualizo valor.\n";
						$npc_ship->set('value', $npc_ship->get('start_value'));
						$npc_ship->save();
					}
				}

				$sql = "SELECT * FROM `npc_module` WHERE `id_npc` = ?";
				$db->query($sql, [$npc->get('id')]);
				while ($res = $db->next()) {
					$npc_module = new NPCModule();
					$npc_module->update($res);

					echo "      Actualizo módulos:\n";
					echo "        Valor actual: ".$npc_module->get('value')." - Valor original: ".$npc_module->get('start_value')."\n";
					if ($npc_module->get('value') != $npc_module->get('start_value')) {
						echo "        Actualizo valor.\n";
						$npc_module->set('value', $npc_module->get('start_value'));
						$npc_module->save();
					}
				}

				$sql = "SELECT * FROM `npc_resource` WHERE `id_npc` = ?";
				$db->query($sql, [$npc->get('id')]);
				while ($res = $db->next()) {
					$npc_resource = new NPCResource();
					$npc_resource->update($res);

					echo "      Actualizo recursos:\n";
					echo "        Valor actual: ".$npc_resource->get('value')." - Valor original: ".$npc_resource->get('start_value')."\n";
					if ($npc_resource->get('value') != $npc_resource->get('start_value')) {
						echo "        Actualizo valor.\n";
						$npc_resource->set('value', $npc_resource->get('start_value'));
						$npc_resource->save();
					}
				}

				echo "    Nueva fecha de NPC: ".$npc->get('last_reset').".\n";
			}
		}

		echo "\n";
	}
}