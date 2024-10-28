<?php if (is_null($tag)): ?>
null
<?php else: ?>
{
	"id": <?php echo $tag->id ?>,
	"name": "<?php echo urlencode($tag->name) ?>"
}
<?php endif ?>
