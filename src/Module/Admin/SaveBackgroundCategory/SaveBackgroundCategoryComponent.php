<?php declare(strict_types=1);

namespace Osumi\OsumiFramework\App\Module\Admin\SaveBackgroundCategory;

use Osumi\OsumiFramework\Core\OComponent;
use Osumi\OsumiFramework\Web\ORequest;
use Osumi\OsumiFramework\App\Model\BackgroundCategory;

class SaveBackgroundCategoryComponent extends OComponent {
  public string $status = 'ok';

	/**
	 * Función para guardar una categoría de fondo
	 *
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	public function run(ORequest $req): void {
		$id   = $req->getParamInt('id');
		$name = $req->getParamString('name');

		if (is_null($name)) {
			$this->status = 'error';
		}

		if ($this->status === 'ok') {
			$background_category = BackgroundCategory::create();
			if (!is_null($id)) {
        $background_category = BackgroundCategory::findOne(['id' => $id]);
			}
			$background_category->name = $name;
			$background_category->save();
		}
	}
}
