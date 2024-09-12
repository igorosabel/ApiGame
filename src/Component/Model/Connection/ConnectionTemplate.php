<?php if (is_null($values['Connection'])): ?>
null
<?php else: ?>
{
	"from": <?php echo is_null($values['Connection']->get('id_from')) ? 'null' : $values['Connection']->get('id_from') ?>,
	"fromName": "<?php echo urlencode($values['Connection']->getFrom()->get('name')) ?>",
	"to": <?php echo is_null($values['Connection']->get('id_to')) ? 'null' : $values['Connection']->get('id_to') ?>,
	"toName": "<?php echo urlencode($values['Connection']->getTo()->get('name')) ?>",
	"orientation": "<?php echo urlencode($values['Connection']->get('orientation')) ?>"
}
<?php endif ?>
