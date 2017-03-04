/*
 * Función que espera a que la página se haya cargado para empezar el juego
 */
window.onload = function(){
  start();
};

/*
 * Función que inicia el juego: pinta el escenario, carga al jugador y atiende a los eventos del teclado
 */
function start(){
  board = document.getElementById('board');
  loadScenario();
  loadPlayer();

  document.body.addEventListener('keydown',playerMove);
}

/*
 * Modo debug: muestra la cuadrícula
 */
var debug = false;

/*
 * Mapa del juego
 */
let board = null;

/*
 * Objeto que contiene al jugador
 */
const player = {
  position: {x:14,y:13},
  orientation: 'right'
}

/*
 * Función para dibujar el escenario
 */
function loadScenario(){
  board.innerHTML = '';
  // Líneas
  for (let i in scenario){
    const scn_row = scenario[i];
    let row = document.createElement('div');
    row.id = 'row_'+i;
    row.className = 'row';
    // Columnas
    for (let j in scn_row){
      const scn_col = scn_row[j];
      let col = document.createElement('div');
	    col.id = 'cell_'+i+'_'+j;
      col.classList.add('cell');
	    // Si la casilla tiene fondo se lo añado
	    if (scn_col.bck){
	      col.classList.add(backgrounds['bck_'+scn_col.bck].class);
	    }
	    if (debug){
	      col.classList.add('debug');
	    }
      row.appendChild(col);
    }
    board.appendChild(row);
  }
  
}

/*
 * Función para cargar al jugador en el escenario
 */
function loadPlayer(){
  let obj = document.createElement('div');
  obj.id = 'player';
  obj.className = 'player';
  obj.classList.add('player_'+player.orientation);

  const where = document.getElementById('cell_'+player.position.x+'_'+player.position.y);
  where.appendChild(obj);
}

/*
 * Función para mover al personaje por el escenario
 */
function playerMove(e){
  var key = e.keyCode;
  var moves = [37,38,39,40];
  if (moves.indexOf(key)!=-1){
    // Calculo nueva posición a partir de la original
    var new_pos = {
      x: player.position.x,
      y: player.position.y
    };
    var orientation = player.orientation;
    switch(key){
      // Izquierda
      case 37: {
	      if (new_pos.y==0){
	        return false;
	      }
	      new_pos.y--;
	      orientation = 'left';
	    }
	    break;
	    // Derecha
	    case 39: {
	      if (new_pos.y==31){
	        return false;
	      }
	      new_pos.y++;
	      orientation = 'right';
	    }
	    break;
	    // Arriba
	    case 38: {
	      if (new_pos.x==0){
	        return false;
	      }
	      new_pos.x--;
	      orientation = 'up';
	    }
	    break;
	    // Abajo
	    case 40: {
	      if (new_pos.x==31){
	        return false;
	      }
	      new_pos.x++;
	      orientation = 'down';
	    }
	    break;
    }
    // Busco casilla de destino
    var new_pos_tile = scenario[new_pos.x][new_pos.y];
    // Si la casilla de destino no se puede cruzar, fuera
    if (!backgrounds['bck_'+new_pos_tile.bck].crossable){
      return false;
    }
    player.position = new_pos;
    var obj_player  = document.getElementById('player');
    
    obj_player.classList.remove('player_'+player.orientation);
    obj_player.classList.add('player_'+orientation);
    
    player.orientation = orientation;
    var dest = document.getElementById('cell_'+player.position.x+'_'+player.position.y);
    dest.appendChild(obj_player);
  }
}