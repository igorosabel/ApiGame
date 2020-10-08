<?php foreach ($values['list'] as $i => $world): ?>
	{
		"id": <?php echo $world->get('id') ?>,
		"name": "<?php echo urlencode($world->get('name')) ?>",
		"description": <?php echo (!is_null($world->get('description'))) ? '"'.urlencode($world->get('description')).'"' : 'null' ?>,
		"wordOne": "<?php echo urlencode($world->get('word_one')) ?>",
		"wordTwo": "<?php echo urlencode($world->get('word_two')) ?>",
		"wordThree": "<?php echo urlencode($world->get('word_three')) ?>",
		"friendly": <?php echo $world->get('friendly') ? 'true' : 'false' ?>
	}<?php if ($i<count($values['list'])-1): ?>,<?php endif ?>
<?php endforeach ?>