<?php foreach ($values['scenarios'] as $sce): ?>
	<option value="<?php echo $sce->get('id') ?>">
		<?php echo $sce->get('name') ?>
	</option>
<?php endforeach ?>