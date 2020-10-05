<?php foreach ($values['interactives'] as $int): ?>
<li id="int-<?php echo $int->get('id') ?>" data-id="<?php echo $int->get('id') ?>">
	<div class="item-list-sample">
		<img src="/assets/sprite/<?php echo $int->getSpriteStart()->getCategory()->get('slug') ?>/<?php echo $int->getSpriteStart()->get('file') ?>.png">
	</div>
	<span><?php echo $int->get('name') ?></span>
</li>
<?php endforeach ?>