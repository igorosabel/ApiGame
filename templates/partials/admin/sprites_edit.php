<?php foreach ($values['sprites'] as $sprc): ?>
  <div class="obj-category" id="sprc-<?php echo $sprc->get('id') ?>" data-id="<?php echo $sprc->get('id') ?>">
    <div class="obj-category-header">
      <img src="/img/closed.svg" class="obj-category-deploy" />
      <span><?php echo $sprc->get('name') ?></span>
      <img src="/img/delete.svg" class="obj-category-btn obj-category-delete" title="Editar categoría" />
      <img src="/img/edit.svg" class="obj-category-btn obj-category-edit" title="Borrar categoría" />
      <img src="/img/add.svg" class="obj-category-btn obj-category-add" title="Añadir sprite" />
    </div>
    <div class="obj-category-list" id="spr-list-<?php echo $sprc->get('id') ?>">
      <?php foreach ($sprc->getSprites() as $spr): ?>
      <div class="obj-item" id="spr-<?php echo $spr->get('id') ?>" data-id="<?php echo $spr->get('id') ?>">
        <div class="obj-item-sample <?php echo $spr->get('class') ?>"></div>
        <div class="obj-item-name"><?php echo $spr->get('name') ?></div>
        <div class="obj-item-options">
          <img src="/img/edit.svg" class="obj-edit" title="Editar sprite" />
          <img src="/img/delete.svg" class="obj-delete" title="Borrar sprite" />
        </div>
        <div class="obj-item-info">
          <img src="/img/<?php echo ($spr->get('crossable')) ? 'yes':'no' ?>.svg" data-crossable="<?php echo ($spr->get('crossable')) ? '1':'0' ?>" />
        </div>
      </div>
      <?php endforeach ?>
    </div>
  </div>
<?php endforeach ?>