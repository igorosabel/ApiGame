<?php foreach ($values['scenarios'] as $sce): ?>
  <li><a href="/edit/<?php echo $sce->get('id') ?>/<?php echo Base::slugify($sce->get('name')) ?>"><?php echo $sce->get('name') ?></a></li>
<?php endforeach ?>