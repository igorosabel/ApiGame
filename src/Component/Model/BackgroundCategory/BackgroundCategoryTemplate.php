<?php if (is_null($backgroundcategory)): ?>
null
<?php else: ?>
{
	"id": <?php echo $backgroundcategory->get('id') ?>,
	"name": "<?php echo urlencode($backgroundcategory->get('name')) ?>"
}
<?php endif ?>
