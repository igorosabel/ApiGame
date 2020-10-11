<?php foreach($values['list'] as $i => $item): ?>
	{
		"id": <?php echo $item->get('id') ?>,
		"type": <?php echo $item->get('type') ?>,
		"idAsset": <?php echo $item->get('id_asset') ?>,
		"assetUrl": "<?php echo urlencode($item->getAsset()->getUrl()) ?>",
		"name": "<?php echo urlencode($item->get('name')) ?>",
		"money": <?php echo $item->get('money') ?>,
		"health": <?php echo $item->get('health') ?>,
		"attack": <?php echo $item->get('attack') ?>,
		"defense": <?php echo $item->get('defense') ?>,
		"speed": <?php echo $item->get('speed') ?>,
		"wearable": <?php echo $item->get('wearable') ?>
	}<?php if ($i<count($values['list'])-1): ?>,<?php endif ?>
<?php endforeach ?>