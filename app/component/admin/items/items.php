<?php foreach($values['list'] as $i => $item): ?>
	{
		"id": <?php echo $item->get('id') ?>,
		"type": <?php echo $item->get('type') ?>,
		"idAsset": <?php echo $item->get('id_asset') ?>,
		"assetUrl": "<?php echo urlencode($item->getAsset()->getUrl()) ?>",
		"name": "<?php echo urlencode($item->get('name')) ?>",
		"money": <?php echo is_null($item->get('money')) ? 'null' : $item->get('money') ?>,
		"health": <?php echo is_null($item->get('health')) ? 'null' : $item->get('health') ?>,
		"attack": <?php echo is_null($item->get('attack')) ? 'null' : $item->get('attack') ?>,
		"defense": <?php echo is_null($item->get('defense')) ? 'null' : $item->get('defense') ?>,
		"speed": <?php echo is_null($item->get('speed')) ? 'null' : $item->get('speed') ?>,
		"wearable": <?php echo is_null($item->get('wearable')) ? 'null' : $item->get('wearable') ?>,
		"frames": [
<?php foreach ($item->getFrames() as $j => $item_frame): ?>
			{
				"id": <?php echo $item_frame->get('id') ?>,
				"idAsset": <?php echo $item_frame->get('id_asset') ?>,
				"assetUrl": "<?php echo urlencode($item_frame->getAsset()->getUrl()) ?>",
				"order": <?php echo $item_frame->get('order') ?>
			}<?php if ($j<count($item->getFrames())-1): ?>,<?php endif ?>
<?php endforeach ?>
		]
	}<?php if ($i<count($values['list'])-1): ?>,<?php endif ?>
<?php endforeach ?>