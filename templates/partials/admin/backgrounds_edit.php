<?php foreach ($values['backgrounds'] as $bckc): ?>
  <div class="background-category" data-id="<?php echo $bckc->get('id') ?>">
    <div class="background-category-header">
      <img src="/img/closed.svg" class="background-category-deploy" />
      <span><?php echo $bckc->get('name') ?></span>
      <img src="/img/delete.svg" class="background-category-btn background-category-delete" title="Editar categoría" />
      <img src="/img/edit.svg" class="background-category-btn background-category-edit" title="Borrar categoría" />
      <img src="/img/add.svg" class="background-category-btn background-category-add" title="Añair fondo" />
    </div>
    <div class="background-category-list">
      <?php foreach ($bckc->getBackgrounds() as $bck): ?>
      <div class="background-item">
        <div class="background-item-sample <?php echo $bck->get('class') ?>"></div>
        <div class="background-item-name"><?php echo $bck->get('name') ?></div>
        <div class="background-item-options">
          <img src="/img/delete.svg" title="Editar fondo" />
          <img src="/img/edit.svg" title="Borrar fondo" />
        </div>
      </div>
      <?php endforeach ?>
    </div>
  </div>
<?php endforeach ?>