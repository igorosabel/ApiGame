<?php foreach ($values['list'] as $i => $tag): ?>
	{
		"id": <?php echo $tag->get('id') ?>,
		"name": "<?php echo urlencode($tag->get('name')) ?>"
	}<?php if ($i<count($values['list'])-1): ?>,<?php endif ?>
<?php endforeach ?>