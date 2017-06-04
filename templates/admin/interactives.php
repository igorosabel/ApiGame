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
    <div class="add-box">
      <h3>
        <span id="add-int-title">Añadir elemento interativo</span>
        <a href="#" id="add-int-close">x</a>
      </h3>
      <div class="add-box-row">
        <input type="text" class="add-box-txt" name="int-name" id="int-name" value="" placeholder="Nombre del elemento interativo" />
      </div>
      <div class="add-box-row">
        <div class="cell-detail-option" id="cell-detail-sprite-start">
          <div class="cell-detail-option-title">Sprite inicial</div>
          <div class="cell-detail-option-sample"></div>
          <div class="cell-detail-option-name"></div>
          <img class="cell-detail-option-delete" src="/img/clear.svg" title="Quitar sprite inicial" />
        </div>
        <div class="cell-detail-option" id="cell-detail-sprite-end">
          <div class="cell-detail-option-title">Sprite final</div>
          <div class="cell-detail-option-sample"></div>
          <div class="cell-detail-option-name"></div>
          <img class="cell-detail-option-delete" src="/img/clear.svg" title="Quitar sprite final" />
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
  <li id="int-{{id}}" data-id="{{id}}" data-spritestart="{{sprite_start}}" data-spriteend="{{sprite_end}}">
    <div class="item-list-sample">
      <img src="{{url}}" />
    </div>
    <span>{{name}}</span>
  </li>
</script>

<script src="/js/admin-interactives.js"></script>