window.onload = function(){
  const addBtn   = document.getElementById('add-btn');
  const closeBtn = document.getElementById('add-scn-close');
  const saveBtn  = document.getElementById('new-scn-go');
  const board    = document.getElementById('board');
  const boardMenuBtn   = document.getElementById('board-menu-close');
  const boardMenuTitles = document.querySelectorAll('.board-menu-title');
  const boardMenuSubTitles = document.querySelectorAll('.board-menu-subtitle');
  const bcks = document.querySelectorAll('.board-menu-row-bck');
  const sprs = document.querySelectorAll('.board-menu-row-spr');
  const saveScnBtn = document.getElementById('save-scn');
  
  addBtn   && addBtn.addEventListener('click', showAddBox);
  closeBtn && closeBtn.addEventListener('click', closeAddBox);
  saveBtn  && saveBtn.addEventListener('click', newScenario);
  
  board && loadScenario();
  
  boardMenuBtn && boardMenuBtn.addEventListener('click', boardMenuClose);
  boardMenuTitles.forEach(item => item.addEventListener('click', openMenuTitle));
  boardMenuSubTitles.forEach(item => item.addEventListener('click', openMenuSubtitle));
  bcks.forEach(item => item.addEventListener('click', selectBck));
  sprs.forEach(item => item.addEventListener('click', selectSpr));
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
    document.getElementById('scn-list').innerHTML += template('scn-tpl',{id: data.id, name: urldecode(data.name), slug: slugify(urldecode(data.name))});
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
	    updateCell(i,j,false);
    }
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
  const [x,y] = id.split('_');
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

function openMenuTitle(e){
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

function openMenuSubtitle(e){
  const title = e.target;
  const id = title.id.replace('board-menu-', '');
  const rows = document.querySelectorAll('.board-menu-'+id);
  
  if (!title.classList.contains('board-menu-subtitle-open')){
    title.classList.add('board-menu-subtitle-open');
    rows.forEach(row => row.classList.add('board-menu-row-open'));
  }
  else{
    title.classList.remove('board-menu-subtitle-open');
    rows.forEach(row => row.classList.remove('board-menu-row-open'));
  }
}

/*
 * Función para añadir un fono a una casilla
 */
function selectBck(e){
  e.stopPropagation();
  const bck = e.target;

  scenario[selectedCell.x][selectedCell.y].bck = parseInt(bck.dataset.id);
  updateCell(selectedCell.x,selectedCell.y,true);
  
  setAllSaved(false);
}

/*
 * Función para añadir un sprite a una casilla
 */
function selectSpr(e){
  e.stopPropagation();
  const spr = e.target;

  scenario[selectedCell.x][selectedCell.y].spr = parseInt(spr.dataset.id);
  updateCell(selectedCell.x,selectedCell.y,true);
  
  setAllSaved(false);
}

/*
 * Función para dibujar una casilla concreta
 */
function updateCell(x,y,sel){
  const cell = document.getElementById('cell_'+x+'_'+y);
  cell.innerHTML = '';
  cell.className = 'cell debug';
  if (sel){
    cell.classList.add('cell-selected');
  }
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
function saveScenarioSuccess(){
  setAllSaved(true);
}