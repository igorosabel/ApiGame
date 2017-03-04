<?php foreach ($values['backgrounds'] as $bck): ?>
  <div class="board-menu-row board-menu-bcks" data-id="<?php echo $bck->get('id') ?>">
    <div class="board-menu-row-content">
      <div class="board-menu-bck-sample <?php echo $bck->get('class') ?>"></div>
      <span><?php echo $bck->get('name') ?></span>
      <img src="/img/<?php echo ($bck->get('crossable'))?'yes':'no' ?>.svg" />
    </div>
  </div>
<?php endforeach ?>