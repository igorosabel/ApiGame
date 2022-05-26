<?php if (is_null($values['backgroundcategory'])): ?>
null
<?php else: ?>
{
	"id": <?php echo $values['backgroundcategory']->get('id') ?>,
	"name": "<?php echo urlencode($values['backgroundcategory']->get('name')) ?>"
}
<?php endif ?>
