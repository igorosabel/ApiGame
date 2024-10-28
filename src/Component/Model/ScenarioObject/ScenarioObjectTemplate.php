<?php if (is_null($scenarioobject)): ?>
null
<?php else: ?>
{
	"id": <?php echo $scenarioobject->id ?>,
	"name": "<?php echo urlencode($scenarioobject->name) ?>",
	"idAsset": <?php echo $scenarioobject->id_asset ?>,
	"assetUrl": "<?php echo urlencode($scenarioobject->getAsset()->getUrl()) ?>",
	"width": <?php echo $scenarioobject->width ?>,
	"blockWidth": <?php echo is_null($scenarioobject->block_width) ? 'null' : $scenarioobject->block_width ?>,
	"height": <?php echo $scenarioobject->height ?>,
	"blockHeight": <?php echo is_null($scenarioobject->block_height) ? 'null' : $scenarioobject->block_height ?>,
	"crossable": <?php echo $scenarioobject->crossable ? 'true' : 'false' ?>,
	"activable": <?php echo $scenarioobject->activable ? 'true' : 'false' ?>,
	"idAssetActive": <?php echo is_null($scenarioobject->id_asset_active) ? 'null' : $scenarioobject->id_asset_active ?>,
	"assetActiveUrl": <?php echo !is_null($scenarioobject->getAssetActive()) ? '"'.urlencode($scenarioobject->getAssetActive()->getUrl()).'"' : 'null' ?>,
	"activeTime": <?php echo is_null($scenarioobject->active_time) ? 'null' : $scenarioobject->active_time ?>,
	"activeTrigger": <?php echo is_null($scenarioobject->active_trigger) ? 'null' : $scenarioobject->active_trigger ?>,
	"activeTriggerCustom": "<?php echo is_null($scenarioobject->active_trigger_custom) ? 'null' : urlencode($scenarioobject->active_trigger_custom) ?>",
	"pickable": <?php echo $scenarioobject->pickable ? 'true' : 'false' ?>,
	"grabbable": <?php echo $scenarioobject->grabbable ? 'true' : 'false' ?>,
	"breakable": <?php echo $scenarioobject->breakable ? 'true' : 'false' ?>,
	"drops": [
<?php foreach ($scenarioobject->getDrops() as $j => $scenario_object_drop): ?>
		{
			"id": <?php echo $scenario_object_drop->id ?>,
			"idItem": <?php echo $scenario_object_drop->id_item ?>,
			"itemName": "<?php echo urlencode($scenario_object_drop->getItem()->name) ?>",
			"assetUrl": "<?php echo urlencode($scenario_object_drop->getItem()->getAsset()->getUrl()) ?>",
			"num": <?php echo $scenario_object_drop->num ?>
		}<?php if ($j < count($scenarioobject->getDrops()) - 1): ?>,<?php endif ?>
<?php endforeach ?>
	],
	"frames": [
<?php foreach ($scenarioobject->getFrames() as $j => $scenario_object_frame): ?>
		{
			"id": <?php echo $scenario_object_frame->id ?>,
			"idAsset": <?php echo $scenario_object_frame->id_asset ?>,
			"assetUrl": "<?php echo urlencode($scenario_object_frame->getAsset()->getUrl()) ?>",
			"order": <?php echo $scenario_object_frame->order ?>
		}<?php if ($j < count($scenarioobject->getFrames()) - 1): ?>,<?php endif ?>
<?php endforeach ?>
	]
}
<?php endif ?>
