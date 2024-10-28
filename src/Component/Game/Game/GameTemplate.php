<?php
use Osumi\OsumiFramework\App\Component\Model\Equipment\EquipmentComponent;
use Osumi\OsumiFramework\App\Component\Model\Item\ItemComponent;
?>
{
	"id": <?php echo $game->id ?>,
	"name": <?php echo !is_null($game->name) ? '"'.urlencode($game->name).'"' : 'null' ?>,
	"idScenario": <?php echo !is_null($game->id_scenario) ? $game->id_scenario : 'null' ?>,
	"positionX": <?php echo !is_null($game->position_x) ? $game->position_x : 'null' ?>,
	"positionY": <?php echo !is_null($game->position_y) ? $game->position_y : 'null' ?>,
	"orientation": <?php echo !is_null($game->orientation) ? '"'.$game->orientation.'"' : 'null' ?>,
	"money": <?php echo $game->money ?>,
	"health": <?php echo $game->health ?>,
	"maxHealth": <?php echo $game->max_health ?>,
	"attack": <?php echo $game->attack ?>,
	"defense": <?php echo $game->defense ?>,
	"speed": <?php echo $game->speed ?>,
	"items": [
<?php foreach ($game->getInventory() as $j => $inventory_item): ?>
		{
			"id": <?php echo $inventory_item->id ?>,
			"idGame": <?php echo $inventory_item->id_game ?>,
			"idItem": <?php echo $inventory_item->id_item ?>,
			"item": <?php echo new ItemComponent(['item' => $inventory_item->getItem()]) ?>,
			"order": <?php echo $inventory_item->order ?>,
			"num": <?php echo $inventory_item->num ?>
		}<?php if ($j < count($game->getInventory()) - 1): ?>,<?php endif ?>
<?php endforeach ?>
	],
	"equipment": <?php echo new EquipmentComponent(['equipment' => $game->getEquipment()]) ?>
}
