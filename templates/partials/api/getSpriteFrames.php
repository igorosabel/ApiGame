<?php foreach ($values['frames'] as $i => $fr): ?>
  {
    "id": <?php echo $fr->get('id') ?>,
    "file": "<?php echo urlencode($fr->get('file')) ?>",
    "url": "<?php echo urlencode($fr->getUrl()) ?>"
  }<?php if ($i<count($values['frames'])-1): ?>,<?php endif ?>
<?php endforeach ?>