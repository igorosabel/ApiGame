<?php foreach ($values['sprites'] as $sprc): ?>
  <div class="cell-detail-title" id="select-sprc-<?php echo $sprc->get('id') ?>">
    <img src="/img/closed.svg" />
    <?php echo $sprc->get('name') ?>
  </div>
  <div class="cell-detail-group" id="select-group-sprc-<?php echo $sprc->get('id') ?>">
    <?php foreach ($sprc->getSprites() as $spr): ?>
      <div class="cell-detail-item" data-type="spr" data-id="<?php echo $spr->get('id') ?>">
        <div class="cell-detail-item-sample <?php echo $spr->get('file') ?>"></div>
        <span><?php echo $spr->get('name') ?></span>
      </div>
    <?php endforeach ?>
  </div>
<?php endforeach ?>