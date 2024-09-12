<?php if (is_null($values['World'])): ?>
null
<?php else: ?>
{
	"id": <?php echo $values['World']->get('id') ?>,
	"name": "<?php echo urlencode($values['World']->get('name')) ?>",
	"description": "<?php echo is_null($values['World']->get('description')) ? 'null' : urlencode($values['World']->get('description')) ?>",
	"wordOne": "<?php echo urlencode($values['World']->get('word_one')) ?>",
	"wordTwo": "<?php echo urlencode($values['World']->get('word_two')) ?>",
	"wordThree": "<?php echo urlencode($values['World']->get('word_three')) ?>",
	"friendly": <?php echo $values['World']->get('friendly') ? 'true' : 'false' ?>
}
<?php endif ?>
