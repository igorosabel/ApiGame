<style type="text/css" id="backgrounds-css">
<?php foreach ($values['backgrounds'] as $bckc): ?>
<?php foreach ($bckc->getBackgrounds() as $bck): ?>
	.<?php echo $bck->get('file') ?>{
		background: url('/assets/background/<?php echo $bckc->get('slug') ?>/<?php echo $bck->get('file') ?>.png') no-repeat center center transparent;
		background-size: 100% 100% !important;
	}
<?php endforeach ?>
<?php endforeach ?>
</style>