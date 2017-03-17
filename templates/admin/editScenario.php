{{backgrounds_css}}
{{sprites_css}}
<header>
  <img src="/img/triforce.png" />
  <a href="/admin/main">Admin</a> > <a href="/admin/scenarios">Escenarios</a> > Editar escenario
</header>

<div class="scenario-main">
  <div class="scenario-menu">
    <input type="text" class="scn-name" name="scn-name" id="scn-name" value="{{scn_name}}" placeholder="Nombre del escenario" />

    <div class="scenario-menu-options">
      <div class="scenario-menu-option scenario-menu-option-selected" data-id="select">
        <img src="/img/cursor.svg" title="Seleccionar" />
      </div>
      <div class="scenario-menu-option" data-id="paint">
        <img src="/img/paint.svg" title="Pintar" />
      </div>
      <div class="scenario-menu-option" data-id="clear">
        <img src="/img/clear.svg" title="Limpiar" />
      </div>
    </div>

    <div class="scenario-menu-option-label">Seleccionar</div>

    <div class="scenario-menu-paint-sample"></div>
    <div class="scenario-menu-paint-sample-name"></div>
    
    <div class="scenario-menu-paint-last">
      <div class="scenario-menu-paint-item"></div>
    </div>

    <a href="#" id="save-scn" class="save-scn save-scn-disabled">Guardar</a>

  </div>

  <div class="scenario-board">
    <div id="board" class="board board-edit"></div>
  </div>
</div>

<div class="scenario-overlay"></div>
<div class="over-box" id="cell-detail">
  <div class="over-header">
    <span id="cell-detail-name"></span>
    <img id="cell-detail-close" src="/img/clear.svg" />
  </div>
  <div class="over-body">
    <div class="cell-detail-option" id="cell-detail-background">
      <div class="cell-detail-option-title">Fondo</div>
      <div class="cell-detail-option-sample"></div>
      <div class="cell-detail-option-name"></div>
      <img class="cell-detail-option-delete" src="/img/clear.svg" title="Quitar fondo" />
    </div>
    <div class="cell-detail-option" id="cell-detail-sprite">
      <div class="cell-detail-option-title">Sprite</div>
      <div class="cell-detail-option-sample"></div>
      <div class="cell-detail-option-name"></div>
      <img class="cell-detail-option-delete" src="/img/clear.svg" title="Quitar sprite" />
    </div>
  </div>
</div>

<div class="over-box" id="select-background">
  <div class="over-header">
    <span>Fondos</span>
    <img id="select-background-close" src="/img/clear.svg" />
  </div>
  <div class="over-body-long">
    {{backgrounds}}
  </div>
</div>

<div class="over-box" id="select-sprite">
  <div class="over-header">
    <span>Sprites</span>
    <img id="select-sprite-close" src="/img/clear.svg" />
  </div>
  <div class="over-body-long">
    {{sprites}}
  </div>
</div>

<script>
  const idScenario  = {{scn_id}};
  const scenario    = JSON.parse('{{scn_data}}');
  const backgrounds = JSON.parse('{{bcks_data}}');
  const sprites     = JSON.parse('{{sprs_data}}');
</script>
<script src="/js/admin-edit-scenario.js"></script>