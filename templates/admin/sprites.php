{{sprites_css}}
<header>
  <img src="/img/triforce.png" />
  <a href="/admin/main">Admin</a> > Sprites
  <a href="#" class="admin-header-add">Añadir categoría</a>
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
        <input type="button" class="add-box-btn add-box-btn-del" id="sprc-delete" value="Borrar" />
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
        <div class="add-box-main-photo">
          <div class="add-file" id="add-file" data-type="main"></div>
          <div class="add-file-label">Principal</div>
        </div>
        <div class="add-box-photos">
          <div class="add-box-photo-container"></div>
          <div class="add-box-photo" id="add-frame-box">
            <div class="add-file" id="add-frame" data-type="frame">
              <img src="/img/add.svg" />
            </div>
            <div class="add-file-label">Añadir</div>
          </div>
        </div>
        <input type="file" class="add-box-file" name="spr-file" id="spr-file" />
        <input type="file" class="add-box-file" name="spr-frame" id="spr-frame" />
      </div>
      <div class="add-box-row">
        <div class="add-box-col">
          <label for="spr-width">Anchura</label>
          <input type="text" class="add-box-txt add-box-txt-sm" name="spr-width" id="spr-width" value="" placeholder="Anchura del sprite (en casillas)" />
        </div>
        <div class="add-box-col">
          <label for="spr-height">Altura</label>
          <input type="text" class="add-box-txt add-box-txt-sm" name="spr-height" id="spr-height" value="" placeholder="Altura del sprite (en casillas)" />
        </div>
      </div>
      <div class="add-box-row">
        <label for="spr-crossable">Cruzar</label>
        <input type="checkbox" name="spr-crossable" id="spr-crossable" />
      </div>
      <div class="add-box-footer">
        <input type="button" class="add-box-btn add-box-btn-del" id="spr-delete" value="Borrar" />
        <input type="submit" class="add-box-btn" id="new-spr-go" value="Enviar" />
      </div>
    </div>
  </form>
</div>

<script type="text/x-template" id="spr-tpl">
  <div class="item-list-sample {{file}}">
    <img src="{{url}}" />
  </div>
  <span>{{name}}</span>
  <div class="item-list-info">
    <div class="item-list-info-item">
      <img class="crossable" title="¿Se puede cruzar?" src="/img/crossable_{{crossable}}.png" />
    </div>
  </div>
</script>

<script type="text/x-template" id="fr-tpl">
  <div class="add-file" id="frm-{{ind}}">
    <img src="{{data}}" />
    <div class="add-file-controls add-file-arrows add-file-left" title="Mover a la izquierda">&lt;</div>
    <div class="add-file-controls add-file-arrows add-file-right" title="Mover a la derecha">&gt;</div>
    <div class="add-file-controls add-file-delete" title="Borrar frame">X</div>
  </div>
  <div class="add-file-label">Frame {{num}}</div>
</script>

<script src="/js/admin-sprites.js"></script>