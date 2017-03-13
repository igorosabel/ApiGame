<header>
  <img src="/img/triforce.png" />
  <a href="/admin/main">Admin</a> > Sprites
</header>

<div class="obj-list" id="sprc-list">
  {{sprites}}
</div>

<a href="#" id="add-btn" class="add-btn">+</a>

<div id="add-sprc" class="add-box-overlay">
  <form id="frm-sprc" method="post" action="#">
    <div class="add-box">
      <h3>
        <span id="add-sprc-title">Añadir categoría</span>
        <a href="#" id="add-sprc-close">x</a>
      </h3>
      <div class="add-box-row">
        <input type="text" class="add-box-txt" name="sprc-name" id="sprc-name" value="" placeholder="Nombre de la categoría" />
      </div>
      <div class="add-box-footer">
        <input type="submit" class="add-box-btn" id="new-sprc-go" value="Enviar" />
      </div>
    </div>
  </form>
</div>

<div id="add-spr" class="add-box-overlay">
  <form id="frm-spr" method="post" action="#">
    <div class="add-box">
      <h3>
        <span id="add-spr-title">Añadir sprite</span>
        <a href="#" id="add-spr-close">x</a>
      </h3>
      <div class="add-box-row">
        <input type="text" class="add-box-txt" name="spr-name" id="spr-name" value="" placeholder="Nombre del sprite" />
      </div>
      <div class="add-box-row">
        <input type="text" class="add-box-txt" name="spr-class" id="spr-class" value="" placeholder="Clase CSS del sprite" />
      </div>
      <div class="add-box-row">
        <label for="spr-crossable">Cruzar</label>
        <input type="checkbox" name="spr-crossable" id="spr-crossable" />
      </div>
      <div class="add-box-row">
        <label for="spr-breakable">Romper</label>
        <input type="checkbox" name="spr-breakable" id="spr-breakable" />
      </div>
      <div class="add-box-row">
        <label for="spr-grabbable">Coger</label>
        <input type="checkbox" name="spr-grabbable" id="spr-grabbable" />
      </div>
      <div class="add-box-row">
        <label for="spr-pickable">Coger (inv)</label>
        <input type="checkbox" name="spr-pickable" id="spr-pickable" />
      </div>
      <div class="add-box-footer">
        <input type="submit" class="add-box-btn" id="new-spr-go" value="Enviar" />
      </div>
    </div>
  </form>
</div>

<script type="text/x-template" id="sprc-tpl">
  <div class="obj-category" id="sprc-{{id}}" data-id="{{id}}">
    <div class="obj-category-header">
      <img src="/img/closed.svg" class="obj-category-deploy" />
      <span>{{name}}</span>
      <img src="/img/delete.svg" class="obj-category-btn obj-category-delete" title="Editar categoría" />
      <img src="/img/edit.svg" class="obj-category-btn obj-category-edit" title="Borrar categoría" />
      <img src="/img/add.svg" class="obj-category-btn obj-category-add" title="Añadir sprite" />
    </div>
    <div class="obj-category-list" id="spr-list-{{id}}"></div>
  </div>
</script>

<script type="text/x-template" id="spr-tpl">
  <div class="obj-item" id="spr-{{id}}" data-id="{{id}}">
    <div class="obj-item-sample {{class}}"></div>
    <div class="obj-item-name">{{name}}</div>
    <div class="obj-item-options">
      <img src="/img/edit.svg" class="obj-edit" title="Editar sprite" />
      <img src="/img/delete.svg" class="obj-delete" title="Borrar sprite" />
    </div>
    <div class="obj-item-info">
      <img class="obj-item-info-crossable" title="¿Se puede cruzar?" src="/img/{{crs_img}}.svg" data-crossable="{{crossable}}" />
      <img class="obj-item-info-breakable" title="¿Se puede romper?" src="/img/{{brk_img}}.svg" data-breakable="{{breakable}}" />
      <img class="obj-item-info-grabbable" title="¿Se puede coger?" src="/img/{{gra_img}}.svg" data-grabbable="{{grabbable}}" />
      <img class="obj-item-info-pickable" title="¿Se puede coger (inv)?" src="/img/{{pic_img}}.svg" data-pickable="{{pickable}}" />
    </div>
  </div>
</script>

<script src="/js/admin-sprites.js"></script>