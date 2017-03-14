<style type="text/css" id="backgrounds-css">
<?php foreach ($values['backgrounds'] as $bckc): ?>
<?php foreach ($bckc->getBackgrounds() as $bck): ?>
  .<?php echo $bck->get('class') ?>{
    <?php echo $bck->get('css') ?>
  }
<?php endforeach ?>
<?php endforeach ?>  
</style>