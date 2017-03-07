const games = document.querySelectorAll('.player-select-game');
games.forEach(game => game.addEventListener('mouseover', overGame, true));
games.forEach(game => game.addEventListener('click', selectGame));
document.body.addEventListener('keydown',changeGame);

const newClose = document.getElementById('new-game-close');
const newForm = document.getElementById('form-new-game');
newClose.addEventListener('click', closeAddGame);
newForm.addEventListener('submit', sendAddGame);

/*
 * Partida elegida
 */
let selectedGame = 1;
let selectedGameId = document.querySelector('.player-select-game-selected').dataset.id;

/*
 * Función para mover entre las partidas disponibles
 */
function changeGame(e){
  const key = e.keyCode;
  const controls = [13,27,38,40];
  if (controls.indexOf(key)!=-1){
    switch(key){
      // Intro
      case 13:{
        selectGame(e,selectedGame);
      }
      break;
      case 27:{
        closeAddGame(e);
      }
      break;
      // Arriba
      case 38:{
        if (selectedGame==1){
          return false;
        }
        selectedGame--;
        changeSelectedGame();
      }
      break;
      // Abajo
      case 40:{
        if (selectedGame==3){
          return false;
        }
        selectedGame++;
        changeSelectedGame();
      }
      break;
    }
  }
}

/*
 * Función que se ejecuta al pasar el ratón sobre cada partida
 */
function overGame(e){
  const game = this;
  const id = game.id.replace('player-select-game-','');
  selectedGame = parseInt(id);
  changeSelectedGame();
}

/*
 * Función para cambiar de partida elegida
 */
function changeSelectedGame(){
  const games = document.querySelectorAll('.player-select-game');
  games.forEach(game => game.classList.remove('player-select-game-selected'));
  const game = document.getElementById('player-select-game-'+selectedGame);
  game.classList.add('player-select-game-selected');
  selectedGameId = game.dataset.id;
}

/*
 * Función para seleccionar una partida
 */
function selectGame(e,num){
  e.preventDefault();
  let game;
  if (typeof num == 'undefined'){
    game = this;
  }
  else{
    game = document.getElementById('player-select-game-'+num);
  }
  const name = game.querySelector('.player-select-name');

  // Partida existente
  if (name.innerHTML!=''){
    document.location.href = '/game/'+selectedGameId;
  }
  else{
    // Partida nueva
    showAddGame();
  }
}

/*
 * Función para mostrar el formulario de crear nueva partida
 */
function showAddGame(){
  const name = document.getElementById('new-game-name');
  name.value = '';
  document.getElementById('new-game').classList.add('new-game-show');
  name.focus();
}

/*
 * Función para cerrar el cuadro de añadir nueva partida
 */
function closeAddGame(e){
  e.preventDefault();
  document.getElementById('new-game').classList.remove('new-game-show');
}

/*
 * Función para crear una nueva partida
 */
function sendAddGame(e){
  e.preventDefault();
  const name = document.getElementById('new-game-name');
  if (name.value==''){
    alert('¡No puedes dejar el nombre en blanco!');
    name.focus();
    return false;
  }

  postAjax('/api/new-game', {id: selectedGameId, name: urlencode(name.value)}, sendAddGameSuccess);
}

/*
 * Función de respuesta al crear una nueva partida
 */
function sendAddGameSuccess(data){
  if (data.status=='ok'){
    document.location.href = '/game/'+selectedGameId;
  }
  else{
    alert('¡Ocurrió un error!');
  }
}