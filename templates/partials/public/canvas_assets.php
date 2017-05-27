<?php foreach ($values['assets'] as $i => $asset): ?>
    {
      type: '<?php echo $asset['type'] ?>',
      x: <?php echo $asset['x'] ?>,
      y: <?php echo $asset['y'] ?>,
      id: <?php echo $asset['id'] ?>
    }<?php if ($i<count($values['assets'])-1): ?>,<?php endif ?>
<?php endforeach ?>
