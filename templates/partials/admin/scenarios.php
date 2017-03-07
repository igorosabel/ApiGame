<?php foreach ($values['scenarios'] as $sce): ?>
  <li><a href="<?php echo OUrl::generateUrl('editScenario',array('id'=>$sce->get('id'),'slug'=>Base::slugify($sce->get('name')))) ?>"><?php echo $sce->get('name') ?></a></li>
<?php endforeach ?>