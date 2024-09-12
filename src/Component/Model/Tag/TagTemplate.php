<?php if (is_null($values['Tag'])): ?>
null
<?php else: ?>
{
	"id": <?php echo $values['Tag']->get('id') ?>,
	"name": "<?php echo urlencode($values['Tag']->get('name')) ?>"
}
<?php endif ?>
