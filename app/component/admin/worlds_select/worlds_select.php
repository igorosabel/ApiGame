<?php foreach ($values['list'] as $world): ?>
	<option value="<?php echo $world->get('id') ?>"><?php echo $world->get('name') ?></option>
<?php endforeach ?>