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
        <label>Imagen:</label>
        <div class="add-file"></div>
        <input type="file" class="add-box-file" name="bck-file" id="bck-file" />
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
  <div class="item-list-sample {{file}}"></div>
  <span>{{name}}</span>
  <div class="item-list-info">
    <div class="item-list-info-item">
      <img class="crossable" title="¿Se puede cruzar?" src="/img/crossable_{{crossable}}.png" data-crossable="{{crs}}" />
    </div>
  </div>
</script>

<script src="/js/admin-backgrounds.js"></script>