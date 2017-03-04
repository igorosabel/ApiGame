window.onload = function(){
  const addBtn   = document.getElementById('add-btn');
  const closeBtn = document.getElementById('add-scn-close');
  const saveBtn  = document.getElementById('new-scn-go');
  const board    = document.getElementById('board');
  const boardMenuBtn   = document.getElementById('board-menu-close');
  const boardMenuItems = document.querySelectorAll('.board-menu-title');
  const bcks = document.querySelectorAll('.board-menu-bcks');
  const saveScnBtn = document.getElementById('save-scn');
  
  addBtn   && addBtn.addEventListener('click', showAddBox);
  closeBtn && closeBtn.addEventListener('click', closeAddBox);
  saveBtn  && saveBtn.addEventListener('click', newScenario);
  
  board && loadScenario();
  
  boardMenuBtn && boardMenuBtn.addEventListener('click', boardMenuClose);
  boardMenuItems.forEach(item => item.addEventListener('click', openMenuItem));
  bcks.forEach(item => item.addEventListener('click', selectBck));
  saveScnBtn && saveScnBtn.addEventListener('click', saveScenario);
};

function showAddBox(e){
  e.preventDefault();
  const ovl = document.getElementById('add-scn');
  let txt = document.getElementById('new-scn-name');
  
  txt.value = '';
  ovl.classList.add('add-box-show');
  txt.focus();
}

function closeAddBox(e){
  if (e){ e.preventDefault(); }
  document.getElementById('add-scn').classList.remove('add-box-show');
}

function newScenario(){
  const txt = document.getElementById('new-scn-name');
  if (txt.value==''){
    alert('¡No puedes dejar el nombre del escenario en blanco!');
    txt.focus();
    return false;
  }
  
  postAjax('/api/new-scenario', {name: urlencode(txt.value)}, newScenarioSuccess);
}

function newScenarioSuccess(data){
  if (data.status=='ok'){
    const scn = template('scn-tpl',{id: data.id, name: urldecode(data.name), slug: slugify(urldecode(data.name))});
    document.getElementById('scn-list').innerHTML += scn;
    closeAddBox();
  }
  else{
    alert('¡Ocurrió un error al guardar el nuevo escenario!');
  }
}

/*
  800 - 24
  600 - 18
*/

/*
 * Modo debug: muestra la cuadrícula
 */
var debug = true;

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
  
  const cells = board.querySelectorAll('.cell');
  cells.forEach(cell => cell.addEventListener('click', selectCell));
}

/*
 * Todo guardado
 */
let allSaved = true;

/*
 * Casilla seleccionada
 */
const selectedCell = {x: null, y: null};

/*
 * Función para seleccionar una casilla
 */
function selectCell(e){
  const cell = e.target;
  
  const id = cell.id.replace('cell_', '');
  var [x,y] = id.split('_');
  selectedCell.x = x;
  selectedCell.y = y;
  
  const cells = document.querySelectorAll('.cell');
  cells.forEach(cell => cell.classList.remove('cell-selected'));
  
  cell.classList.add('cell-selected');
  
  document.getElementById('cell-x').innerHTML = x;
  document.getElementById('cell-y').innerHTML = y;
  
  document.getElementById('menu').classList.add('board-menu-open');
}

/*
 * Función para cerrar el menú lateral
 */
function boardMenuClose(e){
  e.preventDefault();
  document.getElementById('menu').classList.remove('board-menu-open');
  const titles = document.querySelectorAll('.board-menu-title');
  titles.forEach(title => title.classList.remove('board-menu-title-open'));
  const rows = document.querySelectorAll('.board-menu-row');
  rows.forEach(row => row.classList.remove('board-menu-row-open'));
  const cells = document.querySelectorAll('.cell');
  cells.forEach(cell => cell.classList.remove('cell-selected'));
}

function openMenuItem(e){
  const title = e.target;
  const id = title.id.replace('board-menu-', '');
  const rows = document.querySelectorAll('.board-menu-'+id);
  
  if (!title.classList.contains('board-menu-title-open')){
    title.classList.add('board-menu-title-open');
    rows.forEach(row => row.classList.add('board-menu-row-open'));
  }
  else{
    title.classList.remove('board-menu-title-open');
    rows.forEach(row => row.classList.remove('board-menu-row-open'));
  }
}

/*
 * Función para añadir un fono a una casilla
 */
function selectBck(e){
  e.stopPropagation();
  var bck = e.target;
  var id = parseInt(bck.dataset.id);
  console.log(id);
  
  scenario[selectedCell.x][selectedCell.y].bck = id;
  const cell = document.getElementById('cell_'+selectedCell.x+'_'+selectedCell.y);
  cell.className = 'cell debug cell-selected';
  cell.classList.add(backgrounds['bck_'+id].class);
  
  setAllSaved(false);
}

/*
 * Función para habilitar/deshabilitar el botón de guardado
 */
function setAllSaved(mode){
  const btn = document.getElementById('save-scn');
  allSaved = mode;
  if (allSaved){
    btn.classList.add('save-scn-disabled');
  }
  else{
    btn.classList.remove('save-scn-disabled');
  }
}

/*
 * Función para guardar el escenario
 */
function saveScenario(e){
  e.preventDefault();
  if (allSaved){ return true; }
  
  const name = document.getElementById('scn-name');
  if (name.value==''){
    alert('¡No puedes dejar el nombre del escenario en blanco!');
    name.focus();
    return false;
  }
  
  postAjax('/api/save-scenario', {id: idScenario, name: urlencode(name.value), scenario: JSON.stringify(scenario)}, saveScenarioSuccess);
}

/*
 * Función de respuesta al guardar un escenario
 */
function saveScenarioSuccess(data){
  setAllSaved(true);
}