<?php
use Osumi\OsumiFramework\App\Component\Model\Equipment\EquipmentComponent;
use Osumi\OsumiFramework\App\Component\Model\Item\ItemComponent;
$equipment_component = new EquipmentComponent(['Equipment' => $values['Game']->getEquipment()]);
?>
{
	"id": <?php echo $values['Game']->get('id') ?>,
	"name": <?php echo !is_null($values['Game']->get('name')) ? '"'.urlencode($values['Game']->get('name')).'"' : 'null' ?>,
	"idScenario": <?php echo !is_null($values['Game']->get('id_scenario')) ? $values['Game']->get('id_scenario') : 'null' ?>,
	"positionX": <?php echo !is_null($values['Game']->get('position_x')) ? $values['Game']->get('position_x') : 'null' ?>,
	"positionY": <?php echo !is_null($values['Game']->get('position_y')) ? $values['Game']->get('position_y') : 'null' ?>,
	"orientation": <?php echo !is_null($values['Game']->get('orientation')) ? '"'.$values['Game']->get('orientation').'"' : 'null' ?>,
	"money": <?php echo $values['Game']->get('money') ?>,
	"health": <?php echo $values['Game']->get('health') ?>,
	"maxHealth": <?php echo $values['Game']->get('max_health') ?>,
	"attack": <?php echo $values['Game']->get('attack') ?>,
	"defense": <?php echo $values['Game']->get('defense') ?>,
	"speed": <?php echo $values['Game']->get('speed') ?>,
	"items": [
<?php foreach ($values['Game']->getInventory() as $j => $inventory_item): ?>
<?php $item_component = new ItemComponent(['Item' => $inventory_item->getItem()]); ?>
		{
			"id": <?php echo $inventory_item->get('id') ?>,
			"idGame": <?php echo $inventory_item->get('id_game') ?>,
			"idItem": <?php echo $inventory_item->get('id_item') ?>,
			"item": <?php echo $item_component ?>,
			"order": <?php echo $inventory_item->get('order') ?>,
			"num": <?php echo $inventory_item->get('num') ?>
		}<?php if ($j<count($values['Game']->getInventory())-1): ?>,<?php endif ?>
<?php endforeach ?>
	],
	"equipment": <?php echo $equipment_component ?>
}
