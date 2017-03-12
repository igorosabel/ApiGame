let deploys    = null;
let editUsrs   = null;
let deleteUsrs = null;
let editGams   = null;
let deleteGams = null;

const closeEditBtn = document.getElementById('edit-usr-close');
const usrFrm       = document.getElementById('frm-usr');
const closeEditGam = document.getElementById('edit-gam-close');
const gamFrm       = document.getElementById('frm-gam');
closeEditBtn.addEventListener('click', closeEditUser);
usrFrm.addEventListener('submit', saveUser);
closeEditGam.addEventListener('click', closeEditGame);
gamFrm.addEventListener('submit', saveGame);

function updateEventListeners(){
  deploys = document.querySelectorAll('.usr-deploy');
  deploys.forEach(deploy => deploy.addEventListener('click', deployUser));
  editUsrs = document.querySelectorAll('.usr-edit');
  editUsrs.forEach(usr => usr.addEventListener('click', editUser));
  deleteUsrs = document.querySelectorAll('.usr-delete');
  deleteUsrs.forEach(del => del.addEventListener('click', deleteUser));
  editGams = document.querySelectorAll('.obj-game-edit');
  editGams.forEach(gam => gam.addEventListener('click', editGame));
  deleteGams = document.querySelectorAll('.obj-game-delete');
  deleteGams.forEach(del => del.addEventListener('click', deleteGame));
}

function deployUser(e,id){
  let item;
  if (typeof id == 'undefined'){
    item = this.parentNode.parentNode;
  }
  else{
    item = document.getElementById('usr-'+id);
  }
  const deploy = item.querySelector('.usr-deploy');
  const list = item.querySelector('.usr-games');
  if (!list.classList.contains('usr-games-open')){
    deploy.classList.add('usr-deployed');
    list.classList.add('usr-games-open');
  }
  else{
    deploy.classList.remove('usr-deployed');
    list.classList.remove('usr-games-open');
  }
}

let editUserId = 0;

function editUser(e){
  e.preventDefault();
  const ovl   = document.getElementById('edit-usr');
  const email = document.getElementById('usr-email');
  const pass  = document.getElementById('usr-pass');
  const conf  = document.getElementById('usr-conf');
  
  const user = this.parentNode.parentNode;
  
  editUserId  = user.dataset.id;
  email.value = user.querySelector('.usr-header span').innerHTML;
  pass.value  = '';
  conf.value  = '';

  ovl.classList.add('add-box-show');
  email.focus();
}

function closeEditUser(e){
  if (e){ e.preventDefault(); }
  document.getElementById('edit-usr').classList.remove('add-box-show');
}

function saveUser(e){
  e.preventDefault();
  const email = document.getElementById('usr-email');
  if (email.value==''){
    alert('¡No puedes dejar el email del usuario en blanco!');
    email.focus();
    return false;
  }
  
  const pass = document.getElementById('usr-pass');
  const conf = document.getElementById('usr-conf');
  
  if (pass.value!='' && conf.value==''){
    alert('¡No puedes dejar la confirmación de la contraseña en blanco!');
    conf.focus();
    return false;
  }
  
  if (pass.value!='' && pass.value!=conf.value){
    alert('¡Las contraseñas introducidas no coinciden!');
    conf.focus();
    return false;
  }
  
  const params = {
    id: editUserId,
    email: urlencode(email.value),
    pass: urlencode(pass.value)
  };

  postAjax('/api/save-user', params, saveUserSuccess);
}

function saveUserSuccess(data){
  if (data.status=='ok'){
    const user = document.getElementById('usr-'+data.id);
    user.querySelector('.usr-header span').innerHTML = urldecode(data.email);
  }
  else{
    alert('¡Ocurrió un error al guardar el usuario!');
  }
  closeEditUser();
}

function deleteUser(){
  const usr = this;
  const id = parseInt(usr.parentNode.parentNode.dataset.id);
  const conf = confirm('¿Estás seguro de querer borrar este usuario?');
  if (conf){
    postAjax('/api/delete-user', {id: id}, deleteUserSuccess);
  }
}

function deleteUserSuccess(data){
  const usr = document.getElementById('usr-'+data.id);
  usr.parentNode.removeChild(usr);
}

let editGameId = 0;

function editGame(e){
  e.preventDefault();
  const ovl = document.getElementById('edit-gam');
  const nam = document.getElementById('gam-name');
  const sce = document.getElementById('gam-scenario');
  const x   = document.getElementById('gam-x');
  const y   = document.getElementById('gam-y');
  
  const game = this.parentNode.parentNode.parentNode;
  
  const name     = game.querySelector('.usr-game-name').innerHTML;
  const scenario = game.querySelector('.usr-game-scenario-name').dataset.id;
  const pos      = game.querySelector('.usr-game-scenario-position').dataset.position.split('-');
  
  editGameId  = game.dataset.id;
  nam.value   = name;
  sce.value   = scenario;
  x.value     = pos[0];
  y.value     = pos[1];

  ovl.classList.add('add-box-show');
}

function closeEditGame(e){
  if (e){ e.preventDefault(); }
  document.getElementById('edit-gam').classList.remove('add-box-show');
}

function saveGame(e){
  e.preventDefault();
  const name     = document.getElementById('gam-name');
  const scenario = document.getElementById('gam-scenario');
  const x        = document.getElementById('gam-x');
  const y        = document.getElementById('gam-y');
  
  if (name.value==''){
    alert('¡No puedes dejar el nombre del personaje en blanco!');
    name.focus();
    return false;
  }
  
  if (x.value==''){
    alert('¡No puedes dejar la posición X en blanco!');
    x.focus();
    return false;
  }
  
  const val_x = parseInt(x.value);
  if (isNaN(val_x)){
    alert('¡Tienes que introducir un número para la posición X!');
    x.focus();
    return false;
  }
  
  if (val_x<1 || val_x>24){
    alert('¡La posición X tiene que estar entre 1 y 24!');
    x.focus();
    return false;
  }
  
  if (y.value==''){
    alert('¡No puedes dejar la posición Y en blanco!');
    y.focus();
    return false;
  }
  
  const val_y = parseInt(y.value);
  if (isNaN(val_y)){
    alert('¡Tienes que introducir un número para la posición Y!');
    y.focus();
    return false;
  }
  
  if (val_y<1 || val_y>18){
    alert('¡La posición Y tiene que estar entre 1 y 18!');
    y.focus();
    return false;
  }
  
  const params = {
    id: editGameId,
    name: urlencode(name.value),
    id_scenario: scenario.value,
    x: x.value,
    y: y.value
  };

  postAjax('/api/save-game', params, saveGameSuccess);
}

function saveGameSuccess(data){
  if (data.status=='ok'){
    const game = document.getElementById('gam-'+data.id);
    const name = game.querySelector('.usr-game-name');
    name.innerHTML = urldecode(data.name);
    const scenario = game.querySelector('.usr-game-scenario-name');
    scenario.dataset.id = data.id_scenario;
    scenario.innerHTML  = urldecode(data.scenario);
    
    const position = game.querySelector('.usr-game-scenario-position');
    position.dataset.position = data.x + '-' + data.y;
    position.innerHTML = '(' + data.x + ',' + data.y + ')';
  }
  else{
    alert('¡Ocurrió un error al guardar la partida!');
  }
  closeEditGame();
}

function deleteGame(){
  const game = this;
  const id   = parseInt(game.parentNode.parentNode.parentNode.dataset.id);
  const conf = confirm('¿Estás seguro de querer borrar esta partida?');
  if (conf){
    postAjax('/api/delete-game', {id: id}, deleteGameSuccess);
  }
}

function deleteGameSuccess(data){
  const game = document.getElementById('gam-'+data.id);
  game.querySelector('.usr-game-data').classList.remove('usr-game-show');
  game.querySelector('.usr-game-none').classList.add('usr-game-show');
}

updateEventListeners();