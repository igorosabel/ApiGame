<?php if (is_null($character)): ?>
null
<?php else: ?>
{
	"id": <?php echo $character->get('id') ?>,
	"name": "<?php echo urlencode($character->get('name')) ?>",
	"width": <?php echo $character->get('width') ?>,
	"blockWidth": <?php echo is_null($character->get('block_width')) ? 'null' : $character->get('block_width') ?>,
	"height": <?php echo $character->get('height') ?>,
	"blockHeight": <?php echo is_null($character->get('block_height')) ? 'null' : $character->get('block_height') ?>,
	"fixedPosition": <?php echo $character->get('fixed_position') ? 'true' : 'false' ?>,
	"idAssetUp": <?php echo is_null($character->get('id_asset_up')) ? 'null' : $character->get('id_asset_up') ?>,
	"assetUpUrl": <?php echo !is_null($character->getAsset('up')) ? '"'.urlencode($character->getAsset('up')->getUrl()).'"' : 'null' ?>,
	"idAssetDown": <?php echo is_null($character->get('id_asset_down')) ? 'null' : $character->get('id_asset_down') ?>,
	"assetDownUrl": <?php  echo !is_null($character->getAsset('down')) ? '"'.urlencode($character->getAsset('down')->getUrl()).'"' : 'null' ?>,
	"idAssetLeft": <?php echo is_null($character->get('id_asset_left')) ? 'null' : $character->get('id_asset_left') ?>,
	"assetLeftUrl": <?php  echo !is_null($character->getAsset('left')) ? '"'.urlencode($character->getAsset('left')->getUrl()).'"' : 'null' ?>,
	"idAssetRight": <?php echo is_null($character->get('id_asset_right')) ? 'null' : $character->get('id_asset_right') ?>,
	"assetRightUrl": <?php echo !is_null($character->getAsset('right')) ? '"'.urlencode($character->getAsset('right')->getUrl()).'"' : 'null' ?>,
	"type": <?php echo $character->get('type') ?>,
	"health": <?php echo is_null($character->get('health')) ? 'null' : $character->get('health') ?>,
	"attack": <?php echo is_null($character->get('attack')) ? 'null' : $character->get('attack') ?>,
	"defense": <?php echo is_null($character->get('defense')) ? 'null' : $character->get('defense') ?>,
	"speed": <?php echo is_null($character->get('speed')) ? 'null' : $character->get('speed') ?>,
	"dropIdItem": <?php echo is_null($character->get('drop_id_item')) ? 'null' : $character->get('drop_id_item') ?>,
	"dropAssetUrl": <?php  echo !is_null($character->getAsset('drop')) ? '"'.urlencode($character->getAsset('drop')->getUrl()).'"' : 'null' ?>,
	"dropChance": <?php echo is_null($character->get('drop_chance')) ? 'null' : $character->get('drop_chance') ?>,
	"respawn": <?php echo is_null($character->get('respawn')) ? 'null' : $character->get('respawn') ?>,
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
	],
	"narratives": [
<?php foreach ($character->getNarratives() as $j => $narrative): ?>
		{
			"id": <?php echo $narrative->get('id') ?>,
			"dialog": "<?php echo urlencode($narrative->get('dialog')) ?>",
			"order": <?php echo $narrative->get('order') ?>
		}<?php if ($j<count($character->getNarratives())-1): ?>,<?php endif ?>
<?php endforeach ?>
	]
}
<?php endif ?>
