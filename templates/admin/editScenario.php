{{backgrounds_css}}
{{sprites_css}}
<header>
  <img src="/img/triforce.png" />
  <a href="/admin/main">Admin</a> > <a href="/admin/scenarios">Escenarios</a> > Editar escenario
</header>

<input type="text" class="scn-name" name="scn-name" id="scn-name" value="{{scn_name}}" placeholder="Nombre del escenario" />

<a href="#" id="save-scn" class="save-scn save-scn-disabled">Guardar</a>

<div id="board" class="board board-edit"></div>

<aside class="board-menu" id="menu">
  <h3>
    Casilla <span id="cell-x"></span>-<span id="cell-y"></span>
    <a href="#" id="board-menu-close">x</a>
  </h3>
  <div class="board-menu-title" id="board-menu-bcks">
    <img src="/img/closed.svg" />
    Fondo
  </div>
  {{backgrounds}}
  <div class="board-menu-title" id="board-menu-sprs">
    <img src="/img/closed.svg" />
    Sprites
  </div>
  {{sprites}}
</aside>

<script>
  var idScenario  = {{scn_id}};
  var scenario    = JSON.parse('{{scn_data}}');
  var backgrounds = JSON.parse('{{bcks_data}}');
  var sprites     = JSON.parse('{{sprs_data}}');
</script>
<script src="/js/admin-edit-scenario.js"></script>