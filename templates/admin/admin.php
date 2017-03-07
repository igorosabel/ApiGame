<header>
  <img src="/img/triforce.png" />
  Admin
</header>

<div class="home-box">
  <div id="tab-content-login" class="home-tab-content home-tab-selected">
    <form action="/admin/login" method="post" id="form-login">
      <div class="home-row">
        <input type="text" class="home-input" name="user" id="user" value="" placeholder="Usuario" autofocus />
      </div>
      <div class="home-row">
        <input type="password" class="home-input" name="pass" id="pass" value="" placeholder="Contraseña" />
      </div>
      <div class="home-row">
        <input type="submit" class="home-btn" id="login-go" value="Continuar" />
      </div>
    </form>
  </div>
</div>

<div class="error-msg">{{msg}}</div>