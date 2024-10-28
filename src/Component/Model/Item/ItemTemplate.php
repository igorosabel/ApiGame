<?php if (is_null($item)): ?>
null
<?php else: ?>
{
	"id": <?php echo $item->id ?>,
	"type": <?php echo $item->type ?>,
	"idAsset": <?php echo $item->id_asset ?>,
	"assetUrl": "<?php echo urlencode($item->getAsset()->getUrl()) ?>",
	"name": "<?php echo urlencode($item->name) ?>",
	"money": <?php echo is_null($item->money) ? 'null' : $item->money ?>,
	"health": <?php echo is_null($item->health) ? 'null' : $item->health ?>,
	"attack": <?php echo is_null($item->attack) ? 'null' : $item->attack ?>,
	"defense": <?php echo is_null($item->defense) ? 'null' : $item->defense ?>,
	"speed": <?php echo is_null($item->speed) ? 'null' : $item->speed ?>,
	"wearable": <?php echo is_null($item->wearable) ? 'null' : $item->wearable ?>,
	"frames": [
	<?php foreach ($item->getFrames() as $j => $item_frame): ?>
		{
			"id": <?php echo $item_frame->id ?>,
			"idAsset": <?php echo $item_frame->id_asset ?>,
			"assetUrl": "<?php echo urlencode($item_frame->getAsset()->getUrl()) ?>",
			"order": <?php echo $item_frame->order ?>
		}<?php if ($j < count($item->getFrames()) - 1): ?>,<?php endif ?>
	<?php endforeach ?>
	]
}
<?php endif ?>
