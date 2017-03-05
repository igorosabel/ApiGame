<?php foreach ($values['backgrounds'] as $bckc): ?>
  <div class="board-menu-subtitle board-menu-bcks" id="board-menu-bckc-<?php echo $bckc->get('id') ?>">
    <div class="board-menu-row-content">
      <img src="/img/closed.svg" />
      <?php echo $bckc->get('name') ?>
    </div>
  </div>
  <?php foreach ($bckc->getBackgrounds() as $bck): ?>
    <div class="board-menu-row board-menu-row-bck board-menu-bckc-<?php echo $bckc->get('id') ?>" data-id="<?php echo $bck->get('id') ?>">
      <div class="board-menu-row-content">
        <div class="board-menu-bck-sample <?php echo $bck->get('class') ?>"></div>
        <span><?php echo $bck->get('name') ?></span>
        <img title="¿Se puede cruzar?" src="/img/<?php echo ($bck->get('crossable'))?'yes':'no' ?>.svg" />
      </div>
    </div>
  <?php endforeach ?>
<?php endforeach ?>