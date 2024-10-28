<?php declare(strict_types=1);

namespace Osumi\OsumiFramework\App\Module\Admin\SaveBackground;

use Osumi\OsumiFramework\Core\OComponent;
use Osumi\OsumiFramework\Web\ORequest;
use Osumi\OsumiFramework\App\Model\Background;

class SaveBackgroundComponent extends OComponent {
  public string $status = 'ok';

	/**
	 * Función para guardar un fondo
	 *
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	public function run(ORequest $req): void {
		$id                     = $req->getParamInt('id');
		$id_background_category = $req->getParamInt('idBackgroundCategory');
		$id_asset               = $req->getParamInt('idAsset');
		$name                   = $req->getParamString('name');
		$crossable              = $req->getParamBool('crossable');

		if (is_null($name)) {
			$this->status = 'error';
		}

		if ($this->status === 'ok') {
			$background = Background::create();
			if (!is_null($id)) {
        $background = Background::findOne(['id' => $id]);
			}
			$background->id_background_category = $id_background_category;
			$background->id_asset               = $id_asset;
			$background->name                   = $name;
			$background->crossable              = $crossable;
			$background->save();
		}
	}
}
