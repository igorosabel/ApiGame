<style type="text/css" id="sprites-css">
<?php foreach ($values['sprites'] as $sprc): ?>
<?php foreach ($sprc->getSprites() as $spr): ?>
  .<?php echo $spr->get('class') ?>{
    <?php echo $spr->get('css') ?>
  }
<?php endforeach ?>
<?php endforeach ?>  
</style>