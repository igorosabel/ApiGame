<?php if (is_null($scenario)): ?>
null
<?php else: ?>
{
	"id": <?php echo $scenario->get('id') ?>,
	"idWorld": <?php echo $scenario->get('id_world') ?>,
	"name": "<?php echo urlencode($scenario->get('name')) ?>",
	"startX": <?php echo is_null($scenario->get('start_x')) ? 'null' : $scenario->get('start_x') ?>,
	"startY": <?php echo is_null($scenario->get('start_y')) ? 'null' : $scenario->get('start_y') ?>,
	"initial": <?php echo $scenario->get('initial') ? 'true' : 'false' ?>,
	"friendly": <?php echo $scenario->get('friendly') ? 'true' : 'false' ?>
}
<?php endif ?>
