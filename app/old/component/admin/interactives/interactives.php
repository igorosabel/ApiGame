<div class="cell-detail-group cell-detail-group-open">
	<?php foreach($values['interactives'] as $int): ?>
	<div class="cell-detail-item" data-type="int" data-id="<?php echo $int->get('id') ?>">
		<div class="cell-detail-item-sample <?php echo $int->getSpriteStart()->get('file') ?>"></div>
		<span><?php echo $int->get('name') ?></span>
	</div>
	<?php endforeach ?>
</div>