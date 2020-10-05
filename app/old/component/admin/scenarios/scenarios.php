<?php foreach ($values['scenarios'] as $sce): ?>
	<li>
		<a href="<?php echo OUrl::generateUrl('admin', 'editScenario', ['id' => $sce->get('id'), 'slug' => OTools::slugify($sce->get('name'))]) ?>">
			<?php echo $sce->get('name') ?>
		</a>
	</li>
<?php endforeach ?>