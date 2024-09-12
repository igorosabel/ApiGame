<?php if (is_null($values['Scenario'])): ?>
null
<?php else: ?>
{
	"id": <?php echo $values['Scenario']->get('id') ?>,
	"idWorld": <?php echo $values['Scenario']->get('id_world') ?>,
	"name": "<?php echo urlencode($values['Scenario']->get('name')) ?>",
	"startX": <?php echo is_null($values['Scenario']->get('start_x')) ? 'null' : $values['Scenario']->get('start_x') ?>,
	"startY": <?php echo is_null($values['Scenario']->get('start_y')) ? 'null' : $values['Scenario']->get('start_y') ?>,
	"initial": <?php echo $values['Scenario']->get('initial') ? 'true' : 'false' ?>,
	"friendly": <?php echo $values['Scenario']->get('friendly') ? 'true' : 'false' ?>
}
<?php endif ?>
