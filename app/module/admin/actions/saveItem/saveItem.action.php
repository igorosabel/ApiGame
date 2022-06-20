<?php declare(strict_types=1);

namespace OsumiFramework\App\Module\Action;

use OsumiFramework\OFW\Routing\OModuleAction;
use OsumiFramework\OFW\Routing\OAction;
use OsumiFramework\OFW\Web\ORequest;
use OsumiFramework\App\Model\Item;

#[OModuleAction(
	url: '/save-item',
	filter: 'admin',
	services: ['admin']
)]
class saveItemAction extends OAction {
	/**
	 * Función para guardar un item
	 *
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	public function run(ORequest $req):void {
		$status   = 'ok';
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
			$status = 'error';
		}

		if ($status=='ok') {
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

			$this->admin_service->updateItemFrames($item, $frames);
		}

		$this->getTemplate()->add('status', $status);
	}
}
