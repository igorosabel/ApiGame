<?php foreach ($values['list'] as $i => $game): ?>
	{
		"id": <?php echo $game->get('id') ?>,
		"name": <?php echo !is_null($game->get('name')) ? '"'.urlencode($game->get('name')).'"' : 'null' ?>,
		"idScenario": <?php echo !is_null($game->get('id_scenario')) ? $game->get('id_scenario') : 'null' ?>,
		"positionX": <?php echo !is_null($game->get('position_x')) ? $game->get('position_x') : 'null' ?>,
		"positionY": <?php echo !is_null($game->get('position_y')) ? $game->get('position_y') : 'null' ?>,
		"money": <?php echo $game->get('money') ?>,
		"health": <?php echo $game->get('health') ?>,
		"maxHealth": <?php echo $game->get('max_health') ?>,
		"attack": <?php echo $game->get('attack') ?>,
		"defense": <?php echo $game->get('defense') ?>,
		"speed": <?php echo $game->get('speed') ?>
	}<?php if ($i<count($values['list'])-1): ?>,<?php endif ?>
<?php endforeach ?>