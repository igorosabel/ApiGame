<?php foreach($list as $i => $blocker): ?>
	{
		"x": <?php echo $blocker['x'] ?>,
		"y": <?php echo $blocker['y'] ?>
	}<?php if ($i < count($list) - 1): ?>,<?php endif ?>
<?php endforeach ?>
