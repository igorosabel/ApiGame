{
<?php foreach ($values['pickables'] as $i => $int): ?>
  int_<?php echo $int->get('id') ?>:{
    id: <?php echo $int->get('id') ?>,
    name: "<?php echo $int->get('name') ?>",
    type: <?php echo $int->get('type') ?>
  }<?php if ($i<count($values['pickables'])-1): ?>,<?php endif ?>
<?php endforeach ?>
}