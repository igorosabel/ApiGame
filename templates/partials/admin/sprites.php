<?php foreach ($values['sprites'] as $sprc): ?>
  <div class="board-menu-subtitle board-menu-sprs" id="board-menu-sprc-<?php echo $sprc->get('id') ?>">
    <div class="board-menu-row-content">
      <img src="/img/closed.svg" />
      <?php echo $sprc->get('name') ?>
    </div>
  </div>
  <?php foreach ($sprc->getSprites() as $spr): ?>
    <div class="board-menu-row board-menu-row-spr board-menu-sprc-<?php echo $sprc->get('id') ?>" data-id="<?php echo $spr->get('id') ?>">
      <div class="board-menu-row-content">
        <div class="board-menu-bck-sample <?php echo $spr->get('class') ?>"></div>
        <span><?php echo $spr->get('name') ?></span>
      </div>
    </div>
  <?php endforeach ?>
<?php endforeach ?>