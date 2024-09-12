<?php
use Osumi\OsumiFramework\App\Component\Model\Item\ItemComponent;
?>
<?php if (is_null($values['Equipment'])): ?>
null
<?php else: ?>
{
	"head": <?php echo is_null($values['Equipment']->getEquippedItem('head')) ? 'null' : strval(new ItemComponent(['Item' => $values['Equipment']->getEquippedItem('head')])) ?>,
	"necklace": <?php echo is_null($values['Equipment']->getEquippedItem('necklace')) ? 'null' : strval(new ItemComponent(['Item' => $values['Equipment']->getEquippedItem('necklace')])) ?>,
	"body": <?php echo is_null($values['Equipment']->getEquippedItem('body')) ? 'null' : strval(new ItemComponent(['Item' => $values['Equipment']->getEquippedItem('body')])) ?>,
	"boots": <?php echo is_null($values['Equipment']->getEquippedItem('boots')) ? 'null' : strval(new ItemComponent(['Item' => $values['Equipment']->getEquippedItem('boots')])) ?>,
	"weapon": <?php echo is_null($values['Equipment']->getEquippedItem('weapon')) ? 'null' : strval(new ItemComponent(['Item' => $values['Equipment']->getEquippedItem('weapon')])) ?>
}
<?php endif ?>
