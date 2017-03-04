<div class="select-scenario">
  <h3>Elige escenario</h3>
  <ul id="scn-list" class="edit-list">
  {{scenarios}}
  </ul>
</div>

<a href="#" id="add-btn" class="add-btn">+</a>

<div id="add-scn" class="add-box-overlay">
  <div class="add-box">
    <h3>
      Añadir escenario
      <a href="#" id="add-scn-close">x</a>
    </h3>
    <div class="add-box-row">
      <input type="text" class="add-box-txt" name="new-scn-name" id="new-scn-name" value="" placeholder="Nombre del escenario" />
    </div>
    <div class="add-box-footer">
      <input type="button" class="add-box-btn" id="new-scn-go" value="Enviar" />
    </div>
  </div>
</div>

<script type="text/x-template" id="scn-tpl">
  <li>
    <a href="/edit/{{id}}/{{slug}}">{{name}}</a>
  </li>
</script>