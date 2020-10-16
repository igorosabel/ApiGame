<?php foreach ($values['list'] as $i => $scenario_object): ?>
	{
		"id": <?php echo $scenario_object->get('id') ?>,
		"name": "<?php echo urlencode($scenario_object->get('name')) ?>",
		"idAsset": <?php echo $scenario_object->get('id_asset') ?>,
		"assetUrl": "<?php echo urlencode($scenario_object->getAsset()->getUrl()) ?>",
		"width": <?php echo $scenario_object->get('width') ?>,
		"height": <?php echo $scenario_object->get('width') ?>,
		"crossable": <?php echo $scenario_object->get('crossable') ? 'true' : 'false' ?>,
		"activable": <?php echo $scenario_object->get('activable') ? 'true' : 'false' ?>,
		"idAssetActive": <?php echo $scenario_object->get('id_asset_active') ?>,
		"assetActiveUrl": "<?php echo urlencode($scenario_object->getAssetActive()->getUrl()) ?>",
		"activeTime": <?php echo $scenario_object->get('active_time') ?>,
		"activeTrigger": <?php echo $scenario_object->get('active_trigger') ?>,
		"activeTriggerCustom": "<?php echo urlencode($scenario_object->get('active_trigger_custom')) ?>",
		"pickable": <?php echo $scenario_object->get('pickable') ? 'true' : 'false' ?>,
		"grabbable": <?php echo $scenario_object->get('grabbable') ? 'true' : 'false' ?>,
		"breakable": <?php echo $scenario_object->get('breakable') ? 'true' : 'false' ?>,
		"drops": [
<?php foreach ($scenario_object->getDrops() as $j => $scenario_object_drop): ?>
			{
				"id": <?php echo $scenario_object_drop->get('id') ?>,
				"idAsset": <?php echo $scenario_object_drop->get('id_asset') ?>,
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