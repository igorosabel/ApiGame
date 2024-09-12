<?php if (is_null($values['Item'])): ?>
null
<?php else: ?>
{
	"id": <?php echo $values['Item']->get('id') ?>,
	"type": <?php echo $values['Item']->get('type') ?>,
	"idAsset": <?php echo $values['Item']->get('id_asset') ?>,
	"assetUrl": "<?php echo urlencode($values['Item']->getAsset()->getUrl()) ?>",
	"name": "<?php echo urlencode($values['Item']->get('name')) ?>",
	"money": <?php echo is_null($values['Item']->get('money')) ? 'null' : $values['Item']->get('money') ?>,
	"health": <?php echo is_null($values['Item']->get('health')) ? 'null' : $values['Item']->get('health') ?>,
	"attack": <?php echo is_null($values['Item']->get('attack')) ? 'null' : $values['Item']->get('attack') ?>,
	"defense": <?php echo is_null($values['Item']->get('defense')) ? 'null' : $values['Item']->get('defense') ?>,
	"speed": <?php echo is_null($values['Item']->get('speed')) ? 'null' : $values['Item']->get('speed') ?>,
	"wearable": <?php echo is_null($values['Item']->get('wearable')) ? 'null' : $values['Item']->get('wearable') ?>,
	"frames": [
	<?php foreach ($values['Item']->getFrames() as $j => $item_frame): ?>
		{
			"id": <?php echo $item_frame->get('id') ?>,
			"idAsset": <?php echo $item_frame->get('id_asset') ?>,
			"assetUrl": "<?php echo urlencode($item_frame->getAsset()->getUrl()) ?>",
			"order": <?php echo $item_frame->get('order') ?>
		}<?php if ($j<count($values['Item']->getFrames())-1): ?>,<?php endif ?>
	<?php endforeach ?>
	]
}
<?php endif ?>
