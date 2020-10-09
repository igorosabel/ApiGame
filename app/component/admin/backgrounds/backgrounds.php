<?php foreach ($values['list'] as $i => $background): ?>
	{
		"id": <?php echo $background->get('id') ?>,
		"idBackgroundCategory": <?php echo $background->get('id_background_category') ?>,
		"idAsset": <?php echo $background->get('id_asset') ?>,
		"assetUrl": "<?php echo urlencode($background->getAsset()->getUrl()) ?>",
		"name": "<?php echo urlencode($background->get('name')) ?>",
		"crossable": <?php echo ($background->get('crossable') ? 'true' : 'false') ?>
	}<?php if ($i<count($values['list'])-1): ?>,<?php endif ?>
<?php endforeach ?>