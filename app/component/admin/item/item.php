{
	"id": <?php echo $values['item']->get('id') ?>,
	"type": <?php echo $values['item']->get('type') ?>,
	"idAsset": <?php echo $values['item']->get('id_asset') ?>,
	"assetUrl": "<?php echo urlencode($values['item']->getAsset()->getUrl()) ?>",
	"name": "<?php echo urlencode($values['item']->get('name')) ?>",
	"money": <?php echo is_null($values['item']->get('money')) ? 'null' : $values['item']->get('money') ?>,
	"health": <?php echo is_null($values['item']->get('health')) ? 'null' : $values['item']->get('health') ?>,
	"attack": <?php echo is_null($values['item']->get('attack')) ? 'null' : $values['item']->get('attack') ?>,
	"defense": <?php echo is_null($values['item']->get('defense')) ? 'null' : $values['item']->get('defense') ?>,
	"speed": <?php echo is_null($values['item']->get('speed')) ? 'null' : $values['item']->get('speed') ?>,
	"wearable": <?php echo is_null($values['item']->get('wearable')) ? 'null' : $values['item']->get('wearable') ?>,
	"frames": [
	<?php foreach ($values['item']->getFrames() as $j => $item_frame): ?>
		{
			"id": <?php echo $item_frame->get('id') ?>,
			"idAsset": <?php echo $item_frame->get('id_asset') ?>,
			"assetUrl": "<?php echo urlencode($item_frame->getAsset()->getUrl()) ?>",
			"order": <?php echo $item_frame->get('order') ?>
		}<?php if ($j<count($values['item']->getFrames())-1): ?>,<?php endif ?>
	<?php endforeach ?>
	]
}