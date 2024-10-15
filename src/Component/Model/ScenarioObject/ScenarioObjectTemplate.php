<?php if (is_null($scenarioobject)): ?>
null
<?php else: ?>
{
	"id": <?php echo $scenarioobject->get('id') ?>,
	"name": "<?php echo urlencode($scenarioobject->get('name')) ?>",
	"idAsset": <?php echo $scenarioobject->get('id_asset') ?>,
	"assetUrl": "<?php echo urlencode($scenarioobject->getAsset()->getUrl()) ?>",
	"width": <?php echo $scenarioobject->get('width') ?>,
	"blockWidth": <?php echo is_null($scenarioobject->get('block_width')) ? 'null' : $scenarioobject->get('block_width') ?>,
	"height": <?php echo $scenarioobject->get('height') ?>,
	"blockHeight": <?php echo is_null($scenarioobject->get('block_height')) ? 'null' : $scenarioobject->get('block_height') ?>,
	"crossable": <?php echo $scenarioobject->get('crossable') ? 'true' : 'false' ?>,
	"activable": <?php echo $scenarioobject->get('activable') ? 'true' : 'false' ?>,
	"idAssetActive": <?php echo is_null($scenarioobject->get('id_asset_active')) ? 'null' : $scenarioobject->get('id_asset_active') ?>,
	"assetActiveUrl": <?php echo !is_null($scenarioobject->getAssetActive()) ? '"'.urlencode($scenarioobject->getAssetActive()->getUrl()).'"' : 'null' ?>,
	"activeTime": <?php echo is_null($scenarioobject->get('active_time')) ? 'null' : $scenarioobject->get('active_time') ?>,
	"activeTrigger": <?php echo is_null($scenarioobject->get('active_trigger')) ? 'null' : $scenarioobject->get('active_trigger') ?>,
	"activeTriggerCustom": "<?php echo is_null($scenarioobject->get('active_trigger_custom')) ? 'null' : urlencode($scenarioobject->get('active_trigger_custom')) ?>",
	"pickable": <?php echo $scenarioobject->get('pickable') ? 'true' : 'false' ?>,
	"grabbable": <?php echo $scenarioobject->get('grabbable') ? 'true' : 'false' ?>,
	"breakable": <?php echo $scenarioobject->get('breakable') ? 'true' : 'false' ?>,
	"drops": [
<?php foreach ($scenarioobject->getDrops() as $j => $scenario_object_drop): ?>
		{
			"id": <?php echo $scenario_object_drop->get('id') ?>,
			"idItem": <?php echo $scenario_object_drop->get('id_item') ?>,
			"itemName": "<?php echo urlencode($scenario_object_drop->getItem()->get('name')) ?>",
			"assetUrl": "<?php echo urlencode($scenario_object_drop->getItem()->getAsset()->getUrl()) ?>",
			"num": <?php echo $scenario_object_drop->get('num') ?>
		}<?php if ($j<count($scenarioobject->getDrops())-1): ?>,<?php endif ?>
<?php endforeach ?>
	],
	"frames": [
<?php foreach ($scenarioobject->getFrames() as $j => $scenario_object_frame): ?>
		{
			"id": <?php echo $scenario_object_frame->get('id') ?>,
			"idAsset": <?php echo $scenario_object_frame->get('id_asset') ?>,
			"assetUrl": "<?php echo urlencode($scenario_object_frame->getAsset()->getUrl()) ?>",
			"order": <?php echo $scenario_object_frame->get('order') ?>
		}<?php if ($j<count($scenarioobject->getFrames())-1): ?>,<?php endif ?>
<?php endforeach ?>
	]
}
<?php endif ?>
