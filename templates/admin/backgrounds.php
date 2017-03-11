<header>
  <img src="/img/triforce.png" />
  <a href="/admin/main">Admin</a> > Fondos
</header>

<div class="backgrounds-list" id="bckc-list">
  {{backgrounds}}
</div>

<a href="#" id="add-btn" class="add-btn">+</a>

<div id="add-bckc" class="add-box-overlay">
  <form id="frm-bckc" method="post" action="#">
    <div class="add-box">
      <h3>
        <span id="add-bckc-title">Añadir categoría</span>
        <a href="#" id="add-bckc-close">x</a>
      </h3>
      <div class="add-box-row">
        <input type="text" class="add-box-txt" name="bckc-name" id="bckc-name" value="" placeholder="Nombre de la categoría" />
      </div>
      <div class="add-box-footer">
        <input type="submit" class="add-box-btn" id="new-bckc-go" value="Enviar" />
      </div>
    </div>
  </form>
</div>

<div id="add-bck" class="add-box-overlay">
  <form id="frm-bck" method="post" action="#">
    <div class="add-box">
      <h3>
        <span id="add-bck-title">Añadir fondo</span>
        <a href="#" id="add-bck-close">x</a>
      </h3>
      <div class="add-box-row">
        <input type="text" class="add-box-txt" name="bck-name" id="bck-name" value="" placeholder="Nombre del fondo" />
      </div>
      <div class="add-box-row">
        <input type="text" class="add-box-txt" name="bck-class" id="bck-class" value="" placeholder="Clase CSS del fondo" />
      </div>
      <div class="add-box-row">
        <label for="bck-crossable">Cruzable</label>
        <input type="checkbox" name="bck-crossable" id="bck-crossable" />
      </div>
      <div class="add-box-footer">
        <input type="submit" class="add-box-btn" id="new-bck-go" value="Enviar" />
      </div>
    </div>
  </form>
</div>

<script type="text/x-template" id="bckc-tpl">
  <div class="background-category" data-id="{{id}}">
    <div class="background-category-header">
      <img src="/img/closed.svg" class="background-category-deploy" />
      <span>{{name}}</span>
      <img src="/img/delete.svg" class="background-category-btn background-category-delete" title="Editar categoría" />
      <img src="/img/edit.svg" class="background-category-btn background-category-edit" title="Borrar categoría" />
      <img src="/img/add.svg" class="background-category-btn background-category-add" title="Añadir fondo" />
    </div>
    <div class="background-category-list"></div>
  </div>
</script>

<script type="text/x-template" id="bck-tpl">
  <div class="background-item" id="bck-{{id}}" data-id="{{id}}">
    <div class="background-item-sample {{class}}"></div>
    <div class="background-item-name">{{name}}</div>
    <div class="background-item-options">
      <img src="/img/edit.svg" class="background-edit" title="Editar fondo" />
      <img src="/img/delete.svg" class="background-delete" title="Borrar fondo" />
    </div>
    <div class="background-item-info">
      <img src="/img/{{crs_img}}.svg" data-crossable="{{crossable}}" />
    </div>
  </div>
</script>

<script src="/js/admin-backgrounds.js"></script>