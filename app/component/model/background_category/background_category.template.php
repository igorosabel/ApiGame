<?php if (is_null($values['background_category'])): ?>
null
<?php else: ?>
{
	"id": <?php echo $values['background_category']->get('id') ?>,
	"name": "<?php echo urlencode($values['background_category']->get('name')) ?>"
}
<?php endif ?>
