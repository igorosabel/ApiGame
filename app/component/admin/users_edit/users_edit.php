<?php foreach ($values['users'] as $usr): ?>
<div class="usr-item" id="usr-<?php echo $usr->get('id') ?>" data-id="<?php echo $usr->get('id') ?>">
	<div class="usr-header">
		<img src="/img/closed.svg" class="usr-deploy">
		<span><?php echo $usr->get('email') ?></span>
		<img src="/img/delete.svg" class="usr-btn usr-delete" title="Borrar usuario">
		<img src="/img/edit.svg" class="usr-btn usr-edit" title="Editar usuario">
	</div>
	<div class="usr-games">
		<?php foreach ($usr->getGames() as $i => $gam): ?>
		<div class="usr-game" id="gam-<?php echo $gam->get('id') ?>" data-id="<?php echo $gam->get('id') ?>">
			<div class="usr-game-order"><?php echo ($i+1) ?></div>
			<div class="usr-game-none<?php if (!$gam->get('name')): ?> usr-game-show<?php endif ?>">No hay partida</div>
			<div class="usr-game-data<?php if ($gam->get('name')): ?> usr-game-show<?php endif ?>">
				<div class="usr-game-name"><?php echo $gam->get('name') ?></div>
				<div class="usr-game-options">
					<img src="/img/edit.svg" class="obj-game-edit" title="Editar partida">
					<img src="/img/delete.svg" class="obj-game-delete" title="Borrar partida">
				</div>
				<div class="usr-game-scenario">
					<span class="usr-game-scenario-name" data-id="<?php echo $gam->get('id_scenario') ?>">
						<?php echo $gam->getScenario()->get('name') ?>
					</span>
					<span class="usr-game-scenario-position" data-position="<?php echo $gam->get('position_x') ?>-<?php echo $gam->get('position_y') ?>">
						(<?php echo $gam->get('position_x') ?>,<?php echo $gam->get('position_y') ?>)
					</span>
				</div>
			</div>
		</div>
		<?php endforeach ?>
	</div>
</div>
<?php endforeach ?>