<?php foreach ($values['list'] as $tag): ?>
	<option value="<?php echo $tag->get('id') ?>"><?php echo $tag->get('name') ?></option>
<?php endforeach ?>