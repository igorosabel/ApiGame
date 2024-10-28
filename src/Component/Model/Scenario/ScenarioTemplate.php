<?php if (is_null($scenario)): ?>
null
<?php else: ?>
{
	"id": <?php echo $scenario->id ?>,
	"idWorld": <?php echo $scenario->id_world ?>,
	"name": "<?php echo urlencode($scenario->name) ?>",
	"startX": <?php echo is_null($scenario->start_x) ? 'null' : $scenario->start_x ?>,
	"startY": <?php echo is_null($scenario->start_y) ? 'null' : $scenario->start_y ?>,
	"initial": <?php echo $scenario->initial ? 'true' : 'false' ?>,
	"friendly": <?php echo $scenario->friendly ? 'true' : 'false' ?>
}
<?php endif ?>
