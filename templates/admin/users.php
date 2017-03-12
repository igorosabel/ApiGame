<header>
  <img src="/img/triforce.png" />
  <a href="/admin/main">Admin</a> > Usuarios
</header>

<div class="usr-list" id="usr-list">
  {{users}}
</div>

<div id="edit-usr" class="add-box-overlay">
  <form id="frm-usr" method="post" action="#">
    <div class="add-box">
      <h3>
        Editar usuario
        <a href="#" id="edit-usr-close">x</a>
      </h3>
      <div class="add-box-row">
        <input type="email" class="add-box-txt" name="usr-email" id="usr-email" value="" placeholder="Email del usuario" />
      </div>
      <div class="add-box-row">
        <input type="password" class="add-box-txt" name="usr-pass" id="usr-pass" value="" placeholder="Contraseña del usuario" />
      </div>
      <div class="add-box-row">
        <input type="password" class="add-box-txt" name="usr-conf" id="usr-conf" value="" placeholder="Confirmar contraseña" />
      </div>
      <div class="add-box-footer">
        <input type="submit" class="add-box-btn" id="edit-usr-go" value="Enviar" />
      </div>
    </div>
  </form>
</div>

<div id="edit-gam" class="add-box-overlay">
  <form id="frm-gam" method="post" action="#">
    <div class="add-box">
      <h3>
        Editar partida
        <a href="#" id="edit-gam-close">x</a>
      </h3>
      <div class="add-box-row">
        <input type="text" class="add-box-txt" name="gam-name" id="gam-name" value="" placeholder="Nombre del personaje" />
      </div>
      <div class="add-box-row">
        <label>Escenario</label>
        <select name="gam-scenario" id="gam-scenario">
          {{scenarios}}
        </select>
      </div>
      <div class="add-box-row">
        <label>Posición</label>
        <input type="text" class="add-box-txt add-box-txt-sm" name="gam-x" id="gam-x" value="1" placeholder="X" />
        <input type="text" class="add-box-txt add-box-txt-sm" name="gam-y" id="gam-y" value="1" placeholder="Y" />
      </div>
      <div class="add-box-footer">
        <input type="submit" class="add-box-btn" id="edit-gam-go" value="Enviar" />
      </div>
    </div>
  </form>
</div>

<script src="/js/admin-users.js"></script>