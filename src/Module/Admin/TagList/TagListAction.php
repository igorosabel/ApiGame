<?php declare(strict_types=1);

namespace Osumi\OsumiFramework\App\Module\Admin\TagList;

use Osumi\OsumiFramework\Routing\OAction;
use Osumi\OsumiFramework\Web\ORequest;
use Osumi\OsumiFramework\App\Component\Model\TagList\TagListComponent;

class TagListAction extends OAction {
  public string $status = 'ok';
  public ?TagListComponent $list = null;

	/**
	 * Función para obtener la lista de tags
	 *
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	public function run(ORequest $req):void {
		$this->list = new TagListComponent(['list' => $this->service['Admin']->getTags()]);
	}
}
