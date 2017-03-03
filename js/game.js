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
  loadScenario();
  loadPlayer();

  document.body.addEventListener('keydown',playerMove);
}

/*
 * Modo debug: muestra la cuadrícula
 */
var debug = true;

/*
 * Listado de casillas especiales y sus peculiaridades
 */
var tile_types = {
  forest: {class: 'forest', cross: false},
  river:  {class: 'river',  cross: false},
  rock:   {class: 'rock',   cross: false}
};

/*
 * Escenario: cuadrícula de 32x32
 *   Objeto vacío: casilla normal, se puede recorrer
 *   Objeto con 'type': casilla especial, se aplica lo que ponga en tile_types
 */
var scenario = [
  [{type:'rock'},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{}],
  [{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{}],
  [{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{}],
  [{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{}],
  [{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{}],
  [{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{}],
  [{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{}],
  [{type:'forest'},{type:'forest'},{type:'forest'},{type:'forest'},{type:'forest'},{type:'forest'},{type:'forest'},{type:'forest'},{type:'forest'},{type:'forest'},{type:'forest'},{type:'forest'},{type:'forest'},{type:'forest'},{},{},{type:'forest'},{type:'forest'},{type:'forest'},{type:'forest'},{type:'forest'},{type:'forest'},{type:'forest'},{type:'forest'},{type:'forest'},{type:'forest'},{type:'forest'},{type:'forest'},{type:'forest'},{type:'forest'},{type:'forest'},{type:'forest'}],
  [{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{}],
  [{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{}],
  [{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{}],
  [{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{}],
  [{type:'river'},{type:'river'},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{}],
  [{},{},{type:'river'},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{}],
  [{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{}],
  [{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{}],
  [{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{}],
  [{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{}],
  [{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{}],
  [{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{}],
  [{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{}],
  [{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{}],
  [{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{}],
  [{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{}],
  [{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{}],
  [{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{}],
  [{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{}],
  [{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{}],
  [{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{}],
  [{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{}],
  [{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{}],
  [{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{}]
];

/*
 * Objeto que contiene al jugador
 */
var player = {
  position: {x:20,y:15},
  orientation: 'right'
}

/*
 * Función para dibujar el escenario
 */
function loadScenario(){
  document.body.innerHTML = '';
  // Líneas
  for (var i in scenario){
    var scn_row = scenario[i];
    var row = document.createElement('div');
    row.id = 'row_'+i;
    row.className = 'row';
    // Columnas
    for (var j in scn_row){
      var scn_col = scn_row[j];
      var col = document.createElement('div');
	    col.id = 'cell_'+i+'_'+j;
      col.classList.add('cell');
	    // Si la casilla tiene algun tipo especial se lo añado
	    if (scn_col.type){
	      col.classList.add(tile_types[scn_col.type].class);
	    }
	    if (debug){
	      col.classList.add('debug');
	    }
      row.appendChild(col);
    }
    document.body.appendChild(row);
  }
}

/*
 * Función para cargar al jugador en el escenario
 */
function loadPlayer(){
  var obj = document.createElement('div');
  obj.id = 'player';
  obj.className = 'player';
  obj.classList.add('player_'+player.orientation);

  var where = document.getElementById('cell_'+player.position.x+'_'+player.position.y);
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
	    }
	    break;
	    // Abajo
	    case 40: {
	      if (new_pos.x==31){
	        return false;
	      }
	      new_pos.x++;
	    }
	    break;
    }
    // Busco casilla de destino
    var new_pos_tile = scenario[new_pos.x][new_pos.y];
    if (new_pos_tile.type){
      // Si la casilla de destino no se puede cruzar, fuera
      if (!tile_types[new_pos_tile.type].cross){
	      return false;
	    }
    }
    player.position    = new_pos;
    var obj_player = document.getElementById('player');
    
    obj_player.classList.remove('player_'+player.orientation);
    obj_player.classList.add('player_'+orientation);
    
    player.orientation = orientation;
    var dest = document.getElementById('cell_'+player.position.x+'_'+player.position.y);
    dest.appendChild(obj_player);
  }
}