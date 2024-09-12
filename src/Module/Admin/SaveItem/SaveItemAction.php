<?php declare(strict_types=1);

namespace Osumi\OsumiFramework\App\Module\Admin\SaveItem;

use Osumi\OsumiFramework\Routing\OAction;
use Osumi\OsumiFramework\Web\ORequest;
use Osumi\OsumiFramework\App\Model\Item;

class SaveItemAction extends OAction {
  public string $status = 'ok';

	/**
	 * Función para guardar un item
	 *
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	public function run(ORequest $req):void {
		$id       = $req->getParamInt('id');
		$type     = $req->getParamInt('type');
		$id_asset = $req->getParamInt('idAsset');
		$name     = $req->getParamString('name');
		$money    = $req->getParamInt('money');
		$health   = $req->getParamInt('health');
		$attack   = $req->getParamInt('attack');
		$defense  = $req->getParamInt('defense');
		$speed    = $req->getParamInt('speed');
		$wearable = $req->getParamInt('wearable');
		$frames   = $req->getParam('frames');

		if (is_null($name) || is_null($id_asset) || is_null($type)) {
			$this->status = 'error';
		}

		if ($this->status=='ok') {
			$item = new Item();
			if (!is_null($id)) {
				$item->find(['id' => $id]);
			}
			$item->set('type',     $type);
			$item->set('id_asset', $id_asset);
			$item->set('name',     $name);
			$item->set('money',    $money);
			$item->set('health',   $health);
			$item->set('attack',   $attack);
			$item->set('defense',  $defense);
			$item->set('speed',    $speed);
			$item->set('wearable', $wearable);
			$item->save();

			$this->service['Admin']->updateItemFrames($item, $frames);
		}
	}
}
