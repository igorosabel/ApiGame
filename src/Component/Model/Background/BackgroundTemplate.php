<?php if (is_null($values['Background'])): ?>
null
<?php else: ?>
{
	"id": <?php echo $values['Background']->get('id') ?>,
	"idBackgroundCategory": <?php echo $values['Background']->get('id_background_category') ?>,
	"idAsset": <?php echo $values['Background']->get('id_asset') ?>,
	"assetUrl": "<?php echo urlencode($values['Background']->getAsset()->getUrl()) ?>",
	"name": "<?php echo urlencode($values['Background']->get('name')) ?>",
	"crossable": <?php echo $values['Background']->get('crossable') ? 'true' : 'false' ?>
}
<?php endif ?>
