<style type="text/css" id="sprites-css">
<?php foreach ($values['sprites'] as $sprc): ?>
<?php foreach ($sprc->getSprites() as $spr): ?>
  .<?php echo $spr->get('file') ?>{
    background: url('/assets/sprite/<?php echo Base::slugify($sprc->get('name')) ?>/<?php echo $spr->get('file') ?>.png') no-repeat center center transparent;
  }
<?php endforeach ?>
<?php endforeach ?>  
</style>