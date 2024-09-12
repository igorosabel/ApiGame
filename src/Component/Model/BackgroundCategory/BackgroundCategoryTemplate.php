<?php if (is_null($values['BackgroundCategory'])): ?>
null
<?php else: ?>
{
	"id": <?php echo $values['BackgroundCategory']->get('id') ?>,
	"name": "<?php echo urlencode($values['BackgroundCategory']->get('name')) ?>"
}
<?php endif ?>
