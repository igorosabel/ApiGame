<?php foreach ($values['backgrounds'] as $bckc): ?>
  <div class="cell-detail-title" id="select-bckc-<?php echo $bckc->get('id') ?>">
    <img src="/img/closed.svg" />
    <?php echo $bckc->get('name') ?>
  </div>
  <div class="cell-detail-group" id="select-group-bckc-<?php echo $bckc->get('id') ?>">
    <?php foreach ($bckc->getBackgrounds() as $bck): ?>
      <div class="cell-detail-item" data-type="bck" data-id="<?php echo $bck->get('id') ?>">
        <div class="cell-detail-item-sample <?php echo $bck->get('class') ?>"></div>
        <span><?php echo $bck->get('name') ?></span>
      </div>
    <?php endforeach ?>
  </div>
<?php endforeach ?>