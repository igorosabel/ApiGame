<?php if (is_null($world)): ?>
null
<?php else: ?>
{
	"id": <?php echo $world->id ?>,
	"name": "<?php echo urlencode($world->name) ?>",
	"description": "<?php echo is_null($world->description) ? 'null' : urlencode($world->description) ?>",
	"wordOne": "<?php echo urlencode($world->word_one) ?>",
	"wordTwo": "<?php echo urlencode($world->word_two) ?>",
	"wordThree": "<?php echo urlencode($world->word_three) ?>",
	"friendly": <?php echo $world->friendly ? 'true' : 'false' ?>
}
<?php endif ?>
