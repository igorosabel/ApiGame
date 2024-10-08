<?php declare(strict_types=1);

namespace Osumi\OsumiFramework\App\Module\Admin\SaveCharacter;

use Osumi\OsumiFramework\Routing\OAction;
use Osumi\OsumiFramework\Web\ORequest;
use Osumi\OsumiFramework\App\Service\AdminService;
use Osumi\OsumiFramework\App\Model\Character;

class SaveCharacterAction extends OAction {
  private ?AdminService $as = null;

  public string $status = 'ok';

  public function __construct() {
    $this->as = inject(AdminService::class);
  }

	/**
	 * Función para guardar un personaje
	 *
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	public function run(ORequest $req):void {
		$id             = $req->getParamInt('id');
		$type           = $req->getParamInt('type');
		$fixed_position = $req->getParamBool('fixedPosition');
		$id_asset_up    = $req->getParamInt('idAssetUp');
		$id_asset_down  = $req->getParamInt('idAssetDown');
		$id_asset_left  = $req->getParamInt('idAssetLeft');
		$id_asset_right = $req->getParamInt('idAssetRight');
		$name           = $req->getParamString('name');
		$width          = $req->getParamInt('width');
		$block_width    = $req->getParamInt('blockWidth');
		$height         = $req->getParamInt('height');
		$block_height   = $req->getParamInt('blockHeight');
		$health         = $req->getParamInt('health');
		$attack         = $req->getParamInt('attack');
		$defense        = $req->getParamInt('defense');
		$speed          = $req->getParamInt('speed');
		$drop_id_item   = $req->getParamInt('dropIdItem');
		$drop_chance    = $req->getParamInt('dropChance');
		$respawn        = $req->getParamInt('respawn');
		$framesUp       = $req->getParam('framesUp');
		$framesDown     = $req->getParam('framesDown');
		$framesLeft     = $req->getParam('framesLeft');
		$framesRight    = $req->getParam('framesRight');
		$narratives     = $req->getParam('narratives');

		if (is_null($name) || is_null($type) || is_null($width) || is_null($height)) {
			$this->status = 'error';
		}

		if ($this->status === 'ok') {
			$character = new Character();
			if (!is_null($id)) {
				$character->find(['id' => $id]);
			}
			$character->set('type',           $type);
			$character->set('fixed_position', $fixed_position);
			$character->set('id_asset_up',    $id_asset_up);
			$character->set('id_asset_down',  $id_asset_down);
			$character->set('id_asset_left',  $id_asset_left);
			$character->set('id_asset_right', $id_asset_right);
			$character->set('name',           $name);
			$character->set('width',          $width);
			$character->set('blockWidth',     $block_width);
			$character->set('height',         $height);
			$character->set('block_height',   $block_height);
			$character->set('health',         $health);
			$character->set('attack',         $attack);
			$character->set('defense',        $defense);
			$character->set('speed',          $speed);
			$character->set('drop_id_item',   $drop_id_item);
			$character->set('drop_chance',    $drop_chance);
			$character->set('respawn',        $respawn);
			$character->save();

			$this->as->updateCharacterFrames($character, $framesUp,    'up');
			$this->as->updateCharacterFrames($character, $framesDown,  'down');
			$this->as->updateCharacterFrames($character, $framesLeft,  'left');
			$this->as->updateCharacterFrames($character, $framesRight, 'right');
			$this->as->updateCharacterNarratives($character, $narratives);
		}
	}
}
