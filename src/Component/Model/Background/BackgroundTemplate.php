<?php if (is_null($background)): ?>
null
<?php else: ?>
{
	"id": <?php echo $background->get('id') ?>,
	"idBackgroundCategory": <?php echo $background->get('id_background_category') ?>,
	"idAsset": <?php echo $background->get('id_asset') ?>,
	"assetUrl": "<?php echo urlencode($background->getAsset()->getUrl()) ?>",
	"name": "<?php echo urlencode($background->get('name')) ?>",
	"crossable": <?php echo $background->get('crossable') ? 'true' : 'false' ?>
}
<?php endif ?>
