<?php if (is_null($world)): ?>
null
<?php else: ?>
{
	"id": <?php echo $world->get('id') ?>,
	"name": "<?php echo urlencode($world->get('name')) ?>",
	"description": "<?php echo is_null($world->get('description')) ? 'null' : urlencode($world->get('description')) ?>",
	"wordOne": "<?php echo urlencode($world->get('word_one')) ?>",
	"wordTwo": "<?php echo urlencode($world->get('word_two')) ?>",
	"wordThree": "<?php echo urlencode($world->get('word_three')) ?>",
	"friendly": <?php echo $world->get('friendly') ? 'true' : 'false' ?>
}
<?php endif ?>
