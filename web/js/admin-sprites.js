const addCat      = document.querySelector('.admin-header-add');
const addCatClose = document.getElementById('add-sprc-close');
const frmSprc     = document.getElementById('frm-sprc');
const sprcDel     = document.getElementById('sprc-delete');
const tabs        = document.querySelectorAll('.admin-tabs li');
const tabsEdit    = document.querySelectorAll('.admin-tabs li img');
const items       = document.querySelectorAll('.item-list li');
const addSprClose = document.getElementById('add-spr-close');
const addSprFile  = document.querySelector('.add-file');
const sprFile     = document.getElementById('spr-file');
const ovlSpr      = document.getElementById('add-spr');
const frmSpr      = document.getElementById('frm-spr');
const sprDel      = document.getElementById('spr-delete');
const addBtn      = document.getElementById('add-btn');

addCat.addEventListener('click', showAddCategoryBox);
addCatClose.addEventListener('click', closeAddCategoryBox);
frmSprc.addEventListener('submit', saveSpriteCategory);
sprcDel.addEventListener('click', deleteCategory);
tabs.forEach(tab => tab.addEventListener('click',selectTab));
tabsEdit.forEach(img => img.addEventListener('click', editSpriteCategory));
items.forEach(item => item.addEventListener('click', editSprite));
addSprClose.addEventListener('click', closeAddSpriteBox);
addSprFile.addEventListener('click', sprFileSelect);
sprFile.addEventListener('change', sprFileUpload);
frmSpr.addEventListener('submit', saveSprite);
sprDel.addEventListener('click', deleteSprite);
addBtn.addEventListener('click', showAddSpriteBox);

/*
 * Función para cambiar entre pestañas
 */
function selectTab(){
  const tab = this;
  const id = tab.dataset.id;

  const tabs = document.querySelectorAll('.admin-tabs li');
  tabs.forEach(tab => tab.classList.remove('admin-tab-selected'));
  tab.classList.add('admin-tab-selected');

  const tabContents = document.querySelectorAll('.admin-tab');
  tabContents.forEach(tabContent => tabContent.classList.remove('admin-tab-selected'));
  document.getElementById('sprc-tab-'+id).classList.add('admin-tab-selected');
}

/*
 * Id de la categoría que se está editando
 */
let editSpriteCategoryId = 0;

/*
 * Función para mostrar el cuadro de añadir categoría
 */
function showAddCategoryBox(e){
  e.preventDefault();
  const ovl   = document.getElementById('add-sprc');
  const title = document.getElementById('add-sprc-title');
  const name  = document.getElementById('sprc-name');

  editSpriteCategoryId = 0;
  title.innerHTML = 'Añadir categoría';
  name.value = '';
  sprcDel.style.display = 'none';

  ovl.classList.add('add-box-show');
  name.focus();
}

/*
 * Función para cerrar el cuadro de añadir categoría
 */
function closeAddCategoryBox(e){
  if (e){ e.preventDefault(); }
  document.getElementById('add-sprc').classList.remove('add-box-show');
}

/*
 * Función para guardar una categoría
 */
function saveSpriteCategory(e){
  e.preventDefault();
  const txt = document.getElementById('sprc-name');
  if (txt.value===''){
    alert('¡No puedes dejar el nombre de la categoría en blanco!');
    txt.focus();
    return false;
  }

  postAjax('/api/save-sprite-category', {id: editSpriteCategoryId, name: urlencode(txt.value)}, saveSpriteCategorySuccess);
}

/*
 * Función callback tras guardar una categoría
 */
function saveSpriteCategorySuccess(data){
  if (data.status==='ok'){
    if (data.is_new){
      const tab = document.createElement('li');
      tab.innerHTML = '<span>'+urldecode(data.name)+'</span>';
      tab.id = 'sprc-'+data.id;
      tab.dataset.id = data.id;
      tab.addEventListener('click',selectTab);
      
      const img = document.createElement('img');
      img.src = '/img/edit.svg';
      img.addEventListener('click', editSpriteCategory);
      tab.appendChild(img);
      
      document.querySelector('.admin-tabs').appendChild(tab);
      
      const tabContent = document.createElement('div');
      tabContent.className = 'admin-tab';
      tabContent.id = 'sprc-tab-'+data.id;
      tabContent.innerHTML = '<ul class="item-list"></ul>';
      document.getElementById('sprc-list').appendChild(tabContent);
    }
    else{
      document.querySelector('#sprc-'+data.id+' span').innerHTML = urldecode(data.name);
    }
    closeAddCategoryBox();
  }
  else{
    alert('¡Ocurrió un error al guardar la nueva categoría!');
  }
}

/*
 * Función para borrar una categoría
 */
function deleteCategory(){
  const conf = confirm('¿Estás seguro de querer borrar esta categoría con todos sus sprites?');
  if (conf){
    postAjax('/api/delete-sprite-category', {id: editSpriteCategoryId}, deleteSpriteCategorySuccess);
  }
}

/*
 * Función callback tras borrar una categoría
 */
function deleteSpriteCategorySuccess(data){
  const sprc = document.getElementById('sprc-'+data.id);
  sprc.parentNode.removeChild(sprc);
  const sprcContent = document.getElementById('sprc-tab-'+data.id);
  sprcContent.parentNode.removeChild(sprcContent);
  closeAddCategoryBox();
}

/*
 * Función para editar el nombre de una categoría
 */
function editSpriteCategory(e){
  e.stopPropagation();
  const ovl   = document.getElementById('add-sprc');
  const title = document.getElementById('add-sprc-title');
  const sprc  = this.parentNode;
  const name  = sprc.querySelector('span').innerHTML;

  editSpriteCategoryId = parseInt(sprc.dataset.id);
  title.innerHTML = 'Editar categoría';
  let txt = document.getElementById('sprc-name');
  txt.value = name;
  sprcDel.style.display = 'inline-block';
  
  ovl.classList.add('add-box-show');
  txt.focus();
}

/*
 * Foto seleccionada
 */
const uploadedSprite = {
  name: '',
  data: null
};

/*
 * Sprite que se está editando
 */
let editSpr = {
  id: 0,
  id_category: 0,
  name: '',
  file: '',
  data: null,
  url: '',
  crossable: false,
  width: 1,
  height: 1,
  frames: []
};

/*
 * Función para mostrar el cuadro de añadir sprite
 */
function showAddSpriteBox(e){
  e.preventDefault();
  
  const sprc  = document.querySelector('.admin-tabs li.admin-tab-selected');
  
  editSpr.id          = 0;
  editSpr.id_category = sprc.dataset.id;
  editSpr.name        = '';
  editSpr.file        = '';
  editSpr.data        = null;
  editSpr.url         = '';
  editSpr.crossable   = false;
  editSpr.width       = 1;
  editSpr.height      = 1;
  editSpr.frames      = [];
  
  sprFile.value = '';
  uploadedSprite.name = '';
  uploadedSprite.data = null;
  addSprFile.innerHTML = '';
  
  showLoadedSprite();
}

/*
 * Función para mostrar en el formulario el sprite cargado
 */
function showLoadedSprite(){
  const title = document.getElementById('add-spr-title');
  const name      = document.getElementById('spr-name');
  const width     = document.getElementById('spr-width');
  const height    = document.getElementById('spr-height');
  const crossable = document.getElementById('spr-crossable');
  const del       = document.getElementById('spr-delete');
  
  title.innerHTML   = ( editSpr.id===0 ) ? 'Añadir sprite' : 'Editar sprite';
  name.value        = editSpr.name;
  width.value       = editSpr.width;
  height.value      = editSpr.height;
  crossable.checked = editSpr.crossable;
  del.style.display = ( editSpr.id===0 ) ? 'none' : 'inline-block';
  
  addSprFile.innerHTML = '';
  if (editSpr.url!==''){
    const img = document.createElement('img');
    img.src = editSpr.url;
    addSprFile.appendChild(img);
  }
  
  name.focus();
  ovlSpr.classList.add('add-box-show');
}

/*
 * Función para cerrar el cuadro de añadir sprite
 */
function closeAddSpriteBox(e){
  if (e){ e.preventDefault(); }
  document.getElementById('add-spr').classList.remove('add-box-show');
}

/*
 * Función para abrir la ventana de elegir archivo
 */
function sprFileSelect() {
  sprFile.click();
}

/*
 * Función para subir un archivo de imagen
 */
function sprFileUpload() {
  const f = sprFile.files[0];
  const r = new FileReader();
  r.onload = function(e){
    const data = e.target.result;
    editSpr.file = f.name;
    editSpr.data = data;
    addSprFile.innerHTML = '';
    const img = document.createElement('img');
    img.src = data;
    addSprFile.appendChild(img);
  };
  r.readAsDataURL(f);
}

/*
 * Función para actualizar el objeto editSpr con los datos del formulario
 */
function updateEditSpr(){
  editSpr.name = document.getElementById('spr-name').value;
  editSpr.crossable   = document.getElementById('spr-crossable').checked;
  editSpr.width       = document.getElementById('spr-width').value;
  editSpr.height      = document.getElementById('spr-height').value;
}

/*
 * Función para guardar un sprite
 */
function saveSprite(e){
  e.preventDefault();
  const name = document.getElementById('spr-name');
  if (name.value===''){
    alert('¡No puedes dejar el nombre del sprite en blanco!');
    name.focus();
    return false;
  }
  const file = document.getElementById('spr-file');
  if (editSpr.id===0 && file.value===''){
    alert('¡No has elegido ninguna imagen!');
    return false;
  }
  const width = document.getElementById('spr-width');
  if (width.value==='' || isNaN(width.value)){
    alert('La anchura introducida no es correcta');
    width.focus();
    return false;
  }
  const height = document.getElementById('spr-height');
  if (height.value==='' || isNaN(height.value)){
    alert('La altura introducida no es correcta');
    height.focus();
    return false;
  }
  
  updateEditSpr();

  const crossable = document.getElementById('spr-crossable');

  const params = {
    id: editSpr.id,
    id_category: editSpr.id_category,
    name: urlencode(editSpr.name),
    file: urlencode(editSpr.file),
    file_data: editSpr.data,
    width: editSpr.width,
    height: editSpr.height,
    crossable: editSpr.crossable
  };

  postAjaxFile('/api/save-sprite', params, saveSpriteSuccess);
}

/*
 * Función callback tras guardar un sprite
 */
function saveSpriteSuccess(data){
  const sprc = document.querySelector('.admin-tabs li.admin-tab-selected');
  const category = slugify(sprc.querySelector('span').innerHTML);
  if (data.status==='ok'){
    if (data.is_new){
      const list = document.querySelector('#sprc-tab-'+data.id_category+' ul');
      const item = document.createElement('li');
      item.id = 'spr-'+data.id;
      item.dataset.id = data.id;
      item.innerHTML += template('spr-tpl', {
        id: data.id,
        name: urldecode(data.name),
        url: urldecode(data.url),
        width: data.width,
        height: data.height,
        crossable: data.crossable ? 'on': 'off'
      });
      item.addEventListener('click', editSprite);
      list.appendChild(item);
    }
    else{
      const spr = document.getElementById('spr-'+data.id);
      const name = spr.querySelector('span');
      name.innerHTML = urldecode(data.name);
      name.dataset.width = data.width;
      name.dataset.height = data.height;
      const img = spr.querySelector('.item-list-sample img');
      img.src = urldecode(data.url);
      const crs = spr.querySelector('.crossable');
      crs.src = '/img/crossable_' + ((data.crossable) ? 'on':'off') + '.png';
    }
    closeAddSpriteBox();
  }
  else{
    alert('¡Ocurrió un error al guardar el sprite!');
  }
}

/*
 * Función para borrar un sprite
 */
function deleteSprite(){
  const spr = this;
  const conf = confirm('¿Estás seguro de querer borrar este sprite?');
  if (conf){
    postAjax('/api/delete-sprite', {id: editSpr.id}, deleteSpriteSuccess);
  }
}

/*
 * Función callback tras borrar un sprite
 */
function deleteSpriteSuccess(data){
  const spr = document.getElementById('spr-'+data.id);
  spr.parentNode.removeChild(spr);
  closeAddSpriteBox();
}

/*
 * Función para editar un sprite
 */
function editSprite(){
  const spr    = this;
  postAjax('/api/get-sprite', {id: parseInt(spr.dataset.id)}, getSpriteSuccess);
}

/*
 * Función para mostrar el cuadro de editar sprite con los datos obtenidos
 */
function getSpriteSuccess(data){
  editSpr.id          = data.id;
  editSpr.id_category = data.id_category;
  editSpr.name        = urldecode(data.name);
  editSpr.file        = '';
  editSpr.data        = null;
  editSpr.url         = urldecode(data.url);
  editSpr.crossable   = data.crossable;
  editSpr.width       = data.width;
  editSpr.height      = data.height;
  editSpr.frames      = data.frames;
  
  showLoadedSprite();
}