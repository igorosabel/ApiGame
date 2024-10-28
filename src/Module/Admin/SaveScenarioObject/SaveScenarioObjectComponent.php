<?php declare(strict_types=1);

namespace Osumi\OsumiFramework\App\Module\Admin\SaveScenarioObject;

use Osumi\OsumiFramework\Core\OComponent;
use Osumi\OsumiFramework\Web\ORequest;
use Osumi\OsumiFramework\App\Service\AdminService;
use Osumi\OsumiFramework\App\Model\ScenarioObject;

class SaveScenarioObjectComponent extends OComponent {
  private ?AdminService $as = null;

  public string $status = 'ok';

  public function __construct() {
    parent::__construct();
    $this->as = inject(AdminService::class);
  }

	/**
	 * Función para guardar un objeto de escenario
	 *
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	public function run(ORequest $req): void {
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
			$this->status = 'error';
		}

		if ($this->status === 'ok') {
			$scenario_object = ScenarioObject::create();
			if (!is_null($id)) {
        $scenario_object = ScenarioObject::findOne(['id' => $id]);
			}
			$scenario_object->name                  = $name;
			$scenario_object->id_asset              = $id_asset;
			$scenario_object->width                 = $width;
			$scenario_object->block_width           = $block_width;
			$scenario_object->height                = $height;
			$scenario_object->block_height          = $block_height;
			$scenario_object->crossable             = $crossable;
			$scenario_object->activable             = $activable;
			$scenario_object->id_asset_active       = $id_asset_active;
			$scenario_object->active_time           = $active_time;
			$scenario_object->active_trigger        = $active_trigger;
			$scenario_object->active_trigger_custom = $active_trigger_custom;
			$scenario_object->pickable              = $pickable;
			$scenario_object->grabbable             = $grabbable;
			$scenario_object->breakable             = $breakable;
			$scenario_object->save();

			$this->as->updateScenarioObjectFrames($scenario_object, $frames);
			$this->as->updateScenarioObjectDrops($scenario_object, $drops);
		}
	}
}
