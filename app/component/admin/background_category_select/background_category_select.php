<?php foreach ($values['list'] as $bckcat): ?>
	<option value="<?php echo $bckcat->get('id') ?>"><?php echo $bckcat->get('name') ?></option>
<?php endforeach ?>