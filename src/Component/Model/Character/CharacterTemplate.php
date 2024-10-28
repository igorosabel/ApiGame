<?php if (is_null($character)): ?>
null
<?php else: ?>
{
	"id": <?php echo $character->id ?>,
	"name": "<?php echo urlencode($character->name) ?>",
	"width": <?php echo $character->width ?>,
	"blockWidth": <?php echo is_null($character->block_width) ? 'null' : $character->block_width ?>,
	"height": <?php echo $character->height ?>,
	"blockHeight": <?php echo is_null($character->block_height) ? 'null' : $character->block_height ?>,
	"fixedPosition": <?php echo $character->fixed_position ? 'true' : 'false' ?>,
	"idAssetUp": <?php echo is_null($character->id_asset_up) ? 'null' : $character->id_asset_up ?>,
	"assetUpUrl": <?php echo !is_null($character->getAsset('up')) ? '"'.urlencode($character->getAsset('up')->getUrl()).'"' : 'null' ?>,
	"idAssetDown": <?php echo is_null($character->id_asset_down) ? 'null' : $character->id_asset_down ?>,
	"assetDownUrl": <?php  echo !is_null($character->getAsset('down')) ? '"'.urlencode($character->getAsset('down')->getUrl()).'"' : 'null' ?>,
	"idAssetLeft": <?php echo is_null($character->id_asset_left) ? 'null' : $character->id_asset_left ?>,
	"assetLeftUrl": <?php  echo !is_null($character->getAsset('left')) ? '"'.urlencode($character->getAsset('left')->getUrl()).'"' : 'null' ?>,
	"idAssetRight": <?php echo is_null($character->id_asset_right) ? 'null' : $character->id_asset_right ?>,
	"assetRightUrl": <?php echo !is_null($character->getAsset('right')) ? '"'.urlencode($character->getAsset('right')->getUrl()).'"' : 'null' ?>,
	"type": <?php echo $character->type ?>,
	"health": <?php echo is_null($character->health) ? 'null' : $character->health ?>,
	"attack": <?php echo is_null($character->attack) ? 'null' : $character->attack ?>,
	"defense": <?php echo is_null($character->defense) ? 'null' : $character->defense ?>,
	"speed": <?php echo is_null($character->speed) ? 'null' : $character->speed ?>,
	"dropIdItem": <?php echo is_null($character->drop_id_item) ? 'null' : $character->drop_id_item ?>,
	"dropAssetUrl": <?php  echo !is_null($character->getAsset('drop')) ? '"'.urlencode($character->getAsset('drop')->getUrl()).'"' : 'null' ?>,
	"dropChance": <?php echo is_null($character->drop_chance) ? 'null' : $character->drop_chance ?>,
	"respawn": <?php echo is_null($character->respawn) ? 'null' : $character->respawn ?>,
	"framesUp": [
<?php foreach ($character->getFrames('up') as $j => $character_frame): ?>
		{
			"id": <?php echo $character_frame->id ?>,
			"idAsset": <?php echo $character_frame->id_asset ?>,
			"assetUrl": "<?php echo urlencode($character_frame->getAsset()->getUrl()) ?>",
			"orientation": "<?php echo $character_frame->orientation ?>",
			"order": <?php echo $character_frame->order ?>
		}<?php if ($j < count($character->getFrames('up')) - 1): ?>,<?php endif ?>
<?php endforeach ?>
	],
	"framesDown": [
<?php foreach ($character->getFrames('down') as $j => $character_frame): ?>
		{
			"id": <?php echo $character_frame->id ?>,
			"idAsset": <?php echo $character_frame->id_asset ?>,
			"assetUrl": "<?php echo urlencode($character_frame->getAsset()->getUrl()) ?>",
			"orientation": "<?php echo $character_frame->orientation ?>",
			"order": <?php echo $character_frame->order ?>
		}<?php if ($j < count($character->getFrames('down')) - 1): ?>,<?php endif ?>
<?php endforeach ?>
	],
	"framesLeft": [
<?php foreach ($character->getFrames('left') as $j => $character_frame): ?>
		{
			"id": <?php echo $character_frame->id ?>,
			"idAsset": <?php echo $character_frame->id_asset ?>,
			"assetUrl": "<?php echo urlencode($character_frame->getAsset()->getUrl()) ?>",
			"orientation": "<?php echo $character_frame->orientation ?>",
			"order": <?php echo $character_frame->order ?>
		}<?php if ($j < count($character->getFrames('left')) - 1): ?>,<?php endif ?>
<?php endforeach ?>
	],
	"framesRight": [
<?php foreach ($character->getFrames('right') as $j => $character_frame): ?>
		{
			"id": <?php echo $character_frame->id ?>,
			"idAsset": <?php echo $character_frame->id_asset ?>,
			"assetUrl": "<?php echo urlencode($character_frame->getAsset()->getUrl()) ?>",
			"orientation": "<?php echo $character_frame->orientation ?>",
			"order": <?php echo $character_frame->order ?>
		}<?php if ($j < count($character->getFrames('right')) - 1): ?>,<?php endif ?>
<?php endforeach ?>
	],
	"narratives": [
<?php foreach ($character->getNarratives() as $j => $narrative): ?>
		{
			"id": <?php echo $narrative->id ?>,
			"dialog": "<?php echo urlencode($narrative->dialog) ?>",
			"order": <?php echo $narrative->order ?>
		}<?php if ($j < count($character->getNarratives()) - 1): ?>,<?php endif ?>
<?php endforeach ?>
	]
}
<?php endif ?>
