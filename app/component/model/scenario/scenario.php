{
	"id": <?php echo $values['sce']->get('id') ?>,
	"idWorld": <?php echo (!is_null($values['sce']->get('id_world'))) ? $values['sce']->get('id_world') : 'null' ?>,
	"name": "<?php echo (!is_null($values['sce']->get('name'))) ? urlencode($values['sce']->get('name')) : 'null' ?>",
	"startX": <?php echo (!is_null($values['sce']->get('start_x'))) ? $values['sce']->get('start_x') : 'null' ?>,
	"startY": <?php echo (!is_null($values['sce']->get('start_y'))) ? $values['sce']->get('start_y') : 'null' ?>,
	"initial": <?php echo ($values['sce']->get('initial')) ? 'true' : 'false' ?>,
	"friendly": <?php echo ($values['sce']->get('friendly')) ? 'true' : 'false' ?>
}