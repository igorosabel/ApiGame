{
	"id": <?php echo $values['game']->get('id') ?>,
	"name": <?php echo !is_null($values['game']->get('name')) ? '"'.urlencode($values['game']->get('name')).'"' : 'null' ?>,
	"idScenario": <?php echo !is_null($values['game']->get('id_scenario')) ? $values['game']->get('id_scenario') : 'null' ?>,
	"positionX": <?php echo !is_null($values['game']->get('position_x')) ? $values['game']->get('position_x') : 'null' ?>,
	"positionY": <?php echo !is_null($values['game']->get('position_y')) ? $values['game']->get('position_y') : 'null' ?>,
	"orientation": <?php echo !is_null($values['game']->get('orientation')) ? '"'.$values['game']->get('orientation').'"' : 'null' ?>,
	"money": <?php echo $values['game']->get('money') ?>,
	"health": <?php echo $values['game']->get('health') ?>,
	"maxHealth": <?php echo $values['game']->get('max_health') ?>,
	"attack": <?php echo $values['game']->get('attack') ?>,
	"defense": <?php echo $values['game']->get('defense') ?>,
	"speed": <?php echo $values['game']->get('speed') ?>,
	"items": [
<?php foreach ($values['game']->getInventory() as $j => $inventory_item): ?>
		{
			"id": <?php echo $inventory_item->get('id') ?>,
			"idGame": <?php echo $inventory_item->get('id_game') ?>,
			"idItem": <?php echo $inventory_item->get('id_item') ?>,
			"item": <?php echo OTools::getComponent('model/item', ['item' => $inventory_item->getItem()]) ?>,
			"order": <?php echo $inventory_item->get('order') ?>,
			"num": <?php echo $inventory_item->get('num') ?>
		}<?php if ($j<count($values['game']->getInventory())-1): ?>,<?php endif ?>
<?php endforeach ?>
	],
	"equipment": <?php echo OTools::getComponent('model/equipment', ['equipment' => $values['game']->getEquipment()]) ?>
}