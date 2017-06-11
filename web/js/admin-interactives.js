const addBtn         = document.getElementById('add-btn');
const ovlInt         = document.getElementById('add-int');
const ovlSel         = document.getElementById('sel-sprite');
const addIntClose    = document.getElementById('add-int-close');
const intDel         = document.getElementById('int-delete');
const intTitle       = document.getElementById('add-int-title');

const detailStart = document.getElementById('cell-detail-sprite-start');
const detailStartName = detailStart.querySelector('.cell-detail-option-name');
const detailStartImage = detailStart.querySelector('.cell-detail-option-sample');
const detailStartDelete = detailStart.querySelector('.cell-detail-option-delete');

const detailActive = document.getElementById('cell-detail-sprite-active');
const detailActiveName = detailActive.querySelector('.cell-detail-option-name');
const detailActiveImage = detailActive.querySelector('.cell-detail-option-sample');
const detailActiveDelete = detailActive.querySelector('.cell-detail-option-delete');

const selSpriteClose = document.getElementById('sel-sprite-close');
const detailTitles   = document.querySelectorAll('.cell-detail-title');
const detailItems    = document.querySelectorAll('.cell-detail-item');
const detailDeletes  = document.querySelectorAll('.cell-detail-option .cell-detail-option-delete');
const frmInt         = document.getElementById('frm-int');
const intList        = document.getElementById('int-list');
const items          = document.querySelectorAll('.item-list li');

addBtn.addEventListener('click', showAddInteractiveBox);
addIntClose.addEventListener('click', closeAddInteractiveBox);
intDel.addEventListener('click', deleteInteractive);
detailStartImage.addEventListener('click', selectSprite);
detailActiveImage.addEventListener('click', selectSprite);
selSpriteClose.addEventListener('click', closeSelSpriteBox);
detailTitles.forEach(tit => tit.addEventListener('click', deployGroup));
detailItems.forEach(item => item.addEventListener('click', selectItem));
detailDeletes.forEach( del => del.addEventListener('click', deleteItem));
frmInt.addEventListener('submit', saveInteractive);
items.forEach(item => item.addEventListener('click', editInteractive));

/*
 * Elemento interactivo que se está editando
 */
let editInt = {
  id: 0,
  name: '',
  type: 0,
  activable: false,
  pickable: false,
  grabbable: false,
  breakable: false,
  crossable: false,
  crossable_active: false,
  sprite_start_id: 0,
  sprite_start_name: '',
  sprite_start_url: '',
  sprite_active_id: 0,
  sprite_active_name: '',
  sprite_active_url: '',
  drops: 0,
  quantity: 0,
  active_time: 0
};

/*
 * Función para mostrar el cuadro de añadir elemento interactivo
 */
function showAddInteractiveBox(e){
  e.preventDefault();
  editInt.id                 = 0;
  editInt.name               = '';
  editInt.type               = 0;
  editInt.activable          = false;
  editInt.pickable           = false;
  editInt.grabbable          = false;
  editInt.breakable          = false;
  editInt.crossable          = false;
  editInt.crossable_active   = false;
  editInt.sprite_start_id    = 0;
  editInt.sprite_start_name  = '';
  editInt.sprite_start_url   = '';
  editInt.sprite_active_id   = 0;
  editInt.sprite_active_name = '';
  editInt.sprite_active_url  = '';
  editInt.drops              = 0;
  editInt.quantity           = 0;
  editInt.active_time        = 0;
  
  showLoadedInteractive();
}

/*
 * Función para cerrar el cuadro de añadir elemento interactivo
 */
function closeAddInteractiveBox(e){
  if (e){ e.preventDefault(); }
  ovlInt.classList.remove('add-box-show');
}

/*
 * Función para mostrar en el formulario el elemento interactivo cargado
 */
function showLoadedInteractive(){
  intTitle.innerHTML = (editInt.id==0) ? 'Añadir elemento interactivo' : 'Editar elemento interactivo';
  const name            = document.getElementById('int-name');
  const type            = document.getElementById('int-type');
  const pickable        = document.getElementById('int-pickable');
  const activable       = document.getElementById('int-activable');
  const activeTime      = document.getElementById('int-active-time');
  const grabbable       = document.getElementById('int-grabbable');
  const breakable       = document.getElementById('int-breakable');
  const crossable       = document.getElementById('int-crossable');
  const crossableActive = document.getElementById('int-crossable-active');
  const drops           = document.getElementById('int-drops');
  const quantity        = document.getElementById('int-quantity');
  
  name.value              = editInt.name;
  type.value              = editInt.type;
  pickable.checked        = editInt.pickable;
  activable.checked       = editInt.activable;
  activeTime.value        = editInt.active_time;
  grabbable.checked       = editInt.grabbable;
  breakable.checked       = editInt.breakable;
  crossable.checked       = editInt.crossable;
  crossableActive.checked = editInt.crossable_active;
  drops.value             = editInt.drops;
  quantity.value          = editInt.quantity;
  
  detailStartName.innerHTML       = '';
  detailStartName.style.display   = 'none';
  detailStartImage.innerHTML      = '';
  detailStartDelete.style.display = 'none';
  if (editInt.sprite_start_id!=0){
    detailStartName.innerHTML     = editInt.sprite_start_name;
    detailStartName.style.display = 'block';
    const start_img = document.createElement('img');
    start_img.src   = editInt.sprite_start_url;
    detailStartImage.appendChild(start_img);
    detailStartDelete.style.display = 'block';
  }
  
  detailActiveName.innerHTML = '';
  detailActiveName.style.display = 'none';
  detailActiveImage.innerHTML = '';
  detailActiveDelete.style.display = 'none';
  if (editInt.sprite_active_id!=0){
    detailActiveName.innerHTML = editInt.sprite_active_name;
    detailActiveName.style.display = 'block';
    const active_img = document.createElement('img');
    active_img.src = editInt.sprite_active_url;
    detailActiveImage.appendChild(active_img);
    detailActiveDelete.style.display = 'block';
  }
  
  intDel.style.display = (editInt.id==0) ? 'none' : 'inline-block';
  
  ovlInt.classList.add('add-box-show');
  name.focus();
}

/*
 * Función para borrar un elemento interactivo
 */
function deleteInteractive(){
  const int = this;
  const conf = confirm('¿Estás seguro de querer borrar este elemento interactivo?');
  if (conf){
    postAjax('/api/delete-interactive', {id: editInt.id}, deleteInteractiveSuccess);
  }
}

/*
 * Función callback tras borrar un elemento interactivo
 */
function deleteInteractiveSuccess(data){
  const int = document.getElementById('int-'+data.id);
  int.parentNode.removeChild(int);
  closeAddInteractiveBox();
}

/*
 * Variable para indicar que tipo de sprite se está añadiendo o editando
 */
let spriteType = '';

/*
 * Función para abrir la ventana de seleccionar sprite
 */
function selectSprite(e){
  const obj = this;
  spriteType = obj.parentNode.id.replace('cell-detail-sprite-', '');
  let title = '';
  if (spriteType=='start'){
    title = 'Añadir sprite inicial';
  }
  else{
    title = 'Añadir sprite final';
  }
  document.getElementById('sel-sprite-title').innerHTML = title;
  ovlInt.classList.remove('add-box-show');
  ovlSel.classList.add('add-box-show');
}

/*
 * Función para cerrar la ventana de seleccionar sprite y volver al cuadro de añadir sprite
 */
function closeSelSpriteBox(e){
  if (e){ e.preventDefault(); }
  ovlSel.classList.remove('add-box-show');
  ovlInt.classList.add('add-box-show');
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
 * Función para seleccionar un sprite
 */
function selectItem(){
  const obj = this;
  
  editInt['sprite_'+spriteType+'_id'] = parseInt(obj.dataset.id);
  
  if (spriteType=='start'){
    editInt.sprite_start_name = sprites_json['spr_'+editInt.sprite_start_id].name;
    editInt.sprite_start_url  = sprites_json['spr_'+editInt.sprite_start_id].url;
    
    detailStartName.innerHTML = editInt.sprite_start_name;
    detailStartName.style.display = 'block';
    detailStartImage.innerHTML = '';
    const start_img = document.createElement('img');
    start_img.src = editInt.sprite_start_url;
    detailStartImage.appendChild(start_img);
    detailStartDelete.style.display = 'block';
  }
  else{
    editInt.sprite_active_name = sprites_json['spr_'+editInt.sprite_active_id].name;
    editInt.sprite_active_url  = sprites_json['spr_'+editInt.sprite_active_id].url;
    
    detailActiveName.innerHTML = editInt.sprite_active_name;
    detailActiveName.style.display = 'block';
    detailActiveImage.innerHTML = '';
    const active_img = document.createElement('img');
    active_img.src = editInt.sprite_active_url;
    detailActiveImage.appendChild(active_img);
    detailActiveDelete.style.display = 'block';
  }
  
  closeSelSpriteBox();
}

/*
 * Función para quitar un sprite seleccionado
 */
function deleteItem(e){
  const spr = e.target.parentNode;
  spriteType = spr.id.replace('cell-detail-sprite-','');
  
  editInt['sprite_'+spriteType+'_id'] = 0;
  editInt['sprite_'+spriteType+'_name'] = '';
  editInt['sprite_'+spriteType+'_url'] = '';
  
  if (spriteType=='start'){
    detailStartName.innerHTML       = '';
    detailStartName.style.display   = 'none';
    detailStartImage.innerHTML      = '';
    detailStartDelete.style.display = 'none';
  }
  else{
    detailActiveName.innerHTML       = '';
    detailActiveName.style.display   = 'none';
    detailActiveImage.innerHTML      = '';
    detailActiveDelete.style.display = 'none';
  }
}

/*
 * Función para guardar un elemento interactivo
 */
function saveInteractive(e){
  e.preventDefault();
  const name = document.getElementById('int-name');
  if (name.value===''){
    alert('¡No puedes dejar el nombre del elemento en blanco!');
    name.focus();
    return false;
  }
  if (editInt.sprite_start_id===0){
    alert('¡No has elegido sprite inicial!');
    return false;
  }
  
  editInt.name               = name.value;
  editInt.type               = document.getElementById('int-type').value;
  editInt.activable          = document.getElementById('int-activable').checked;
  editInt.pickable           = document.getElementById('int-pickable').checked;
  editInt.grabbable          = document.getElementById('int-grabbable').checked;
  editInt.breakable          = document.getElementById('int-breakable').checked;
  editInt.crossable          = document.getElementById('int-crossable').checked;
  editInt.crossable_active   = document.getElementById('int-crossable-active').checked;
  editInt.drops              = document.getElementById('int-drops').value;
  editInt.quantity           = document.getElementById('int-quantity').value;
  editInt.active_time        = document.getElementById('int-active-time').value;
  
  postAjax('/api/save-interactive', editInt, saveInteractiveSuccess);
}

/*
 * Función callback tras guardar un elemento interactivo
 */
function saveInteractiveSuccess(data){
  if (data.is_new){
    let str = template('int-tpl',{
      id: data.id,
      name: urldecode(data.name),
      url: urldecode(data.url)
    });
    intList.innerHTML += str;
  }
  else{
    let intItem = document.getElementById('int-'+data.id);
    intItem.querySelector('.item-list-sample img').src = urldecode(data.url);
    intItem.querySelector('span').innerHTML = urldecode(data.name);
  }
  closeAddInteractiveBox();
}

/*
 * Función para editar un elemento interactivo
 */
function editInteractive(e){
  const interactive = this;
  
  const id = parseInt(interactive.dataset.id);
  postAjax('/api/get-interactive', {id: id}, getInteractiveSuccess);
}

function getInteractiveSuccess(data){
  editInt.id                 = data.id;
  editInt.name               = urldecode(data.name);
  editInt.type               = data.type;
  editInt.activable          = data.activable;
  editInt.pickable           = data.pickable;
  editInt.grabbable          = data.grabbable;
  editInt.breakable          = data.breakable;
  editInt.crossable          = data.crossable;
  editInt.crossable_active   = data.crossable_active;
  editInt.sprite_start_id    = data.sprite_start_id;
  editInt.sprite_start_name  = urldecode(data.sprite_start_name);
  editInt.sprite_start_url   = urldecode(data.sprite_start_url);
  editInt.sprite_active_id   = data.sprite_active_id;
  editInt.sprite_active_name = urldecode(data.sprite_active_name);
  editInt.sprite_active_url  = urldecode(data.sprite_active_url);
  editInt.drops              = data.drops;
  editInt.quantity           = data.quantity;
  editInt.active_time        = data.active_time;
  
  showLoadedInteractive();
}