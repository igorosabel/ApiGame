<?php foreach ($values['backgrounds'] as $bckc): ?>
  <div class="background-category" id="bckc-<?php echo $bckc->get('id') ?>" data-id="<?php echo $bckc->get('id') ?>">
    <div class="background-category-header">
      <img src="/img/closed.svg" class="background-category-deploy" />
      <span><?php echo $bckc->get('name') ?></span>
      <img src="/img/delete.svg" class="background-category-btn background-category-delete" title="Editar categoría" />
      <img src="/img/edit.svg" class="background-category-btn background-category-edit" title="Borrar categoría" />
      <img src="/img/add.svg" class="background-category-btn background-category-add" title="Añadir fondo" />
    </div>
    <div class="background-category-list" id="bck-list-<?php echo $bckc->get('id') ?>">
      <?php foreach ($bckc->getBackgrounds() as $bck): ?>
      <div class="background-item" id="bck-<?php echo $bck->get('id') ?>" data-id="<?php echo $bck->get('id') ?>">
        <div class="background-item-sample <?php echo $bck->get('class') ?>"></div>
        <div class="background-item-name"><?php echo $bck->get('name') ?></div>
        <div class="background-item-options">
          <img src="/img/edit.svg" class="background-edit" title="Editar fondo" />
          <img src="/img/delete.svg" class="background-delete" title="Borrar fondo" />
        </div>
        <div class="background-item-info">
          <img src="/img/<?php echo ($bck->get('crossable')) ? 'yes':'no' ?>.svg" data-crossable="<?php echo ($bck->get('crossable')) ? '1':'0' ?>" />
        </div>
      </div>
      <?php endforeach ?>
    </div>
  </div>
<?php endforeach ?>