<?php if (is_null($connection)): ?>
null
<?php else: ?>
{
	"from": <?php echo is_null($connection->id_from) ? 'null' : $connection->id_from ?>,
	"fromName": "<?php echo urlencode($connection->getFrom()->name) ?>",
	"to": <?php echo is_null($connection->id_to) ? 'null' : $connection->id_to ?>,
	"toName": "<?php echo urlencode($connection->getTo()->name) ?>",
	"orientation": "<?php echo urlencode($connection->orientation) ?>"
}
<?php endif ?>
