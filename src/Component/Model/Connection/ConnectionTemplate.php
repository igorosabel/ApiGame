<?php if (is_null($connection)): ?>
null
<?php else: ?>
{
	"from": <?php echo is_null($connection->get('id_from')) ? 'null' : $connection->get('id_from') ?>,
	"fromName": "<?php echo urlencode($connection->getFrom()->get('name')) ?>",
	"to": <?php echo is_null($connection->get('id_to')) ? 'null' : $connection->get('id_to') ?>,
	"toName": "<?php echo urlencode($connection->getTo()->get('name')) ?>",
	"orientation": "<?php echo urlencode($connection->get('orientation')) ?>"
}
<?php endif ?>
