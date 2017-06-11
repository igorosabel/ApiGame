{{sprites_css}}
<header>
  <img src="/img/triforce.png" />
  <a href="/admin/main">Admin</a> > Interactivos
</header>

<div class="obj-list">
  <ul class="item-list" id="int-list">
    {{interactives}}
  </ul>
</div>

<a href="#" id="add-btn" class="add-btn">+</a>

<div id="add-int" class="add-box-overlay">
  <form id="frm-int" method="post" action="#">
    <div class="add-box add-box-tall">
      <h3>
        <span id="add-int-title">Añadir elemento interativo</span>
        <a href="#" id="add-int-close">x</a>
      </h3>
      <div class="add-box-row">
        <input type="text" class="add-box-txt" name="int-name" id="int-name" value="" placeholder="Nombre del elemento interativo" />
      </div>
      <div class="add-box-row">
        <div class="cell-detail-option cell-detail-option-small" id="cell-detail-sprite-start">
          <div class="cell-detail-option-title">Sprite inicial</div>
          <div class="cell-detail-option-sample"></div>
          <div class="cell-detail-option-name"></div>
          <img class="cell-detail-option-delete" src="/img/clear.svg" title="Quitar sprite inicial" />
        </div>
        <div class="cell-detail-option cell-detail-option-small" id="cell-detail-sprite-active">
          <div class="cell-detail-option-title">Sprite activo</div>
          <div class="cell-detail-option-sample"></div>
          <div class="cell-detail-option-name"></div>
          <img class="cell-detail-option-delete" src="/img/clear.svg" title="Quitar sprite activo" />
        </div>
      </div>
      <div class="add-box-row">
        <div class="add-box-col">
          <label for="int-type">Tipo</label>
          <select name="int-type" id="int-type">
            <option value="0">Elige tipo</option>
            <option value="1">Arma</option>
            <option value="2">Dinero</option>
            <option value="3">Inventario</option>
            <option value="4">Especial</option>
          </select>
        </div>
        <div class="add-box-col">
          <label for="int-grabbable">Coger</label>
          <input type="checkbox" name="int-pickable" id="int-pickable" />
        </div>
      </div>
      <div class="add-box-row">
        <div class="add-box-col">
          <label for="int-activable">Activable</label>
          <input type="checkbox" name="int-activable" id="int-activable" />
        </div>
        <div class="add-box-col">
          <label for="int-active-time">Tiempo activo</label>
          <input type="text" class="add-box-txt add-box-txt-sm" name="int-active-time" id="int-active-time" />
        </div>
      </div>
      <div class="add-box-row">
        <div class="add-box-col">
          <label for="int-grabbable">Levantar</label>
          <input type="checkbox" name="int-grabbable" id="int-grabbable" />
        </div>
        <div class="add-box-col">
          <label for="int-breakable">Romper</label>
          <input type="checkbox" name="int-breakable" id="int-breakable" />
        </div>
      </div>
      <div class="add-box-row">
        <div class="add-box-col">
          <label for="int-crossable">Cruzar</label>
          <input type="checkbox" name="int-crossable" id="int-crossable" />
        </div>
        <div class="add-box-col">
          <label for="int-crossable-active">Cruzar (activo)</label>
          <input type="checkbox" name="int-crossable-active" id="int-crossable-active" />
        </div>
      </div>
      <div class="add-box-row">
        <div class="add-box-col">
          <label for="int-drops">Obtener</label>
          <select name="int-drops" id="int-drops">
            <option value="0">Elige item</option>
          </select>
        </div>
        <div class="add-box-col">
          <label for="int-quantity">Cantidad</label>
          <input type="text" class="add-box-txt add-box-txt-sm" name="int-quantity" id="int-quantity" />
        </div>
      </div>
      <div class="add-box-footer">
        <input type="button" class="add-box-btn add-box-btn-del" id="int-delete" value="Borrar" />
        <input type="submit" class="add-box-btn" id="new-int-go" value="Enviar" />
      </div>
    </div>
  </form>
</div>

<div id="sel-sprite" class="add-box-overlay">
  <div class="add-box">
    <h3>
      <span id="sel-sprite-title">Añadir sprite</span>
      <a href="#" id="sel-sprite-close">x</a>
    </h3>
    <div class="over-body-long">
      {{sprites}}
    </div>
  </div>
</div>

<script type="text/x-template" id="int-tpl">
  <li id="int-{{id}}" data-id="{{id}}">
    <div class="item-list-sample">
      <img src="{{url}}" />
    </div>
    <span>{{name}}</span>
  </li>
</script>

<script>
  var sprites_json = {{sprites_json}};
</script>

<script src="/js/admin-interactives.js"></script>