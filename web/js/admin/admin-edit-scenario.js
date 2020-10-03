const board   = document.getElementById('board');
const options = document.querySelectorAll('.scenario-menu-option');
const cellDetailClose = document.getElementById('cell-detail-close');
const cellDetailBck   = document.getElementById('cell-detail-background');
const cellDetailSpr   = document.getElementById('cell-detail-sprite');
const cellDetailInt   = document.getElementById('cell-detail-interactive');
const selectBckClose  = document.getElementById('select-background-close');
const selectSprClose  = document.getElementById('select-sprite-close');
const selectIntClose  = document.getElementById('select-interactive-close');
const detailTitles    = document.querySelectorAll('.cell-detail-title');
const detailItems     = document.querySelectorAll('.cell-detail-item');
const detailDelBck    = cellDetailBck.querySelector('.cell-detail-option-delete');
const detailDelSpr    = cellDetailSpr.querySelector('.cell-detail-option-delete');
const menuPaint       = document.querySelector('.scenario-menu-paint-sample');
const menuPaintLast   = document.querySelector('.scenario-menu-paint-last');
let startMark         = null;
const scnName         = document.getElementById('scn-name');
const scnInitial      = document.getElementById('scn-initial');
const saveScnBtn      = document.getElementById('save-scn');

options.forEach(opt => opt.addEventListener('click', changeOption));
cellDetailClose.addEventListener('click', closeCellDetail);
cellDetailBck.querySelector('.cell-detail-option-sample').addEventListener('click', showBackgrounds);
cellDetailSpr.querySelector('.cell-detail-option-sample').addEventListener('click', showSprites);
cellDetailInt.querySelector('.cell-detail-option-sample').addEventListener('click', showInteractives);
selectBckClose.addEventListener('click', closeSelectBck);
selectSprClose.addEventListener('click', closeSelectSpr);
selectIntClose.addEventListener('click', closeSelectInt);
detailTitles.forEach(tit => tit.addEventListener('click', deployGroup));
detailItems.forEach(item => item.addEventListener('click', selectItem));
detailDelBck.addEventListener('click', deleteSelectBck);
detailDelSpr.addEventListener('click', deleteSelectSpr);
menuPaint.addEventListener('click', showBackgrounds);
scnName.addEventListener('keyup',function(){ setAllSaved(false); });
scnInitial.addEventListener('click',function(){ setAllSaved(false); });
saveScnBtn.addEventListener('click', saveScenario);

loadScenario();

/*
 800 - 24
 600 - 18
 */

/*
 * Función para dibujar el escenario
 */
function loadScenario() {
	scnName.value      = scn.name;
	scnInitial.checked = scn.initial;
	board.innerHTML = '';
	// Líneas
	for (let i in scenario) {
		const scn_row = scenario[i];
		let row = document.createElement('div');
		row.id = 'row_' + i;
		row.className = 'row';

		board.appendChild(row);

		// Columnas
		for (let j in scn_row) {
			const scn_col = scn_row[j];
			let col = document.createElement('div');
			col.id = 'cell_' + i + '_' + j;

			row.appendChild(col);
			updateCell(i, j, false);
		}
	}

	const cells = board.querySelectorAll('.cell');
	cells.forEach(cell => cell.addEventListener('click', selectCell));

	// Casilla de salida
	const start = document.createElement('div');
	start.id = 'start-cell';
	start.className = 'start-cell';
	start.style.display = 'none';
	document.getElementById('cell_' + scn.start_x + '_' + scn.start_y).appendChild(start);
	startMark = document.getElementById('start-cell');
}

/*
 * Función para dibujar una casilla concreta
 */
function updateCell(x, y, sel) {
	const cell = document.getElementById('cell_' + x + '_' + y);
	cell.dataset.x = x;
	cell.dataset.y = y;
	cell.innerHTML = '';
	cell.className = 'cell debug';
	if (sel) {
		cell.classList.add('cell-selected');
	}

	if (scenario[x][y].bck) {
		const bck_ind = 'bck_' + scenario[x][y].bck;
		if (backgrounds.list[bck_ind]) {
			cell.classList.add(backgrounds.list[bck_ind].class);
		}
	}
	if (scenario[x][y].spr) {
		if (sprites.list['spr_'+scenario[x][y].spr]) {
			const spr = document.createElement('div');
			spr.className = 'sprite ' + sprites.list['spr_' + scenario[x][y].spr].class;
			cell.appendChild(spr);
		}
		else {
			delete scenario[x][y].spr;
		}
	}
}

/*
 * Herramienta seleccionada
 */
let selectedOption = 'select';

/*
 * Función para cambiar entre las opciones
 */
function changeOption() {
	const opt = this;
	options.forEach(opt => opt.classList.remove('scenario-menu-option-selected'));
	opt.classList.add('scenario-menu-option-selected');

	const label      = document.querySelector('.scenario-menu-option-label');
	const sample     = document.querySelector('.scenario-menu-paint-sample');
	const sampleName = document.querySelector('.scenario-menu-paint-sample-name');

	document.querySelectorAll('.scenario-menu-option-group').forEach(grp => grp.style.display='none');
	startMark.style.display = 'none';

	selectedOption = opt.dataset.id;

	switch (opt.dataset.id) {
		case 'select': {
			label.innerHTML = 'Seleccionar';
		}
		break;
		case 'paint': {
			label.innerHTML = 'Pintar';
			document.querySelector('.scenario-menu-option-group[data-id="paint"]').style.display = 'block';
		}
		break;
		case 'clear': {
			label.innerHTML = 'Borrar';
		}
		break;
		case 'start': {
			label.innerHTML         = 'Posición inicial';
			startMark.style.display = 'block';
		}
		break;
		case 'connectors': {
			label.innerHTML = 'Conectores';
		}
		break;
		case 'data': {
			label.innerHTML = 'Datos';
			document.querySelector('.scenario-menu-option-group[data-id="data"]').style.display = 'block';
		}
		break;
	}
}

/*
 * Celda que se está editando
 */
const selectedCell = {x: null, y: null};

/*
 * Marca si el escenario está guardado
 */
let allSaved = true;

/*
 * Fondo que se quiere pintar
 */
let paintBck = null;

/*
 * Lista de últimos fondos usados
 */
const paintBckList = [];

/*
 * Función para interactuar con una casilla
 */
function selectCell() {
	const cell = this;

	switch (selectedOption) {
		case 'select': {
			selectedCell.x = cell.dataset.x;
			selectedCell.y = cell.dataset.y;

			document.getElementById('cell-detail-name').innerHTML = 'Casilla ' + cell.dataset.x + '-' + cell.dataset.y;

			const detail_bck        = document.getElementById('cell-detail-background');
			const detail_bck_sample = detail_bck.querySelector('.cell-detail-option-sample');
			const detail_bck_name   = detail_bck.querySelector('.cell-detail-option-name');
			const detail_bck_del    = detail_bck.querySelector('.cell-detail-option-delete');
			const detail_spr        = document.getElementById('cell-detail-sprite');
			const detail_spr_sample = detail_spr.querySelector('.cell-detail-option-sample');
			const detail_spr_name   = detail_spr.querySelector('.cell-detail-option-name');
			const detail_spr_del    = detail_spr.querySelector('.cell-detail-option-delete');

			if (scenario[selectedCell.x][selectedCell.y].bck) {
				const bck = backgrounds.list['bck_' + scenario[selectedCell.x][selectedCell.y].bck];
				detail_bck_sample.className = 'cell-detail-option-sample ' + bck.class;
				detail_bck_name.innerHTML = urldecode(bck.name);
				detail_bck_name.style.display = 'block';
				detail_bck_del.style.display  = 'block';
			}
			else {
				detail_bck_sample.className = 'cell-detail-option-sample';
				detail_bck_name.innerHTML = '';
				detail_bck_name.style.display = 'none';
				detail_bck_del.style.display  = 'none';
			}

			if (scenario[selectedCell.x][selectedCell.y].spr) {
				const spr = sprites.list['spr_' + scenario[selectedCell.x][selectedCell.y].spr];
				detail_spr_sample.className = 'cell-detail-option-sample '+spr.class;
				detail_spr_name.innerHTML = urldecode(spr.name);
				detail_spr_name.style.display = 'block';
				detail_spr_del.style.display  = 'block';
			}
			else {
				detail_spr_sample.className = 'cell-detail-option-sample';
				detail_spr_name.innerHTML = '';
				detail_spr_name.style.display = 'none';
				detail_spr_del.style.display  = 'none';
			}

			document.querySelector('.scenario-overlay').style.display = 'block';
			const cellDetail = document.getElementById('cell-detail');
			cellDetail.style.display = 'block';
		}
		break;
		case 'paint': {
			scenario[cell.dataset.x][cell.dataset.y].bck = paintBck.id;
			updateCell(cell.dataset.x, cell.dataset.y, false);
			setAllSaved(false);
		}
		break;
		case 'clear': {
			scenario[cell.dataset.x][cell.dataset.y] = {};
			cell.className = 'cell debug';
			cell.innerHTML = '';
			setAllSaved(false);
		}
		break;
		case 'start': {
			const dest = document.getElementById('cell_' + cell.dataset.x + '_' + cell.dataset.y);
			dest.appendChild(startMark);
			scn.start_x = parseInt(cell.dataset.x);
			scn.start_y = parseInt(cell.dataset.y);
			setAllSaved(false);
		}
		break;
	}
}

/*
 * Función para cerrar el detalle de una casilla
 */
function closeCellDetail() {
	document.getElementById('cell-detail').style.display = 'none';
	document.querySelector('.scenario-overlay').style.display = 'none';
}

/*
 * Función para mostrar la lista de fondos
 */
function showBackgrounds() {
	document.getElementById('cell-detail').style.display = 'none';
	document.querySelector('.scenario-overlay').style.display = 'block';
	document.getElementById('select-background').style.display = 'block';
}

/*
 * Función para mostrar la lista de sprites
 */
function showSprites() {
	document.getElementById('cell-detail').style.display = 'none';
	document.querySelector('.scenario-overlay').style.display = 'block';
	document.getElementById('select-sprite').style.display = 'block';
}

/*
 * Función para mostrar la lista de elementos interactivos
 */
function showInteractives() {
	document.getElementById('cell-detail').style.display = 'none';
	document.querySelector('.scenario-overlay').style.display = 'block';
	document.getElementById('select-interactive').style.display = 'block';
}

/*
 * Función para cerrar la lista de fondos
 */
function closeSelectBck() {
	document.getElementById('select-background').style.display = 'none';
	if (selectedOption=='select') {
		document.getElementById('cell-detail').style.display = 'block';
	}
	else {
		document.querySelector('.scenario-overlay').style.display = 'none';
	}
}

/*
 * Función para cerrar la lista de sprites
 */
function closeSelectSpr() {
	document.getElementById('select-sprite').style.display = 'none';
	document.getElementById('cell-detail').style.display = 'block';
}

/*
 * Función para cerrar la lista de elementos interactivos
 */
function closeSelectInt() {
	document.getElementById('select-interactive').style.display = 'none';
	document.getElementById('cell-detail').style.display = 'block';
}

/*
 * Función para mostrar/ocultar un grupo
 */
function deployGroup() {
	const title = this;
	const id = title.id.replace('select-', '');
	const group = document.getElementById('select-group-' + id);
	if (!title.classList.contains('cell-detail-title-open')) {
		title.classList.add('cell-detail-title-open');
		group.classList.add('cell-detail-group-open');
	}
	else {
		title.classList.remove('cell-detail-title-open');
		group.classList.remove('cell-detail-group-open');
	}
}

/*
 * Función para seleccionar un fondo o un sprite
 */
function selectItem() {
	const item = this;
	let obj           = null;
	let detail        = null;
	let detail_sample = null;
	let detail_name   = null;
	let detail_del    = null;

	if (item.dataset.type=='bck') {
		obj = backgrounds.list['bck_' + item.dataset.id];
		if (selectedOption=='select') {
			detail        = document.getElementById('cell-detail-background');
			detail_sample = detail.querySelector('.cell-detail-option-sample');
			detail_name   = detail.querySelector('.cell-detail-option-name');
			detail_del    = detail.querySelector('.cell-detail-option-delete');

			detail_sample.className   = 'cell-detail-option-sample ' + obj.class;
			detail_name.innerHTML     = urldecode(obj.name);
			detail_name.style.display = 'block';
			detail_del.style.display  = 'block';

			scenario[selectedCell.x][selectedCell.y].bck = obj.id;
			updateCell(selectedCell.x, selectedCell.y, false);
			setAllSaved(false);
		}
		if (selectedOption=='paint') {
			paintBck = obj;
			menuPaint.className = 'scenario-menu-paint-sample ' + paintBck.class;
			const menuPaintName = document.querySelector('.scenario-menu-paint-sample-name');
			menuPaintName.innerHTML = urldecode(obj.name);
			menuPaintName.style.display = 'block';

			let inList = false;
			for (let i in paintBckList) {
				if (paintBckList[i].id==obj.id) {
					inList = true;
				}
			}
			if (!inList) {
				paintBckList.unshift(obj);
				if (paintBckList.length > 9) {
					paintBckList.splice(9, 1);
				}
			}
			updatePaintBckList();
		}
		closeSelectBck();
	}
	if (item.dataset.type=='spr') {
		obj = sprites.list['spr_' + item.dataset.id];
		detail = document.getElementById('cell-detail-sprite');
		detail_sample = detail.querySelector('.cell-detail-option-sample');
		detail_name   = detail.querySelector('.cell-detail-option-name');
		detail_del    = detail.querySelector('.cell-detail-option-delete');

		detail_sample.className   = 'cell-detail-option-sample ' + obj.class;
		detail_name.innerHTML     = urldecode(obj.name);
		detail_name.style.display = 'block';
		detail_del.style.display  = 'block';

		scenario[selectedCell.x][selectedCell.y].spr = obj.id;
		updateCell(selectedCell.x, selectedCell.y, false);
		setAllSaved(false);
		closeSelectSpr();
	}
	if (item.dataset.type=='int') {
		console.log(item);
		obj = interactives['int_' + item.dataset.id];
		console.log(obj);
	}
}

/*
 * Función para cargar la lista de últimos fondos usados
 */
function updatePaintBckList() {
	menuPaintLast.innerHTML = '';
	for (let i in paintBckList) {
		let bck = document.createElement('div');
		bck.id = 'paint-last-bck-' + paintBckList[i].id;
		bck.className = 'scenario-menu-paint-item ' + paintBckList[i].class;
		bck.addEventListener('click', selectFromPaintList);

		menuPaintLast.appendChild(bck);
	}
	menuPaintLast.style.display = 'block';
}

/*
 * Función para seleccionar un elemento de la lista de últimos
 */
function selectFromPaintList() {
	const item = this;
	const id = item.id.replace('paint-last-bck-', '');
	const obj = backgrounds.list['bck_' + id];

	paintBck = obj;
	menuPaint.className = 'scenario-menu-paint-sample ' + paintBck.class;
	const menuPaintName = document.querySelector('.scenario-menu-paint-sample-name');
	menuPaintName.innerHTML = urldecode(obj.name);
}

/*
 * Función para quitar un fondo a una casilla
 */
function deleteSelectBck() {
	const detail_del    = this;
	const detail        = this.parentNode;
	const detail_sample = detail.querySelector('.cell-detail-option-sample');
	const detail_name   = detail.querySelector('.cell-detail-option-name');

	detail_sample.className = 'cell-detail-option-sample';
	detail_name.innerHTML = '';
	detail_name.style.display = 'none';
	detail_del.style.display  = 'none';

	delete scenario[selectedCell.x][selectedCell.y].bck;
	updateCell(selectedCell.x, selectedCell.y, false);
	setAllSaved(false);
}

/*
 * Función para quitar un sprite a una casilla
 */
function deleteSelectSpr() {
	const detail_del    = this;
	const detail        = this.parentNode;
	const detail_sample = detail.querySelector('.cell-detail-option-sample');
	const detail_name   = detail.querySelector('.cell-detail-option-name');

	detail_sample.className = 'cell-detail-option-sample';
	detail_name.innerHTML = '';
	detail_name.style.display = 'none';
	detail_del.style.display  = 'none';

	delete scenario[selectedCell.x][selectedCell.y].spr;
	updateCell(selectedCell.x, selectedCell.y, false);
	setAllSaved(false);
}

/*
 * Función para habilitar/deshabilitar el botón de guardado
 */
function setAllSaved(mode) {
	const btn = document.getElementById('save-scn');
	allSaved = mode;
	if (allSaved) {
		btn.classList.add('save-scn-disabled');
	}
	else {
		btn.classList.remove('save-scn-disabled');
	}
}

/*
 * Función para guardar el escenario
 */
function saveScenario(e) {
	e.preventDefault();
	if (allSaved) { return true; }

	if (scnName.value=='') {
		alert('¡No puedes dejar el nombre del escenario en blanco!');
		name.focus();
		return false;
	}

	const params = {
		id: scn.id,
		name: urlencode(scnName.value),
		scenario: JSON.stringify(scenario),
		start_x: scn.start_x,
		start_y: scn.start_y,
		initial: (scnInitial.checked) ? 1 : 0
	};

	postAjax('/api/save-scenario', params, saveScenarioSuccess);
}

/*
 * Función de respuesta al guardar un escenario
 */
function saveScenarioSuccess() {
	setAllSaved(true);
}