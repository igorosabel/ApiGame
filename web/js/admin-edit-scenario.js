const board   = document.getElementById('board');
const options = document.querySelectorAll('.scenario-menu-option');
const cellDetailClose = document.getElementById('cell-detail-close');
const cellDetailBck   = document.getElementById('cell-detail-background');
const cellDetailSpr   = document.getElementById('cell-detail-sprite');
const selectBckClose  = document.getElementById('select-background-close');
const selectSprClose  = document.getElementById('select-sprite-close');
const detailTitles    = document.querySelectorAll('.cell-detail-title');
const detailItems     = document.querySelectorAll('.cell-detail-item');
const detailDelBck    = cellDetailBck.querySelector('.cell-detail-option-delete');
const detailDelSpr    = cellDetailSpr.querySelector('.cell-detail-option-delete');
const menuPaint       = document.querySelector('.scenario-menu-paint-sample');
const saveScnBtn      = document.getElementById('save-scn');

options.forEach(opt => opt.addEventListener('click', changeOption));
cellDetailClose.addEventListener('click', closeCellDetail);
cellDetailBck.querySelector('.cell-detail-option-sample').addEventListener('click', showBackgrounds);
cellDetailSpr.querySelector('.cell-detail-option-sample').addEventListener('click', showSprites);
selectBckClose.addEventListener('click', closeSelectBck);
selectSprClose.addEventListener('click', closeSelectSpr);
detailTitles.forEach(tit => tit.addEventListener('click', deployGroup));
detailItems.forEach(item => item.addEventListener('click', selectItem));
detailDelBck.addEventListener('click', deleteSelectBck);
detailDelSpr.addEventListener('click', deleteSelectSpr);
menuPaint.addEventListener('click', showBackgrounds);
saveScnBtn.addEventListener('click', saveScenario);

loadScenario();

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
 * Función para dibujar una casilla concreta
 */
function updateCell(x,y,sel){
  const cell = document.getElementById('cell_'+x+'_'+y);
  cell.dataset.x = x;
  cell.dataset.y = y;
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

  selectedOption = opt.dataset.id;

  switch (opt.dataset.id){
    case 'select':{
      label.innerHTML          = 'Seleccionar';
      sample.style.display     = 'none';
      sampleName.style.display = 'none;'
    }
    break;
    case 'paint':{
      label.innerHTML          = 'Pintar';
      sample.style.display     = 'block';
      sampleName.style.display = 'block;'
    }
    break;
    case 'clear':{
      label.innerHTML          = 'Borrar';
      sample.style.display     = 'none';
      sampleName.style.display = 'none;'
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
 * Función para interactuar con una casilla
 */
function selectCell() {
  const cell = this;

  switch (selectedOption){
    case 'select':{
      selectedCell.x = cell.dataset.x;
      selectedCell.y = cell.dataset.y;

      document.getElementById('cell-detail-name').innerHTML = 'Casilla '+cell.dataset.x+'-'+cell.dataset.y;

      const detail_bck        = document.getElementById('cell-detail-background');
      const detail_bck_sample = detail_bck.querySelector('.cell-detail-option-sample');
      const detail_bck_name   = detail_bck.querySelector('.cell-detail-option-name');
      const detail_bck_del    = detail_bck.querySelector('.cell-detail-option-delete');
      const detail_spr        = document.getElementById('cell-detail-sprite');
      const detail_spr_sample = detail_spr.querySelector('.cell-detail-option-sample');
      const detail_spr_name   = detail_spr.querySelector('.cell-detail-option-name');
      const detail_spr_del    = detail_spr.querySelector('.cell-detail-option-delete');

      if (scenario[selectedCell.x][selectedCell.y].bck){
        const bck = backgrounds.list['bck_'+scenario[selectedCell.x][selectedCell.y].bck];
        detail_bck_sample.className = 'cell-detail-option-sample '+bck.class;
        detail_bck_name.innerHTML = urldecode(bck.name);
        detail_bck_name.style.display = 'block';
        detail_bck_del.style.display  = 'block';
      }
      else{
        detail_bck_sample.className = 'cell-detail-option-sample';
        detail_bck_name.innerHTML = '';
        detail_bck_name.style.display = 'none';
        detail_bck_del.style.display  = 'none';
      }

      if (scenario[selectedCell.x][selectedCell.y].spr){
        const spr = sprites.list['spr_'+scenario[selectedCell.x][selectedCell.y].spr];
        detail_spr_sample.className = 'cell-detail-option-sample '+spr.class;
        detail_spr_name.innerHTML = urldecode(spr.name);
        detail_spr_name.style.display = 'block';
        detail_spr_del.style.display  = 'block';
      }
      else{
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
    case 'paint':{
      scenario[cell.dataset.x][cell.dataset.y].bck = paintBck.id;
      updateCell(cell.dataset.x, cell.dataset.y, false);
      setAllSaved(false);
    }
    break;
    case 'clear':{
      scenario[cell.dataset.x][cell.dataset.y] = {};
      cell.className = 'cell debug';
      cell.innerHTML = '';
      setAllSaved(false);
    }
    break;
  }
}

/*
 * Función para cerrar el detalle de una casilla
 */
function closeCellDetail(){
  document.getElementById('cell-detail').style.display = 'none';
  document.querySelector('.scenario-overlay').style.display = 'none';
}

/*
 * Función para mostrar la lista de fondos
 */
function showBackgrounds(){
  document.getElementById('cell-detail').style.display = 'none';
  document.querySelector('.scenario-overlay').style.display = 'block';
  document.getElementById('select-background').style.display = 'block';
}

/*
 * Función para mostrar la lista de sprites
 */
function showSprites(){
  document.getElementById('cell-detail').style.display = 'none';
  document.querySelector('.scenario-overlay').style.display = 'block';
  document.getElementById('select-sprite').style.display = 'block';
}

/*
 * Función para cerrar la lista de fondos
 */
function closeSelectBck(){
  document.getElementById('select-background').style.display = 'none';
  if (selectedOption=='select'){
    document.getElementById('cell-detail').style.display = 'block';
  }
  else{
    document.querySelector('.scenario-overlay').style.display = 'none';
  }
}

/*
 * Función para cerrar la lista de sprites
 */
function closeSelectSpr(){
  document.getElementById('select-sprite').style.display = 'none';
  document.getElementById('cell-detail').style.display = 'block';
}

/*
 * Función para mostrar/ocultar un grupo
 */
function deployGroup(){
  const title = this;
  const id = title.id.replace('select-', '');
  const group = document.getElementById('select-group-'+id);
  if (!title.classList.contains('cell-detail-title-open')){
    title.classList.add('cell-detail-title-open');
    group.classList.add('cell-detail-group-open');
  }
  else{
    title.classList.remove('cell-detail-title-open');
    group.classList.remove('cell-detail-group-open');
  }
}

/*
 * Función para seleccionar un fondo o un sprite
 */
function selectItem(){
  const item = this;
  let obj           = null;
  let detail        = null;
  let detail_sample = null;
  let detail_name   = null;
  let detail_del    = null;
  
  if (item.dataset.type=='bck'){
    obj = backgrounds.list['bck_'+item.dataset.id];
    if (selectedOption=='select'){
      detail        = document.getElementById('cell-detail-background');
      detail_sample = detail.querySelector('.cell-detail-option-sample');
      detail_name   = detail.querySelector('.cell-detail-option-name');
      detail_del    = detail.querySelector('.cell-detail-option-delete');

      detail_sample.className   = 'cell-detail-option-sample '+obj.class;
      detail_name.innerHTML     = urldecode(obj.name);
      detail_name.style.display = 'block';
      detail_del.style.display  = 'block';

      scenario[selectedCell.x][selectedCell.y].bck = obj.id;
      updateCell(selectedCell.x,selectedCell.y,false);
      setAllSaved(false);
    }
    if (selectedOption=='paint'){
      paintBck = obj;
      menuPaint.className = 'scenario-menu-paint-sample '+paintBck.class;
      const menuPaintName = document.querySelector('.scenario-menu-paint-sample-name');
      menuPaintName.innerHTML = urldecode(obj.name);
      menuPaintName.style.display = 'block';
    }
    closeSelectBck();
  }
  if (item.dataset.type=='spr'){
    obj = sprites.list['spr_'+item.dataset.id];
    detail = document.getElementById('cell-detail-sprite');
    detail_sample = detail.querySelector('.cell-detail-option-sample');
    detail_name   = detail.querySelector('.cell-detail-option-name');
    detail_del    = detail.querySelector('.cell-detail-option-delete');

    detail_sample.className   = 'cell-detail-option-sample '+obj.class;
    detail_name.innerHTML     = urldecode(obj.name);
    detail_name.style.display = 'block';
    detail_del.style.display  = 'block';

    scenario[selectedCell.x][selectedCell.y].spr = obj.id;
    updateCell(selectedCell.x,selectedCell.y,false);
    setAllSaved(false);
    closeSelectSpr();
  }
}

/*
 * Función para quitar un fondo a una casilla
 */
function deleteSelectBck(){
  const detail_del    = this;
  const detail        = this.parentNode;
  const detail_sample = detail.querySelector('.cell-detail-option-sample');
  const detail_name   = detail.querySelector('.cell-detail-option-name');

  detail_sample.className = 'cell-detail-option-sample';
  detail_name.innerHTML = '';
  detail_name.style.display = 'none';
  detail_del.style.display  = 'none';

  delete scenario[selectedCell.x][selectedCell.y].bck;
  updateCell(selectedCell.x,selectedCell.y,false);
  setAllSaved(false);
}

/*
 * Función para quitar un sprite a una casilla
 */
function deleteSelectSpr(){
  const detail_del    = this;
  const detail        = this.parentNode;
  const detail_sample = detail.querySelector('.cell-detail-option-sample');
  const detail_name   = detail.querySelector('.cell-detail-option-name');

  detail_sample.className = 'cell-detail-option-sample';
  detail_name.innerHTML = '';
  detail_name.style.display = 'none';
  detail_del.style.display  = 'none';

  delete scenario[selectedCell.x][selectedCell.y].spr;
  updateCell(selectedCell.x,selectedCell.y,false);
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
function saveScenarioSuccess(){
  setAllSaved(true);
}