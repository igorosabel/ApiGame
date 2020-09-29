/*
 * Función que espera a que la página se haya cargado para empezar el juego
 */
window.onload = function() {
	start();
};

/*
 * Valores generales
 */
const Val = {
	step: 10,
	cell: {
		width: 0,
		height: 0
	}
};

/*
 * Función que inicia el juego: pinta el escenario, carga al jugador y atiende a los eventos del teclado
 */
function start() {
	board = document.getElementById('board');
	loadScenario();
	loadCellDetails();
	loadBlockers();
	player.load();

	document.body.addEventListener('keydown', controller);
}

/*
 * Mapa del juego
 */
let board = null;

/*
 * Objetos del escenario bloqueantes
 */
const blockers = [];

/*
 * Función para dibujar el escenario
 */
function loadScenario() {
	board.innerHTML = '';
	// Líneas
	for (let y in scenario) {
		const scn_row = scenario[y];
		let row = document.createElement('div');
		row.id = 'row_'+y;
		row.className = 'row';

		board.appendChild(row);

		// Columnas
		for (let x in scn_row) {
			const scn_col = scn_row[x];
			let col = document.createElement('div');
			col.id = 'cell_'+x+'_'+y;
			col.dataset.x = x;
			col.dataset.y = y;

			row.appendChild(col);
			updateCell(x,y);
		}
	}
}

/*
 * Función para dibujar una casilla concreta
 */
function updateCell(x ,y) {
	const cell = document.getElementById('cell_' + x + '_' + y);
	cell.innerHTML = '';
	cell.className = 'cell';
	if (scenario[y][x].bck) {
		cell.classList.add(backgrounds.list['bck_' + scenario[y][x].bck].class);
	}
	if (scenario[y][x].spr) {
		const spr = document.createElement('div');
		spr.className = 'sprite ' + sprites.list['spr_' + scenario[y][x].spr].class;
		cell.appendChild(spr);
	}
}

/*
 * Función para obtener los detalles de una casilla
 */
function loadCellDetails() {
	const cell = document.getElementById('cell_0_0');
	Val.cell.width = cell.offsetWidth;
	Val.cell.height = cell.offsetHeight;
}

let modo_debug = false;

/*
 * Función para crear la lista de objetos bloqueantes
 */
function loadBlockers() {
	const cells = board.querySelectorAll('.cell');
	cells.forEach((cell) => {
		const bck = scenario[cell.dataset.y][cell.dataset.x].bck;
		const spr = scenario[cell.dataset.y][cell.dataset.x].spr;
		let isBlocker = false;
		if (bck && backgrounds.list['bck_' + bck] && backgrounds.list['bck_' + bck].crossable===false) {
			isBlocker = true;
		}
		if (spr && sprites.list['spr_' + spr] && sprites.list['spr_' + spr].crossable===false) {
			isBlocker = true;
		}
		if (isBlocker) {
			blockers.push({
				pos_x: parseInt(cell.dataset.x),
				pos_y: parseInt(cell.dataset.y),
				x: cell.offsetLeft,
				width: cell.offsetWidth,
				y: cell.offsetTop,
				height: cell.offsetHeight,
				cell: cell
			})
		}
	});
}

/*
 * Función para mover al personaje por el escenario
 */
function controller(e) {
	const key = e.keyCode;
	const controls = [37, 38, 39, 40];
	if (controls.indexOf(key)!=-1) {
		switch(key) {
			// Izquierda
			case 37: {
				player.moveLeft();
			}
			break;
			// Derecha
			case 39: {
				player.moveRight();
			}
			break;
			// Arriba
			case 38: {
				player.moveUp();
			}
			break;
			// Abajo
			case 40: {
				player.moveDown();
			}
			break;
		}
	}
}