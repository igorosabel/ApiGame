<?php foreach ($values['list'] as $i => $asset): ?>
	{
		"id": <?php echo $asset->get('id') ?>,
		"idWorld": <?php echo (!is_null($asset->get('id_world')) ? $asset->get('id_world') : 'null') ?>,
		"name": "<?php echo urlencode($asset->get('name')) ?>",
		"url": "<?php echo urlencode($asset->getUrl()) ?>",
		"tags": [
<?php foreach ($asset->getTags() as $j => $tag): ?>
			{
				"id": <?php echo $tag->get('id') ?>,
				"name": "<?php echo urlencode($tag->get('name')) ?>"
			}<?php if ($j<count($asset->getTags())-1): ?>,<?php endif ?>
<?php endforeach ?>
		]
	}<?php if ($i<count($values['list'])-1): ?>,<?php endif ?>
<?php endforeach ?>