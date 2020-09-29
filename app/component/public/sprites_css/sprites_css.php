<style type="text/css" id="sprites-css">
<?php foreach ($values['sprites'] as $sprc): ?>
<?php foreach ($sprc->getSprites() as $spr): ?>
	.<?php echo $spr->get('file') ?>{
		background: url('/assets/sprite/<?php echo $sprc->get('slug') ?>/<?php echo $spr->get('file') ?>.png') no-repeat center center transparent;
		z-index: 1;
<?php if ($spr->get('width')>1 || $spr->get('height')>1): ?>
		position: absolute;
		width: <?php echo ($spr->get('width') * 100) ?>%;
		height: <?php echo ($spr->get('height') * 100) ?>%;
<?php endif ?>
	}
<?php endforeach ?>
<?php endforeach ?>
</style>