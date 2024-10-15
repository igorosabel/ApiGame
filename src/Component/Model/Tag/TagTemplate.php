<?php if (is_null($tag)): ?>
null
<?php else: ?>
{
	"id": <?php echo $tag->get('id') ?>,
	"name": "<?php echo urlencode($tag->get('name')) ?>"
}
<?php endif ?>
