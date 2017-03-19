{{backgrounds_css}}
<header>
  <img src="/img/triforce.png" />
  <a href="/admin/main">Admin</a> > Fondos
  <a href="#" class="admin-header-add">Añadir categoría</a>
</header>

<div class="obj-list" id="bckc-list">
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
        <input type="button" class="add-box-btn add-box-btn-del" id="bckc-delete" value="Borrar" />
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
        <textarea class="add-box-textarea" name="bck-css" id="bck-css" placeholder="CSS de la clase"></textarea>
      </div>
      <div class="add-box-row">
        <label for="bck-crossable">Cruzable</label>
        <input type="checkbox" name="bck-crossable" id="bck-crossable" />
      </div>
      <div class="add-box-footer">
        <input type="button" class="add-box-btn add-box-btn-del" id="bck-delete" value="Borrar" />
        <input type="submit" class="add-box-btn" id="new-bck-go" value="Enviar" />
      </div>
    </div>
  </form>
</div>

<script type="text/x-template" id="bck-tpl">
  <div class="obj-item" id="bck-{{id}}" data-id="{{id}}">
    <div class="obj-item-sample {{class}}"></div>
    <div class="obj-item-name">{{name}}</div>
    <div class="obj-item-options">
      <img src="/img/edit.svg" class="obj-edit" title="Editar fondo" />
      <img src="/img/delete.svg" class="obj-delete" title="Borrar fondo" />
    </div>
    <div class="obj-item-info">
      <img title="¿Se puede cruzar?" src="/img/{{crs_img}}.svg" data-crossable="{{crossable}}" />
    </div>
  </div>
</script>

<script src="/js/admin-backgrounds.js"></script>