<?php
use OsumiFramework\App\Component\Model\ItemComponent;
?>
{
	"head": <?php echo is_null($values['equipment']->getEquippedItem('head')) ? 'null' : strval(new ItemComponent(['item' => $values['equipment']->getEquippedItem('head')])) ?>,
	"necklace": <?php echo is_null($values['equipment']->getEquippedItem('necklace')) ? 'null' : strval(new ItemComponent(['item' => $values['equipment']->getEquippedItem('necklace')])) ?>,
	"body": <?php echo is_null($values['equipment']->getEquippedItem('body')) ? 'null' : strval(new ItemComponent(['item' => $values['equipment']->getEquippedItem('body')])) ?>,
	"boots": <?php echo is_null($values['equipment']->getEquippedItem('boots')) ? 'null' : strval(new ItemComponent(['item' => $values['equipment']->getEquippedItem('boots')])) ?>,
	"weapon": <?php echo is_null($values['equipment']->getEquippedItem('weapon')) ? 'null' : strval(new ItemComponent(['item' => $values['equipment']->getEquippedItem('weapon')])) ?>
}
