const addCat = document.querySelector('.admin-header-add');
addCat.addEventListener('click', showAddCategoryBox);
const addCatClose = document.getElementById('add-sprc-close');
addCatClose.addEventListener('click', closeAddCategoryBox);
const frmSprc = document.getElementById('frm-sprc');
frmSprc.addEventListener('submit', saveSpriteCategory);
const sprcDel = document.getElementById('sprc-delete');
sprcDel.addEventListener('click', deleteCategory);
const tabs = document.querySelectorAll('.admin-tabs li');
tabs.forEach(tab => tab.addEventListener('click',selectTab));
const tabsEdit = document.querySelectorAll('.admin-tabs li img');
tabsEdit.forEach(img => img.addEventListener('click', editSpriteCategory));
const items = document.querySelectorAll('.item-list li');
items.forEach(item => item.addEventListener('click', editSprite));
const addSprClose = document.getElementById('add-spr-close');
addSprClose.addEventListener('click', closeAddSpriteBox);
const frmSpr = document.getElementById('frm-spr');
frmSpr.addEventListener('submit', saveSprite);
const sprDel = document.getElementById('spr-delete');
sprDel.addEventListener('click', deleteSprite);
const addBtn = document.getElementById('add-btn');
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
  if (txt.value==''){
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
  if (data.status=='ok'){
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
 * Id del sprite que se está editando
 */
let editSpriteId = 0;

/*
 * Función para mostrar el cuadro de añadir sprite
 */
function showAddSpriteBox(e){
  e.preventDefault();
  const sprc  = document.querySelector('.admin-tabs li.admin-tab-selected');
  const ovl   = document.getElementById('add-spr');
  const title = document.getElementById('add-spr-title');
  const name  = document.getElementById('spr-name');
  name.value  = '';
  const cls   = document.getElementById('spr-class');
  cls.value   = '';
  const css   = document.getElementById('spr-css');
  css.value   = '';
  const crossable = document.getElementById('spr-crossable');
  crossable.checked = false;
  const breakable = document.getElementById('spr-breakable');
  breakable.checked = false;
  const grabbable = document.getElementById('spr-grabbable');
  grabbable.checked = false;
  const pickable = document.getElementById('spr-pickable');
  pickable.checked = false;
  const del  = document.getElementById('spr-delete');
  del.style.display = 'none';
  
  title.innerHTML = 'Añadir sprite';
  editSpriteId = 0;
  editSpriteCategoryId = sprc.dataset.id;
  
  ovl.classList.add('add-box-show');
  name.focus();
}

/*
 * Función para cerrar el cuadro de añadir sprite
 */
function closeAddSpriteBox(e){
  if (e){ e.preventDefault(); }
  document.getElementById('add-spr').classList.remove('add-box-show');
}

/*
 * Función para guardar un sprite
 */
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
  const css = document.getElementById('spr-css');
  if (css.value==''){
    alert('¡No puedes dejar el CSS de la clase en blanco!');
    css.focus();
    return false;
  }
  const crossable = document.getElementById('spr-crossable');
  const breakable = document.getElementById('spr-breakable');
  const grabbable = document.getElementById('spr-grabbable');
  const pickable  = document.getElementById('spr-pickable');

  const params = {
    id: editSpriteId,
    id_category: editSpriteCategoryId,
    name: urlencode(name.value),
    class: urlencode(cls.value),
    css: urlencode(css.value),
    crossable: crossable.checked,
    breakable: breakable.checked,
    grabbable: grabbable.checked,
    pickable: pickable.checked
  };

  postAjax('/api/save-sprite', params, saveSpriteSuccess);
}

/*
 * Función callback tras guardar un sprite
 */
function saveSpriteSuccess(data){
  if (data.status=='ok'){
    if (data.is_new){
      const list = document.querySelector('#sprc-tab-'+data.id_category+' ul');
      const item = document.createElement('li');
      item.id = 'spr-'+data.id;
      item.dataset.id = data.id;
      item.innerHTML += template('spr-tpl', {
        id: data.id,
        name: urldecode(data.name),
        class: urldecode(data.class),
        crossable: data.crossable ? 'on': 'off',
        crs: data.crossable ? '1': '0',
        breakable: data.breakable ? 'on': 'off',
        bre: data.breakable ? '1': '0',
        grabbable: data.grabbable ? 'on': 'off',
        gra: data.grabbable ? '1': '0',
        pickable: data.pickable ? 'on': 'off',
        pic: data.pickable ? '1': '0'
      });
      item.addEventListener('click', editSprite);
      list.appendChild(item);
      addCss(urldecode(data.class),urldecode(data.css));
    }
    else{
      const spr = document.getElementById('spr-'+data.id);
      spr.querySelector('span').innerHTML = urldecode(data.name);
      const sample = spr.querySelector('.item-list-sample');
      sample.className = 'item-list-sample';
      sample.classList.add(urldecode(data.class));
      const crs = spr.querySelector('.crossable');
      crs.src = '/img/crossable_' + ((data.crossable) ? 'on':'off') + '.png';
      crs.dataset.crossable = ((data.crossable) ? '1':'0');
      const bre = spr.querySelector('.breakable');
      bre.src = '/img/breakable_' + ((data.breakable) ? 'on':'off') + '.png';
      bre.dataset.breakable = ((data.breakable) ? '1':'0');
      const gra = spr.querySelector('.grabbable');
      gra.src = '/img/grabbable_' + ((data.grabbable) ? 'on':'off') + '.png';
      gra.dataset.grabbable = ((data.grabbable) ? '1':'0');
      const pic = spr.querySelector('.pickable');
      pic.src = '/img/pickable_' + ((data.pickable) ? 'on':'off') + '.png';
      pic.dataset.pickable = ((data.pickable) ? '1':'0');
      updateCss(urldecode(data.class), urldecode(data.css));
    }
    closeAddSpriteBox();
  }
  else{
    alert('¡Ocurrió un error al guardar el sprite!');
  }
}

/*
 * Función para añadir una nueva clase CSS
 */
function addCss(cls, css){
  const obj = document.getElementById('sprites-css');
  obj.innerHTML += '.'+cls+'{'+css+'}';
}

/*
 * Función para actualizar una clase CSS
 */
function updateCss(cls, css){
  const obj = document.getElementById('sprites-css');
  const classes = obj.innerHTML;
  
  const exp = new RegExp('.'+cls+'{([\\s\\S]*?)}','g');
  obj.innerHTML = classes.replace(exp, '.'+cls+'{'+css+'}');
}

/*
 * Función para leer el contenido de una clase CSS
 */
function getCss(cls){
  const obj = document.getElementById('sprites-css').innerHTML;
  const exp = new RegExp('.'+cls+'{([\\s\\S]*?)}','ig');
  console.log(exp);
  const res = obj.match(exp);
  const ret = res[0].replace('.'+cls+'{','').replace('}','').replace(/^\s+|\s+$/g, '');
  return trim(ret);
}

/*
 * Función para borrar un sprite
 */
function deleteSprite(){
  const spr = this;
  const id = parseInt(spr.parentNode.parentNode.dataset.id);
  const conf = confirm('¿Estás seguro de querer borrar este sprite?');
  if (conf){
    postAjax('/api/delete-sprite', {id: id}, deleteSpriteSuccess);
  }
}

/*
 * Función callback tras borrar un sprite
 */
function deleteSpriteSuccess(data){
  const spr = document.getElementById('spr-'+data.id);
  spr.parentNode.removeChild(spr);
}

/*
 * Función para editar un sprite
 */
function editSprite(){
  const spr   = this;
  const sprc  = document.querySelector('.admin-tabs li.admin-tab-selected');
  const ovl   = document.getElementById('add-spr');
  const title = document.getElementById('add-spr-title');
  const name  = spr.querySelector('span').innerHTML;
  const cls   = spr.querySelector('.item-list-sample').className.replace('item-list-sample ', '');
  const css   = getCss(cls);
  const crs   = spr.querySelector('.crossable').dataset.crossable;
  const bre   = spr.querySelector('.breakable').dataset.breakable;
  const gra   = spr.querySelector('.grabbable').dataset.grabbable;
  const pic   = spr.querySelector('.pickable').dataset.pickable;

  editSpriteCategoryId = parseInt(sprc.dataset.id);
  editSpriteId = parseInt(spr.dataset.id);
  title.innerHTML = 'Editar sprite';
  const txt_name = document.getElementById('spr-name');
  txt_name.value = name;
  const txt_cls = document.getElementById('spr-class');
  txt_cls.value = cls;
  const txt_css = document.getElementById('spr-css');
  txt_css.value = css;
  const chk_crs = document.getElementById('spr-crossable');
  chk_crs.checked = (crs=='1');
  const chk_bre = document.getElementById('spr-breakable');
  chk_bre.checked = (bre=='1');
  const chk_gra = document.getElementById('spr-grabbable');
  chk_gra.checked = (gra=='1');
  const chk_pic = document.getElementById('spr-pickable');
  chk_pic.checked = (pic=='1');
  const del  = document.getElementById('spr-delete');
  del.style.display = 'inline-block';

  ovl.classList.add('add-box-show');
  txt_name.focus();
}