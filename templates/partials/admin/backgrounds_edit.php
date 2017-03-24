<ul class="admin-tabs">
  <?php foreach ($values['backgrounds'] as $i => $bckc): ?>
  <li<?php if ($i==0): ?> class="admin-tab-selected"<?php endif ?> id="bckc-<?php echo $bckc->get('id') ?>" data-id="<?php echo $bckc->get('id') ?>">
    <span><?php echo $bckc->get('name') ?></span>
    <img src="/img/edit.svg" />
  </li>
  <?php endforeach ?>
</ul>

<?php foreach ($values['backgrounds'] as $i => $bckc): ?>
  <div class="admin-tab<?php if ($i==0): ?> admin-tab-selected<?php endif ?>" id="bckc-tab-<?php echo $bckc->get('id') ?>">
    <ul class="item-list">
      <?php foreach ($bckc->getBackgrounds() as $bck): ?>
      <li id="bck-<?php echo $bck->get('id') ?>" data-id="<?php echo $bck->get('id') ?>">
        <div class="item-list-sample <?php echo $bck->get('file') ?>"></div>
        <span><?php echo $bck->get('name') ?></span>
        <div class="item-list-info">
          <div class="item-list-info-item">
            <img class="crossable" title="¿Se puede cruzar?" src="/img/crossable_<?php echo $bck->get('crossable')?'on':'off' ?>.png" data-crossable="<?php echo $bck->get('crossable')?'1':'0' ?>" />
          </div>
        </div>
      </li>
      <?php endforeach ?>
    </ul>
  </div>
<?php endforeach ?>