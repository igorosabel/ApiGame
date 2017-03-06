window.onload = function(){
  const tabs = document.querySelectorAll('.home-tab');
  tabs.forEach(tab => tab.addEventListener('click', changeTab));
  
  const loginFrm    = document.getElementById('form-login');
  const registerFrm = document.getElementById('form-register');
  
  loginFrm.addEventListener('submit', login);
  registerFrm.addEventListener('submit', register);
};

function changeTab(e){
  const tab = e.target;
  const id = tab.id.replace('tab-','');
  
  document.querySelectorAll('.home-tab').forEach(tab => tab.classList.remove('home-tab-selected'));
  document.querySelectorAll('.home-tab-content').forEach(content => content.classList.remove('home-tab-selected'));
  tab.classList.add('home-tab-selected');
  document.getElementById('tab-content-'+id).classList.add('home-tab-selected');
}

function login(e){
  e.preventDefault();
  
  const email = document.getElementById('login-email');
  if (email.value==''){
    alert('¡No puedes dejar el email en blanco!');
    email.focus();
    return false;
  }
  
  const pass = document.getElementById('login-pass');
  if (pass.value==''){
    alert('¡No puedes dejar la contraseña en blanco!');
    pass.focus();
    return false;
  }
  
  postAjax('/api/login', {email: urlencode(email.value), pass: urlencode(pass.value)}, loginSuccess);
}

function loginSuccess(data){
  if (data.status=='ok'){
    document.location.href = '/player-select';
  }
  else{
    alert('¡El email o la contraseña no son correctos!');
  }
}

function register(e){
  e.preventDefault();
  
  const email = document.getElementById('register-email');
  if (email.value==''){
    alert('¡No puedes dejar el email en blanco!');
    email.focus();
    return false;
  }
  
  const conf = document.getElementById('register-conf');
  if (conf.value==''){
    alert('¡No puedes dejar la confirmación del email en blanco!');
    conf.focus();
    return false;
  }
  
  if (email.value!=conf.value){
    alert('¡Los emails introducidos no coinciden!');
    conf.focus();
    return false;
  }
  
  const pass = document.getElementById('register-pass');
  if (pass.value==''){
    alert('¡No puedes dejar la contraseña en blanco!');
    pass.focus();
    return false;
  }
  
  postAjax('/api/register', {email: urlencode(email.value), pass: urlencode(pass.value)}, registerSuccess);
}

function registerSuccess(data){
  if (data.status=='ok'){
    document.location.href = '/player-select';
  }
  else{
    alert('¡Ocurrió un error!');
  }
}