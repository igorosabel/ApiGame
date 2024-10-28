<?php if (is_null($backgroundcategory)): ?>
null
<?php else: ?>
{
	"id": <?php echo $backgroundcategory->id ?>,
	"name": "<?php echo urlencode($backgroundcategory->name) ?>"
}
<?php endif ?>
