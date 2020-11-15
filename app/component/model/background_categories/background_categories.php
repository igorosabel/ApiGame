<?php foreach ($values['list'] as $i => $background_category): ?>
	{
		"id": <?php echo $background_category->get('id') ?>,
		"name": "<?php echo urlencode($background_category->get('name')) ?>"
	}<?php if ($i<count($values['list'])-1): ?>,<?php endif ?>
<?php endforeach ?>