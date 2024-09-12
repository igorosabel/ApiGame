<?php if (is_null($values['Asset'])): ?>
null
<?php else: ?>
{
	"id": <?php echo $values['Asset']->get('id') ?>,
	"idWorld": <?php echo is_null($values['Asset']->get('id_world')) ? 'null' : $values['Asset']->get('id_world') ?>,
	"name": "<?php echo urlencode($values['Asset']->get('name')) ?>",
	"url": "<?php echo urlencode($values['Asset']->getUrl()) ?>",
	"tags": [
<?php foreach ($values['Asset']->getTags() as $j => $tag): ?>
		{
			"id": <?php echo $tag->get('id') ?>,
			"name": "<?php echo urlencode($tag->get('name')) ?>"
		}<?php if ($j<count($values['Asset']->getTags())-1): ?>,<?php endif ?>
<?php endforeach ?>
	]
}
<?php endif ?>
