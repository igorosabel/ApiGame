<?php declare(strict_types=1);

namespace OsumiFramework\App\Module\Action;

use OsumiFramework\OFW\Routing\OModuleAction;
use OsumiFramework\OFW\Routing\OAction;
use OsumiFramework\OFW\Web\ORequest;
use OsumiFramework\App\Model\ScenarioObject;

#[OModuleAction(
	url: '/save-scenario-object',
	filters: ['admin'],
	services: ['admin']
)]
class saveScenarioObjectAction extends OAction {
	/**
	 * Función para guardar un objeto de escenario
	 *
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	public function run(ORequest $req):void {
		$status                = 'ok';
		$id                    = $req->getParamInt('id');
		$name                  = $req->getParamString('name');
		$id_asset              = $req->getParamInt('idAsset');
		$width                 = $req->getParamInt('width');
		$block_width           = $req->getParamInt('blockWidth');
		$height                = $req->getParamInt('height');
		$block_height          = $req->getParamInt('blockHeight');
		$crossable             = $req->getParamBool('crossable');
		$activable             = $req->getParamBool('activable');
		$id_asset_active       = $req->getParamInt('idAssetActive');
		$active_time           = $req->getParamInt('activeTime');
		$active_trigger        = $req->getParamInt('activeTrigger');
		$active_trigger_custom = $req->getParamString('activeTriggerCustom');
		$pickable              = $req->getParamBool('pickable');
		$grabbable             = $req->getParamBool('grabbable');
		$breakable             = $req->getParamBool('breakable');
		$drops                 = $req->getParam('drops');
		$frames                = $req->getParam('frames');

		if (is_null($name) || is_null($id_asset) || is_null($width) || is_null($height)) {
			$status = 'error';
		}

		if ($status=='ok') {
			$scenario_object = new ScenarioObject();
			if (!is_null($id)) {
				$scenario_object->find(['id' => $id]);
			}
			$scenario_object->set('name',                  $name);
			$scenario_object->set('id_asset',              $id_asset);
			$scenario_object->set('width',                 $width);
			$scenario_object->set('block_width',           $block_width);
			$scenario_object->set('height',                $height);
			$scenario_object->set('block_height',          $block_height);
			$scenario_object->set('crossable',             $crossable);
			$scenario_object->set('activable',             $activable);
			$scenario_object->set('id_asset_active',       $id_asset_active);
			$scenario_object->set('active_time',           $active_time);
			$scenario_object->set('active_trigger',        $active_trigger);
			$scenario_object->set('active_trigger_custom', $active_trigger_custom);
			$scenario_object->set('pickable',              $pickable);
			$scenario_object->set('grabbable',             $grabbable);
			$scenario_object->set('breakable',             $breakable);
			$scenario_object->save();

			$this->admin_service->updateScenarioObjectFrames($scenario_object, $frames);
			$this->admin_service->updateScenarioObjectDrops($scenario_object, $drops);
		}

		$this->getTemplate()->add('status', $status);
	}
}
