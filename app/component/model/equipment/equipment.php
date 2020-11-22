{
	"head": <?php echo is_null($values['equipment']->getEquippedItem('head')) ? 'null' : OTools::getComponent('model/item', ['item' => $values['equipment']->getEquippedItem('head')]) ?>,
	"necklace": <?php echo is_null($values['equipment']->getEquippedItem('necklace')) ? 'null' : OTools::getComponent('model/item', ['item' => $values['equipment']->getEquippedItem('necklace')]) ?>,
	"body": <?php echo is_null($values['equipment']->getEquippedItem('body')) ? 'null' : OTools::getComponent('model/item', ['item' => $values['equipment']->getEquippedItem('body')]) ?>,
	"boots": <?php echo is_null($values['equipment']->getEquippedItem('boots')) ? 'null' : OTools::getComponent('model/item', ['item' => $values['equipment']->getEquippedItem('boots')]) ?>,
	"weapon": <?php echo is_null($values['equipment']->getEquippedItem('weapon')) ? 'null' : OTools::getComponent('model/item', ['item' => $values['equipment']->getEquippedItem('weapon')]) ?>
}