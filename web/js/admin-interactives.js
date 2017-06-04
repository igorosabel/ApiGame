const addBtn         = document.getElementById('add-btn');
const ovlInt         = document.getElementById('add-int');
const ovlSel         = document.getElementById('sel-sprite');
const addIntClose    = document.getElementById('add-int-close');
const intDel         = document.getElementById('int-delete');
const intTitle       = document.getElementById('add-int-title');
const selectSprites  = document.querySelectorAll('.cell-detail-option .cell-detail-option-sample');
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
selectSprites.forEach( spr => spr.addEventListener('click', selectSprite));
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
  sprite_start: 0,
  sprite_end: 0
};

/*
 * Función para mostrar el cuadro de añadir elemento interactivo
 */
function showAddInteractiveBox(e){
  e.preventDefault();
  intTitle.innerHTML = 'Añadir elemento interactivo';
  const name = document.getElementById('int-name');
  name.value = '';
  intDel.style.display = 'none';
  
  editInt.id = 0;
  editInt.name = '';
  editInt.sprite_start = 0;
  editInt.sprite_end = 0;
  
  selectSprites.forEach( spr => { spr.className = 'cell-detail-option-sample'; } );
  const names = document.querySelectorAll('.cell-detail-option .cell-detail-option-name');
  names.forEach( name => {
    name.innerHTML = '';
    name.style.display = 'none';
  } );
  detailDeletes.forEach( del => { del.style.display = 'none'; } );
  
  ovlInt.classList.add('add-box-show');
  name.focus();
}

/*
 * Función para cerrar el cuadro de añadir elemento interactivo
 */
function closeAddInteractiveBox(e){
  if (e){ e.preventDefault(); }
  ovlInt.classList.remove('add-box-show');
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
  spriteType = e.target.parentNode.id.replace('cell-detail-sprite-', '');
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
  
  editInt['sprite_'+spriteType] = parseInt(obj.dataset.id);
  
  const cls = obj.querySelector('.cell-detail-item-sample').className.replace('cell-detail-item-sample ', '');
  const txt_name = obj.querySelector('span').innerHTML;
  
  const spr = document.getElementById('cell-detail-sprite-'+spriteType);
  const sample = spr.querySelector('.cell-detail-option-sample');
  sample.className = 'cell-detail-option-sample '+cls;
  const name = spr.querySelector('.cell-detail-option-name');
  name.innerHTML = txt_name;
  name.style.display = 'block';
  const delSprite = spr.querySelector('.cell-detail-option-delete');
  delSprite.style.display = 'block';
  closeSelSpriteBox();
}

/*
 * Función para quitar un sprite seleccionado
 */
function deleteItem(e){
  console.log(e.target.parentNode.id);
  const spr = e.target.parentNode;
  spriteType = spr.id.replace('cell-detail-sprite-','');
  editInt['sprite_'+spriteType] = 0;
  spr.querySelector('.cell-detail-option-sample').className = 'cell-detail-option-sample';
  const name = spr.querySelector('.cell-detail-option-name');
  name.innerHTML = '';
  name.style.display = 'none';
  spr.querySelector('.cell-detail-option-delete').style.display = 'none';
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
  if (editInt.sprite_start===0){
    alert('¡No has elegido sprite inicial!');
    return false;
  }
  if (editInt.sprite_end===0){
    alert('¡No has elegido sprite final!');
    return false;
  }
  
  editInt.name = urlencode(name.value);
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
      url: urldecode(data.url_start),
      sprite_start: data.sprite_start,
      sprite_end: data.sprite_end
    });
    intList.innerHTML += str;
  }
  else{
    let intItem = document.getElementById('int-'+data.id);
    intItem.querySelector('.item-list-sample img').src = urldecode(data.url_start);
    intItem.querySelector('span').innerHTML = urldecode(data.name);
    intItem.dataset.spritestart = data.sprite_start;
    intItem.dataset.spriteend = data.sprite_end;
  }
  closeAddInteractiveBox();
}

/*
 * Función para editar un elemento interactivo
 */
function editInteractive(e){
  const interactive = this;
  intTitle.innerHTML = 'Editar elemento interactivo';
  const name_txt = interactive.querySelector('span').innerHTML;
  
  const name = document.getElementById('int-name');
  name.value = name_txt;
  intDel.style.display = 'inline-block';
  
  editInt.id = parseInt(interactive.dataset.id);
  editInt.name = name_txt;
  editInt.sprite_start = parseInt(interactive.dataset.spritestart);
  editInt.sprite_end = parseInt(interactive.dataset.spriteend);
  
  const startSprite = document.querySelector('.cell-detail-item[data-id="'+editInt.sprite_start+'"]');
  const endSprite = document.querySelector('.cell-detail-item[data-id="'+editInt.sprite_end+'"]');
  
  const startItem = document.getElementById('cell-detail-sprite-start');
  const endItem = document.getElementById('cell-detail-sprite-end');
  
  startItem.querySelector('.cell-detail-option-name').innerHTML   = startSprite.querySelector('span').innerHTML;
  startItem.querySelector('.cell-detail-option-sample').className = startSprite.querySelector('.cell-detail-item-sample').className.replace('cell-detail-item-sample', 'cell-detail-option-sample');
  endItem.querySelector('.cell-detail-option-name').innerHTML   = endSprite.querySelector('span').innerHTML;
  endItem.querySelector('.cell-detail-option-sample').className = endSprite.querySelector('.cell-detail-item-sample').className.replace('cell-detail-item-sample', 'cell-detail-option-sample');
  
  const names = document.querySelectorAll('.cell-detail-option .cell-detail-option-name');
  names.forEach( name => {
    name.style.display = 'block';
  } );
  const deletes = document.querySelectorAll('.cell-detail-option .cell-detail-option-delete');
  deletes.forEach( del => { del.style.display = 'block'; } );
  
  ovlInt.classList.add('add-box-show');
  name.focus();
}