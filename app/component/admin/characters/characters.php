<?php foreach ($values['list'] as $i => $character): ?>
	{
		"id": <?php echo $character->get('id') ?>,
		"name": "<?php echo urlencode($character->get('name')) ?>",
		"width": <?php echo $character->get('width') ?>,
		"height": <?php echo $character->get('height') ?>,
		"idAssetUp": <?php     echo !is_null($character->get('id_asset_up'))    ? $character->get('id_asset_up')    : 'null' ?>,
		"assetUpUrl": <?php    echo !is_null($character->getAsset('up'))        ? '"'.urlencode($character->getAsset('up')->getUrl()).'"'    : 'null' ?>,
		"idAssetDown": <?php   echo !is_null($character->get('id_asset_down'))  ? $character->get('id_asset_down')  : 'null' ?>,
		"assetDownUrl": <?php  echo !is_null($character->getAsset('down'))      ? '"'.urlencode($character->getAsset('down')->getUrl()).'"'  : 'null' ?>,
		"idAssetLeft": <?php   echo !is_null($character->get('id_asset_left'))  ? $character->get('id_asset_left')  : 'null' ?>,
		"assetLeftUrl": <?php  echo !is_null($character->getAsset('left'))      ? '"'.urlencode($character->getAsset('left')->getUrl()).'"'  : 'null' ?>,
		"idAssetRight": <?php  echo !is_null($character->get('id_asset_right')) ? $character->get('id_asset_right') : 'null' ?>,
		"assetRightUrl": <?php echo !is_null($character->getAsset('right'))     ? '"'.urlencode($character->getAsset('right')->getUrl()).'"' : 'null' ?>,
		"type": <?php          echo !is_null($character->get('type'))           ? $character->get('type')           : 'null' ?>,
		"health": <?php        echo !is_null($character->get('health'))         ? $character->get('health')         : 'null' ?>,
		"attack": <?php        echo !is_null($character->get('attack'))         ? $character->get('attack')         : 'null' ?>,
		"defense": <?php       echo !is_null($character->get('defense'))        ? $character->get('defense')        : 'null' ?>,
		"speed": <?php         echo !is_null($character->get('speed'))          ? $character->get('speed')          : 'null' ?>,
		"dropIdItem": <?php    echo !is_null($character->get('drop_id_item'))   ? $character->get('drop_id_item')   : 'null' ?>,
		"dropAssetUrl": <?php  echo !is_null($character->getAsset('drop'))      ? '"'.urlencode($character->getAsset('drop')->getUrl()).'"'  : 'null' ?>,
		"dropChance": <?php    echo !is_null($character->get('drop_chance'))    ? $character->get('drop_chance')    : 'null' ?>,
		"respawn": <?php       echo !is_null($character->get('respawn'))        ? $character->get('respawn')        : 'null' ?>,
		"framesUp": [
<?php foreach ($character->getFrames('up') as $j => $character_frame): ?>
			{
				"id": <?php echo $character_frame->get('id') ?>,
				"idAsset": <?php echo $character_frame->get('id_asset') ?>,
				"assetUrl": "<?php echo urlencode($character_frame->getAsset()->getUrl()) ?>",
				"orientation": "<?php echo $character_frame->get('orientation') ?>",
				"order": <?php echo $character_frame->get('order') ?>
			}<?php if ($j<count($character->getFrames('up'))-1): ?>,<?php endif ?>
<?php endforeach ?>
		],
		"framesDown": [
<?php foreach ($character->getFrames('down') as $j => $character_frame): ?>
			{
				"id": <?php echo $character_frame->get('id') ?>,
				"idAsset": <?php echo $character_frame->get('id_asset') ?>,
				"assetUrl": "<?php echo urlencode($character_frame->getAsset()->getUrl()) ?>",
				"orientation": "<?php echo $character_frame->get('orientation') ?>",
				"order": <?php echo $character_frame->get('order') ?>
			}<?php if ($j<count($character->getFrames('down'))-1): ?>,<?php endif ?>
<?php endforeach ?>
		],
		"framesLeft": [
<?php foreach ($character->getFrames('left') as $j => $character_frame): ?>
			{
				"id": <?php echo $character_frame->get('id') ?>,
				"idAsset": <?php echo $character_frame->get('id_asset') ?>,
				"assetUrl": "<?php echo urlencode($character_frame->getAsset()->getUrl()) ?>",
				"orientation": "<?php echo $character_frame->get('orientation') ?>",
				"order": <?php echo $character_frame->get('order') ?>
			}<?php if ($j<count($character->getFrames('left'))-1): ?>,<?php endif ?>
<?php endforeach ?>
		],
		"framesRight": [
<?php foreach ($character->getFrames('right') as $j => $character_frame): ?>
			{
				"id": <?php echo $character_frame->get('id') ?>,
				"idAsset": <?php echo $character_frame->get('id_asset') ?>,
				"assetUrl": "<?php echo urlencode($character_frame->getAsset()->getUrl()) ?>",
				"orientation": "<?php echo $character_frame->get('orientation') ?>",
				"order": <?php echo $character_frame->get('order') ?>
			}<?php if ($j<count($character->getFrames('right'))-1): ?>,<?php endif ?>
<?php endforeach ?>
		]
	}<?php if ($i<count($values['list'])-1): ?>,<?php endif ?>
<?php endforeach ?>