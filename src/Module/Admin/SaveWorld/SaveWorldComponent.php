<?php declare(strict_types=1);

namespace Osumi\OsumiFramework\App\Module\Admin\SaveWorld;

use Osumi\OsumiFramework\Core\OComponent;
use Osumi\OsumiFramework\Web\ORequest;
use OsumiFramework\App\Model\World;

class SaveWorldComponent extends OComponent {
  public string $status = 'ok';

	/**
	 * Función para guardar un mundo
	 *
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	public function run(ORequest $req):void {
		$id          = $req->getParamInt('id');
		$name        = $req->getParamString('name');
		$description = $req->getParamString('description');
		$word_one    = $req->getParamString('wordOne');
		$word_two    = $req->getParamString('wordTwo');
		$word_three  = $req->getParamString('wordThree');
		$friendly    = $req->getParamBool('friendly');

		if (is_null($name) || is_null($word_one) || is_null($word_two) || is_null($word_three) || is_null($friendly)) {
			$this->status = 'error';
		}

		if ($this->status === 'ok') {
			$world = new World();
			if (!is_null($id)) {
				$world->find(['id' => $id]);
			}
			$world->set('name',        $name);
			$world->set('description', $description);
			$world->set('word_one',    $word_one);
			$world->set('word_two',    $word_two);
			$world->set('word_three',  $word_three);
			$world->set('friendly',    $friendly);
			$world->save();
		}
	}
}
