<?php
use Osumi\OsumiFramework\App\Component\Model\Equipment\EquipmentComponent;
use Osumi\OsumiFramework\App\Component\Model\Item\ItemComponent;
$equipment_component = new EquipmentComponent(['equipment' => $game->getEquipment()]);
?>
{
	"id": <?php echo $game->get('id') ?>,
	"name": <?php echo !is_null($game->get('name')) ? '"'.urlencode($game->get('name')).'"' : 'null' ?>,
	"idScenario": <?php echo !is_null($game->get('id_scenario')) ? $game->get('id_scenario') : 'null' ?>,
	"positionX": <?php echo !is_null($game->get('position_x')) ? $game->get('position_x') : 'null' ?>,
	"positionY": <?php echo !is_null($game->get('position_y')) ? $game->get('position_y') : 'null' ?>,
	"orientation": <?php echo !is_null($game->get('orientation')) ? '"'.$game->get('orientation').'"' : 'null' ?>,
	"money": <?php echo $game->get('money') ?>,
	"health": <?php echo $game->get('health') ?>,
	"maxHealth": <?php echo $game->get('max_health') ?>,
	"attack": <?php echo $game->get('attack') ?>,
	"defense": <?php echo $game->get('defense') ?>,
	"speed": <?php echo $game->get('speed') ?>,
	"items": [
<?php foreach ($game->getInventory() as $j => $inventory_item): ?>
<?php $item_component = new ItemComponent(['item' => $inventory_item->getItem()]); ?>
		{
			"id": <?php echo $inventory_item->get('id') ?>,
			"idGame": <?php echo $inventory_item->get('id_game') ?>,
			"idItem": <?php echo $inventory_item->get('id_item') ?>,
			"item": <?php echo $item_component ?>,
			"order": <?php echo $inventory_item->get('order') ?>,
			"num": <?php echo $inventory_item->get('num') ?>
		}<?php if ($j<count($game->getInventory())-1): ?>,<?php endif ?>
<?php endforeach ?>
	],
	"equipment": <?php echo $equipment_component ?>
}
