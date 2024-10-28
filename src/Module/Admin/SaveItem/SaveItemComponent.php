<?php declare(strict_types=1);

namespace Osumi\OsumiFramework\App\Module\Admin\SaveItem;

use Osumi\OsumiFramework\Core\OComponent;
use Osumi\OsumiFramework\Web\ORequest;
use Osumi\OsumiFramework\App\Service\AdminService;
use Osumi\OsumiFramework\App\Model\Item;

class SaveItemComponent extends OComponent {
  private ?AdminService $as = null;

  public string $status = 'ok';

  public function __construct() {
    parent::__construct();
    $this->as = inject(AdminService::class);
  }

	/**
	 * Función para guardar un item
	 *
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	public function run(ORequest $req): void {
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

		if ($this->status === 'ok') {
			$item = Item::create();
			if (!is_null($id)) {
        $item = Item::findOne(['id' => $id]);
			}
			$item->type     = $type;
			$item->id_asset = $id_asset;
			$item->name     = $name;
			$item->money    = $money;
			$item->health   = $health;
			$item->attack   = $attack;
			$item->defense  = $defense;
			$item->speed    = $speed;
			$item->wearable = $wearable;
			$item->save();

			$this->as->updateItemFrames($item, $frames);
		}
	}
}
