<?php if (is_null($asset)): ?>
null
<?php else: ?>
{
	"id": <?php echo $asset->id ?>,
	"idWorld": <?php echo is_null($asset->id_world) ? 'null' : $asset->id_world ?>,
	"name": "<?php echo urlencode($asset->name) ?>",
	"url": "<?php echo urlencode($asset->getUrl()) ?>",
	"tags": [
<?php foreach ($asset->getTags() as $j => $tag): ?>
		{
			"id": <?php echo $tag->id ?>,
			"name": "<?php echo urlencode($tag->name) ?>"
		}<?php if ($j < count($asset->getTags()) - 1): ?>,<?php endif ?>
<?php endforeach ?>
	]
}
<?php endif ?>
