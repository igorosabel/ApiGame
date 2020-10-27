<?php foreach ($values['list'] as $i => $scenario_object): ?>
	{
		"id": <?php echo $scenario_object->get('id') ?>,
		"name": "<?php echo urlencode($scenario_object->get('name')) ?>",
		"idAsset": <?php echo $scenario_object->get('id_asset') ?>,
		"assetUrl": "<?php echo urlencode($scenario_object->getAsset()->getUrl()) ?>",
		"width": <?php echo $scenario_object->get('width') ?>,
		"blockWidth": <?php echo !is_null($scenario_object->get('block_width')) ? $scenario_object->get('block_width') : 'null' ?>,
		"height": <?php echo $scenario_object->get('width') ?>,
		"blockHeight": <?php echo !is_null($scenario_object->get('block_height')) ? $scenario_object->get('block_height') : 'null' ?>,
		"crossable": <?php echo $scenario_object->get('crossable') ? 'true' : 'false' ?>,
		"activable": <?php echo $scenario_object->get('activable') ? 'true' : 'false' ?>,
		"idAssetActive": <?php echo !is_null($scenario_object->get('id_asset_active')) ? $scenario_object->get('id_asset_active') : 'null' ?>,
		"assetActiveUrl": <?php echo !is_null($scenario_object->getAssetActive()) ? '"'.urlencode($scenario_object->getAssetActive()->getUrl()).'"' : 'null' ?>,
		"activeTime": <?php echo !is_null($scenario_object->get('active_time')) ? $scenario_object->get('active_time') : 'null' ?>,
		"activeTrigger": <?php echo !is_null($scenario_object->get('active_trigger')) ? $scenario_object->get('active_trigger') : 'null' ?>,
		"activeTriggerCustom": "<?php echo !is_null($scenario_object->get('active_trigger_custom')) ? urlencode($scenario_object->get('active_trigger_custom')) : 'null' ?>",
		"pickable": <?php echo $scenario_object->get('pickable') ? 'true' : 'false' ?>,
		"grabbable": <?php echo $scenario_object->get('grabbable') ? 'true' : 'false' ?>,
		"breakable": <?php echo $scenario_object->get('breakable') ? 'true' : 'false' ?>,
		"drops": [
<?php foreach ($scenario_object->getDrops() as $j => $scenario_object_drop): ?>
			{
				"id": <?php echo $scenario_object_drop->get('id') ?>,
				"idItem": <?php echo $scenario_object_drop->get('id_item') ?>,
				"itemName": "<?php echo urlencode($scenario_object_drop->getItem()->get('name')) ?>",
				"assetUrl": "<?php echo urlencode($scenario_object_drop->getItem()->getAsset()->getUrl()) ?>",
				"num": <?php echo $scenario_object_drop->get('num') ?>
			}<?php if ($j<count($scenario_object->getDrops())-1): ?>,<?php endif ?>
<?php endforeach ?>
		],
		"frames": [
<?php foreach ($scenario_object->getFrames() as $j => $scenario_object_frame): ?>
			{
				"id": <?php echo $scenario_object_frame->get('id') ?>,
				"idAsset": <?php echo $scenario_object_frame->get('id_asset') ?>,
				"assetUrl": "<?php echo urlencode($scenario_object_frame->getAsset()->getUrl()) ?>",
				"order": <?php echo $scenario_object_frame->get('order') ?>
			}<?php if ($j<count($scenario_object->getFrames())-1): ?>,<?php endif ?>
<?php endforeach ?>
		]
	}<?php if ($i<count($values['list'])-1): ?>,<?php endif ?>
<?php endforeach ?>