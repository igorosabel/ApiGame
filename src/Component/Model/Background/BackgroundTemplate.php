<?php if (is_null($background)): ?>
null
<?php else: ?>
{
	"id": <?php echo $background->id ?>,
	"idBackgroundCategory": <?php echo $background->id_background_category ?>,
	"idAsset": <?php echo $background->id_asset ?>,
	"assetUrl": "<?php echo urlencode($background->getAsset()->getUrl()) ?>",
	"name": "<?php echo urlencode($background->name) ?>",
	"crossable": <?php echo $background->crossable ? 'true' : 'false' ?>
}
<?php endif ?>
