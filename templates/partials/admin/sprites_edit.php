<ul class="admin-tabs">
  <?php foreach ($values['sprites'] as $i => $sprc): ?>
  <li<?php if ($i==0): ?> class="admin-tab-selected"<?php endif ?> id="sprc-<?php echo $sprc->get('id') ?>" data-id="<?php echo $sprc->get('id') ?>">
    <span><?php echo $sprc->get('name') ?></span>
    <img src="/img/edit.svg" />
  </li>
  <?php endforeach ?>
</ul>

<?php foreach ($values['sprites'] as $i => $sprc): ?>
  <div class="admin-tab<?php if ($i==0): ?> admin-tab-selected<?php endif ?>" id="sprc-tab-<?php echo $sprc->get('id') ?>">
    <ul class="item-list">
      <?php foreach ($sprc->getSprites() as $spr): ?>
      <li id="spr-<?php echo $spr->get('id') ?>" data-id="<?php echo $spr->get('id') ?>">
        <div class="item-list-sample <?php echo $spr->get('file') ?>"></div>
        <span><?php echo $spr->get('name') ?></span>
        <div class="item-list-info">
          <div class="item-list-info-item">
            <img class="crossable" title="¿Se puede cruzar?" src="/img/crossable_<?php echo $spr->get('crossable')?'on':'off' ?>.png" data-crossable="<?php echo $spr->get('crossable')?'1':'0' ?>" />
          </div>
          <div class="item-list-info-item">
            <img class="breakable" title="¿Se puede romper?" src="/img/breakable_<?php echo $spr->get('breakable')?'on':'off' ?>.png" data-breakable="<?php echo $spr->get('breakable')?'1':'0' ?>" />
          </div>
          <div class="item-list-info-item">
            <img class="grabbable" title="¿Se puede coger?" src="/img/grabbable_<?php echo $spr->get('grabbable')?'on':'off' ?>.png" data-grabbable="<?php echo $spr->get('grabbable')?'1':'0' ?>" />
          </div>
          <div class="item-list-info-item">
            <img class="pickable" title="¿Se puede coger (inv)?" src="/img/pickable_<?php echo $spr->get('pickable')?'on':'off' ?>.png" data-pickable="<?php echo $spr->get('pickable')?'1':'0' ?>" />
          </div>
        </div>
      </li>
      <?php endforeach ?>
    </ul>
  </div>
<?php endforeach ?>