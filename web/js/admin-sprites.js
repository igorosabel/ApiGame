let deploys     = null;
let deleteSprcs = null;
let editSprcs   = null;
let addSprs     = null;
let deleteSprs  = null;
let editSprs    = null;

const addSprcBtn   = document.getElementById('add-btn');
const closeSprcBtn = document.getElementById('add-sprc-close');
const sprcFrm      = document.getElementById('frm-sprc');
const closeSprBtn  = document.getElementById('add-spr-close');
const sprFrm       = document.getElementById('frm-spr');

addSprcBtn.addEventListener('click', showAddCategoryBox);
closeSprcBtn.addEventListener('click', closeAddCategoryBox);
sprcFrm.addEventListener('submit', saveSpriteCategory);
closeSprBtn.addEventListener('click', closeAddSpriteBox);
sprFrm.addEventListener('submit', saveSprite);

function updateEventListeners(){
  deploys = document.querySelectorAll('.obj-category-deploy');
  deploys.forEach(deploy => deploy.addEventListener('click', deployCategory));
  deleteSprcs = document.querySelectorAll('.obj-category-delete');
  deleteSprcs.forEach(del => del.addEventListener('click', deleteCategory));
  editSprcs = document.querySelectorAll('.obj-category-edit');
  editSprcs.forEach(sprc => sprc.addEventListener('click', editSpriteCategory));
  addSprs = document.querySelectorAll('.obj-category-add');
  addSprs.forEach(spr => spr.addEventListener('click', showAddSpriteBox));
  deleteSprs = document.querySelectorAll('.obj-delete');
  deleteSprs.forEach(del => del.addEventListener('click', deleteSprite));
  editSprs = document.querySelectorAll('.obj-edit');
  editSprs.forEach(spr => spr.addEventListener('click', editSprite));
}

function deployCategory(e,id){
  let item;
  if (typeof id == 'undefined'){
    item = this.parentNode.parentNode;
  }
  else{
    item = document.getElementById('sprc-'+id);
  }
  const deploy = item.querySelector('.obj-category-deploy');
  const list = item.querySelector('.obj-category-list');
  if (!list.classList.contains('obj-category-list-open')){
    deploy.classList.add('obj-category-deployed');
    list.classList.add('obj-category-list-open');
  }
  else{
    deploy.classList.remove('obj-category-deployed');
    list.classList.remove('obj-category-list-open');
  }
}

let editSpriteCategoryId = 0;

function showAddCategoryBox(e){
  e.preventDefault();
  const ovl   = document.getElementById('add-sprc');
  const title = document.getElementById('add-sprc-title');
  const name  = document.getElementById('sprc-name');
  
  editSpriteCategoryId = 0;
  title.innerHTML = 'Añadir categoría';
  name.value = '';

  ovl.classList.add('add-box-show');
  name.focus();
}

function closeAddCategoryBox(e){
  if (e){ e.preventDefault(); }
  document.getElementById('add-sprc').classList.remove('add-box-show');
}

function saveSpriteCategory(e){
  e.preventDefault();
  const txt = document.getElementById('sprc-name');
  if (txt.value==''){
    alert('¡No puedes dejar el nombre de la categoría en blanco!');
    txt.focus();
    return false;
  }

  postAjax('/api/save-sprite-category', {id: editSpriteCategoryId, name: urlencode(txt.value)}, saveSpriteCategorySuccess);
}

function saveSpriteCategorySuccess(data){
  if (data.status=='ok'){
    if (data.is_new){
      document.getElementById('sprc-list').innerHTML += template('sprc-tpl', {id: data.id, name: urldecode(data.name)});
      updateEventListeners();
    }
    else{
      const sprc = document.getElementById('sprc-'+data.id);
      sprc.querySelector('.obj-category-header span').innerHTML = urldecode(data.name);
    }
    closeAddCategoryBox();
  }
  else{
    alert('¡Ocurrió un error al guardar la nueva categoría!');
  }
}

function deleteCategory(){
  const sprc = this;
  const id = parseInt(sprc.parentNode.parentNode.dataset.id);
  const conf = confirm('¿Estás seguro de querer borrar esta categoría con todos sus sprites?');
  if (conf){
    postAjax('/api/delete-sprite-category', {id: id}, deleteSpriteCategorySuccess);
  }
}

function deleteSpriteCategorySuccess(data){
  const sprc = document.getElementById('sprc-'+data.id);
  sprc.parentNode.removeChild(sprc);
}

function editSpriteCategory(){
  const ovl   = document.getElementById('add-sprc');
  const title = document.getElementById('add-sprc-title');
  const sprc  = this.parentNode.parentNode;
  const name  = sprc.querySelector('.obj-category-header span').innerHTML;

  editSpriteCategoryId = parseInt(sprc.dataset.id);
  title.innerHTML = 'Editar categoría';
  let txt = document.getElementById('sprc-name');
  txt.value = name;
  
  ovl.classList.add('add-box-show');
  txt.focus();
}

let editSpriteId = 0;

function showAddSpriteBox(e){
  e.preventDefault();
  const sprc = this.parentNode.parentNode;
  const ovl = document.getElementById('add-spr');
  const name = document.getElementById('spr-name');
  name.value = '';
  const cls = document.getElementById('spr-class');
  cls.value = '';
  const crossable = document.getElementById('spr-crossable');
  crossable.checked = true;
  
  editSpriteId = 0;
  editSpriteCategoryId = sprc.dataset.id;
  
  ovl.classList.add('add-box-show');
  name.focus();
}

function closeAddSpriteBox(e){
  if (e){ e.preventDefault(); }
  document.getElementById('add-spr').classList.remove('add-box-show');
}

function saveSprite(e){
  e.preventDefault();
  const name = document.getElementById('spr-name');
  if (name.value==''){
    alert('¡No puedes dejar el nombre del sprite en blanco!');
    name.focus();
    return false;
  }
  const cls = document.getElementById('spr-class');
  if (cls.value==''){
    alert('¡No puedes dejar el nombre de la clase en blanco!');
    cls.focus();
    return false;
  }
  const crossable = document.getElementById('spr-crossable');

  const params = {
    id: editSpriteId,
    id_category: editSpriteCategoryId,
    name: urlencode(name.value),
    class: urlencode(cls.value),
    crossable: crossable.checked
  };

  postAjax('/api/save-sprite', params, saveSpriteSuccess);
}

function saveSpriteSuccess(data){
  if (data.status=='ok'){
    if (data.is_new){
      const list = document.getElementById('spr-list-'+data.id_category);
      list.innerHTML += template('spr-tpl', {
        id: data.id,
        name: urldecode(data.name),
        class: urldecode(data.class),
        crs_img: data.crossable ? 'yes' : 'no',
        crossable: data.crossable ? '1': '0'
      });
      updateEventListeners();
      if (!list.classList.contains('obj-category-list-open')){
        deployCategory(null, data.id_category);
      }
    }
    else{
      const spr = document.getElementById('spr-'+data.id);
      spr.querySelector('.obj-item-name').innerHTML = urldecode(data.name);
      const sample = spr.querySelector('.obj-item-sample');
      sample.className = 'obj-item-sample';
      sample.classList.add(urldecode(data.class));
      const crs = spr.querySelector('.obj-item-info img');
      crs.src = '/img/' + ((data.crossable) ? 'yes':'no') + '.svg';
      crs.dataset.crossable = ((data.crossable) ? '1':'0');
    }
    closeAddSpriteBox();
  }
  else{
    alert('¡Ocurrió un error al guardar el sprite!');
  }
}

function deleteSprite(){
  const spr = this;
  const id = parseInt(spr.parentNode.parentNode.dataset.id);
  const conf = confirm('¿Estás seguro de querer borrar este sprite?');
  if (conf){
    postAjax('/api/delete-sprite', {id: id}, deleteSpriteSuccess);
  }
}

function deleteSpriteSuccess(data){
  const spr = document.getElementById('spr-'+data.id);
  spr.parentNode.removeChild(spr);
}

function editSprite(){
  const ovl   = document.getElementById('add-spr');
  const title = document.getElementById('add-spr-title');
  const spr   = this.parentNode.parentNode;
  const name  = spr.querySelector('.obj-item-name').innerHTML;
  const cls   = spr.querySelector('.obj-item-sample').className.replace('obj-item-sample ', '');
  const crs   = spr.querySelector('.obj-item-info img').dataset.crossable;

  editSpriteCategoryId = parseInt(spr.parentNode.parentNode.dataset.id);
  editSpriteId = parseInt(spr.dataset.id);
  title.innerHTML = 'Editar sprite';
  const txt_name = document.getElementById('spr-name');
  txt_name.value = name;
  const txt_cls = document.getElementById('spr-class');
  txt_cls.value = cls;
  const chk_crs = document.getElementById('spr-crossable');
  chk_crs.checked = (crs=='1');

  ovl.classList.add('add-box-show');
  txt_name.focus();
}

updateEventListeners();