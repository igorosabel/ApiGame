{
<?php foreach($values['sprites'] as $i => $sprc): ?>
<?php foreach ($sprc->getSprites() as $j => $spr): ?>
  spr_<?php echo $spr->get('id') ?>:{
    id: <?php echo $spr->get('id') ?>,
    name: "<?php echo $spr->get('name') ?>",
    url: "<?php echo $spr->getUrl() ?>"
  }
  <?php if ( ($i<count($values['sprites'])-1) || ($j<count($sprc->getSprites())-1) ): ?>,<?php endif ?>
<?php endforeach ?>
<?php endforeach ?>
}