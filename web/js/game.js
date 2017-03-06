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
  player.load();

  document.body.addEventListener('keydown',controller);
}

/*
 * Mapa del juego
 */
let board = null;

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
    
    board.appendChild(row);
    
    // Columnas
    for (let j in scn_row){
      const scn_col = scn_row[j];
      let col = document.createElement('div');
	    col.id = 'cell_'+i+'_'+j;
	    
	    row.appendChild(col);
	    updateCell(i,j);
    }
  }
}

/*
 * Función para dibujar una casilla concreta
 */
function updateCell(x,y){
  const cell = document.getElementById('cell_'+x+'_'+y);
  cell.innerHTML = '';
  cell.className = 'cell';
  if (scenario[x][y].bck){
    cell.classList.add(backgrounds.list['bck_'+scenario[x][y].bck].class);
  }
  if (scenario[x][y].spr){
    const spr = document.createElement('div');
    spr.className = 'sprite ' + sprites.list['spr_'+scenario[x][y].spr].class;
    cell.appendChild(spr);
  }
}

/*
 * Función para mover al personaje por el escenario
 */
function controller(e){
  const key = e.keyCode;
  const controls = [37,38,39,40];
  if (controls.indexOf(key)!=-1){
    switch(key){
      // Izquierda
      case 37:{
	      player.moveLeft();
	    }
	    break;
	    // Derecha
	    case 39:{
	      player.moveRight();
	    }
	    break;
	    // Arriba
	    case 38:{
	      player.moveUp();
	    }
	    break;
	    // Abajo
	    case 40:{
	      player.moveDown();
	    }
	    break;
    }
  }
}