<?php foreach ($values['backgrounds'] as $bckc): ?>
  <div class="obj-category" id="bckc-<?php echo $bckc->get('id') ?>" data-id="<?php echo $bckc->get('id') ?>">
    <div class="obj-category-header">
      <img src="/img/closed.svg" class="obj-category-deploy" />
      <span><?php echo $bckc->get('name') ?></span>
      <img src="/img/delete.svg" class="obj-category-btn obj-category-delete" title="Editar categoría" />
      <img src="/img/edit.svg" class="obj-category-btn obj-category-edit" title="Borrar categoría" />
      <img src="/img/add.svg" class="obj-category-btn obj-category-add" title="Añadir fondo" />
    </div>
    <div class="obj-category-list" id="bck-list-<?php echo $bckc->get('id') ?>">
      <?php foreach ($bckc->getBackgrounds() as $bck): ?>
      <div class="obj-item" id="bck-<?php echo $bck->get('id') ?>" data-id="<?php echo $bck->get('id') ?>">
        <div class="obj-item-sample <?php echo $bck->get('class') ?>"></div>
        <div class="obj-item-name"><?php echo $bck->get('name') ?></div>
        <div class="obj-item-options">
          <img src="/img/edit.svg" class="obj-edit" title="Editar fondo" />
          <img src="/img/delete.svg" class="obj-delete" title="Borrar fondo" />
        </div>
        <div class="obj-item-info">
          <img title="¿Se puede cruzar?" src="/img/<?php echo ($bck->get('crossable')) ? 'yes':'no' ?>.svg" data-crossable="<?php echo ($bck->get('crossable')) ? '1':'0' ?>" />
        </div>
      </div>
      <?php endforeach ?>
    </div>
  </div>
<?php endforeach ?>