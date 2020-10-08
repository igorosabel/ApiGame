<?php foreach ($values['list'] as $i => $sce): ?>
{
	"id": <?php echo $sce->get('id') ?>,
	"idWorld": <?php echo $sce->get('id_world') ?>,
	"name": "<?php echo urlencode($sce->get('name')) ?>",
	"start_x": <?php echo (!is_null($sce->get('start_x'))) ? $sce->get('start_x') : 'null' ?>,
	"start_y": <?php echo (!is_null($sce->get('start_y'))) ? $sce->get('start_y') : 'null' ?>,
	"initial": <?php echo ($sce->get('initial')) ? 'true' : 'false' ?>,
	"friendly": <?php echo ($sce->get('friendly')) ? 'true' : 'false' ?>
}<?php if ($i<count($values['list'])-1): ?>,<?php endif ?>
<?php endforeach ?>