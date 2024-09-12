<?php if (is_null($values['Character'])): ?>
null
<?php else: ?>
{
	"id": <?php echo $values['Character']->get('id') ?>,
	"name": "<?php echo urlencode($values['Character']->get('name')) ?>",
	"width": <?php echo $values['Character']->get('width') ?>,
	"blockWidth": <?php echo is_null($values['Character']->get('block_width')) ? 'null' : $values['Character']->get('block_width') ?>,
	"height": <?php echo $values['Character']->get('height') ?>,
	"blockHeight": <?php echo is_null($values['Character']->get('block_height')) ? 'null' : $values['Character']->get('block_height') ?>,
	"fixedPosition": <?php echo $values['Character']->get('fixed_position') ? 'true' : 'false' ?>,
	"idAssetUp": <?php echo is_null($values['Character']->get('id_asset_up')) ? 'null' : $values['Character']->get('id_asset_up') ?>,
	"assetUpUrl": <?php echo !is_null($values['Character']->getAsset('up')) ? '"'.urlencode($values['Character']->getAsset('up')->getUrl()).'"' : 'null' ?>,
	"idAssetDown": <?php echo is_null($values['Character']->get('id_asset_down')) ? 'null' : $values['Character']->get('id_asset_down') ?>,
	"assetDownUrl": <?php  echo !is_null($values['Character']->getAsset('down')) ? '"'.urlencode($values['Character']->getAsset('down')->getUrl()).'"' : 'null' ?>,
	"idAssetLeft": <?php echo is_null($values['Character']->get('id_asset_left')) ? 'null' : $values['Character']->get('id_asset_left') ?>,
	"assetLeftUrl": <?php  echo !is_null($values['Character']->getAsset('left')) ? '"'.urlencode($values['Character']->getAsset('left')->getUrl()).'"' : 'null' ?>,
	"idAssetRight": <?php echo is_null($values['Character']->get('id_asset_right')) ? 'null' : $values['Character']->get('id_asset_right') ?>,
	"assetRightUrl": <?php echo !is_null($values['Character']->getAsset('right')) ? '"'.urlencode($values['Character']->getAsset('right')->getUrl()).'"' : 'null' ?>,
	"type": <?php echo $values['Character']->get('type') ?>,
	"health": <?php echo is_null($values['Character']->get('health')) ? 'null' : $values['Character']->get('health') ?>,
	"attack": <?php echo is_null($values['Character']->get('attack')) ? 'null' : $values['Character']->get('attack') ?>,
	"defense": <?php echo is_null($values['Character']->get('defense')) ? 'null' : $values['Character']->get('defense') ?>,
	"speed": <?php echo is_null($values['Character']->get('speed')) ? 'null' : $values['Character']->get('speed') ?>,
	"dropIdItem": <?php echo is_null($values['Character']->get('drop_id_item')) ? 'null' : $values['Character']->get('drop_id_item') ?>,
	"dropAssetUrl": <?php  echo !is_null($values['Character']->getAsset('drop')) ? '"'.urlencode($values['Character']->getAsset('drop')->getUrl()).'"' : 'null' ?>,
	"dropChance": <?php echo is_null($values['Character']->get('drop_chance')) ? 'null' : $values['Character']->get('drop_chance') ?>,
	"respawn": <?php echo is_null($values['Character']->get('respawn')) ? 'null' : $values['Character']->get('respawn') ?>,
	"framesUp": [
<?php foreach ($values['Character']->getFrames('up') as $j => $character_frame): ?>
		{
			"id": <?php echo $character_frame->get('id') ?>,
			"idAsset": <?php echo $character_frame->get('id_asset') ?>,
			"assetUrl": "<?php echo urlencode($character_frame->getAsset()->getUrl()) ?>",
			"orientation": "<?php echo $character_frame->get('orientation') ?>",
			"order": <?php echo $character_frame->get('order') ?>
		}<?php if ($j<count($values['Character']->getFrames('up'))-1): ?>,<?php endif ?>
<?php endforeach ?>
	],
	"framesDown": [
<?php foreach ($values['Character']->getFrames('down') as $j => $character_frame): ?>
		{
			"id": <?php echo $character_frame->get('id') ?>,
			"idAsset": <?php echo $character_frame->get('id_asset') ?>,
			"assetUrl": "<?php echo urlencode($character_frame->getAsset()->getUrl()) ?>",
			"orientation": "<?php echo $character_frame->get('orientation') ?>",
			"order": <?php echo $character_frame->get('order') ?>
		}<?php if ($j<count($values['Character']->getFrames('down'))-1): ?>,<?php endif ?>
<?php endforeach ?>
	],
	"framesLeft": [
<?php foreach ($values['Character']->getFrames('left') as $j => $character_frame): ?>
		{
			"id": <?php echo $character_frame->get('id') ?>,
			"idAsset": <?php echo $character_frame->get('id_asset') ?>,
			"assetUrl": "<?php echo urlencode($character_frame->getAsset()->getUrl()) ?>",
			"orientation": "<?php echo $character_frame->get('orientation') ?>",
			"order": <?php echo $character_frame->get('order') ?>
		}<?php if ($j<count($values['Character']->getFrames('left'))-1): ?>,<?php endif ?>
<?php endforeach ?>
	],
	"framesRight": [
<?php foreach ($values['Character']->getFrames('right') as $j => $character_frame): ?>
		{
			"id": <?php echo $character_frame->get('id') ?>,
			"idAsset": <?php echo $character_frame->get('id_asset') ?>,
			"assetUrl": "<?php echo urlencode($character_frame->getAsset()->getUrl()) ?>",
			"orientation": "<?php echo $character_frame->get('orientation') ?>",
			"order": <?php echo $character_frame->get('order') ?>
		}<?php if ($j<count($values['Character']->getFrames('right'))-1): ?>,<?php endif ?>
<?php endforeach ?>
	],
	"narratives": [
<?php foreach ($values['Character']->getNarratives() as $j => $narrative): ?>
		{
			"id": <?php echo $narrative->get('id') ?>,
			"dialog": "<?php echo urlencode($narrative->get('dialog')) ?>",
			"order": <?php echo $narrative->get('order') ?>
		}<?php if ($j<count($values['Character']->getNarratives())-1): ?>,<?php endif ?>
<?php endforeach ?>
	]
}
<?php endif ?>
