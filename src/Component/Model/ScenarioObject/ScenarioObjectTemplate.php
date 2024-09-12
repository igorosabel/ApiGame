<?php if (is_null($values['ScenarioObject'])): ?>
null
<?php else: ?>
{
	"id": <?php echo $values['ScenarioObject']->get('id') ?>,
	"name": "<?php echo urlencode($values['ScenarioObject']->get('name')) ?>",
	"idAsset": <?php echo $values['ScenarioObject']->get('id_asset') ?>,
	"assetUrl": "<?php echo urlencode($values['ScenarioObject']->getAsset()->getUrl()) ?>",
	"width": <?php echo $values['ScenarioObject']->get('width') ?>,
	"blockWidth": <?php echo is_null($values['ScenarioObject']->get('block_width')) ? 'null' : $values['ScenarioObject']->get('block_width') ?>,
	"height": <?php echo $values['ScenarioObject']->get('height') ?>,
	"blockHeight": <?php echo is_null($values['ScenarioObject']->get('block_height')) ? 'null' : $values['ScenarioObject']->get('block_height') ?>,
	"crossable": <?php echo $values['ScenarioObject']->get('crossable') ? 'true' : 'false' ?>,
	"activable": <?php echo $values['ScenarioObject']->get('activable') ? 'true' : 'false' ?>,
	"idAssetActive": <?php echo is_null($values['ScenarioObject']->get('id_asset_active')) ? 'null' : $values['ScenarioObject']->get('id_asset_active') ?>,
	"assetActiveUrl": <?php echo !is_null($values['ScenarioObject']->getAssetActive()) ? '"'.urlencode($values['ScenarioObject']->getAssetActive()->getUrl()).'"' : 'null' ?>,
	"activeTime": <?php echo is_null($values['ScenarioObject']->get('active_time')) ? 'null' : $values['ScenarioObject']->get('active_time') ?>,
	"activeTrigger": <?php echo is_null($values['ScenarioObject']->get('active_trigger')) ? 'null' : $values['ScenarioObject']->get('active_trigger') ?>,
	"activeTriggerCustom": "<?php echo is_null($values['ScenarioObject']->get('active_trigger_custom')) ? 'null' : urlencode($values['ScenarioObject']->get('active_trigger_custom')) ?>",
	"pickable": <?php echo $values['ScenarioObject']->get('pickable') ? 'true' : 'false' ?>,
	"grabbable": <?php echo $values['ScenarioObject']->get('grabbable') ? 'true' : 'false' ?>,
	"breakable": <?php echo $values['ScenarioObject']->get('breakable') ? 'true' : 'false' ?>,
	"drops": [
<?php foreach ($values['ScenarioObject']->getDrops() as $j => $scenario_object_drop): ?>
		{
			"id": <?php echo $scenario_object_drop->get('id') ?>,
			"idItem": <?php echo $scenario_object_drop->get('id_item') ?>,
			"itemName": "<?php echo urlencode($scenario_object_drop->getItem()->get('name')) ?>",
			"assetUrl": "<?php echo urlencode($scenario_object_drop->getItem()->getAsset()->getUrl()) ?>",
			"num": <?php echo $scenario_object_drop->get('num') ?>
		}<?php if ($j<count($values['ScenarioObject']->getDrops())-1): ?>,<?php endif ?>
<?php endforeach ?>
	],
	"frames": [
<?php foreach ($values['ScenarioObject']->getFrames() as $j => $scenario_object_frame): ?>
		{
			"id": <?php echo $scenario_object_frame->get('id') ?>,
			"idAsset": <?php echo $scenario_object_frame->get('id_asset') ?>,
			"assetUrl": "<?php echo urlencode($scenario_object_frame->getAsset()->getUrl()) ?>",
			"order": <?php echo $scenario_object_frame->get('order') ?>
		}<?php if ($j<count($values['ScenarioObject']->getFrames())-1): ?>,<?php endif ?>
<?php endforeach ?>
	]
}
<?php endif ?>
