<?php foreach ($values['list'] as $i => $connection): ?>
	{
		"from": <?php echo $connection->get('id_from') ?>,
		"fromName": "<?php echo urlencode($connection->getFrom()->get('name')) ?>",
		"to": <?php echo $connection->get('id_to') ?>,
		"toName": "<?php echo urlencode($connection->getTo()->get('name')) ?>",
		"orientation": "<?php echo $connection->get('orientation') ?>"
	}<?php if ($i<count($values['list'])-1): ?>,<?php endif ?>
<?php endforeach ?>