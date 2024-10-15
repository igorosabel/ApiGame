<?php
use Osumi\OsumiFramework\App\Component\Model\Item\ItemComponent;
?>
<?php if (is_null($equipment)): ?>
null
<?php else: ?>
{
	"head": <?php echo is_null($equipment->getEquippedItem('head')) ? 'null' : strval(new ItemComponent(['Item' => $equipment->getEquippedItem('head')])) ?>,
	"necklace": <?php echo is_null($equipment->getEquippedItem('necklace')) ? 'null' : strval(new ItemComponent(['Item' => $equipment->getEquippedItem('necklace')])) ?>,
	"body": <?php echo is_null($equipment->getEquippedItem('body')) ? 'null' : strval(new ItemComponent(['Item' => $equipment->getEquippedItem('body')])) ?>,
	"boots": <?php echo is_null($equipment->getEquippedItem('boots')) ? 'null' : strval(new ItemComponent(['Item' => $equipment->getEquippedItem('boots')])) ?>,
	"weapon": <?php echo is_null($equipment->getEquippedItem('weapon')) ? 'null' : strval(new ItemComponent(['Item' => $equipment->getEquippedItem('weapon')])) ?>
}
<?php endif ?>
