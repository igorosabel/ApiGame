let deploys     = null;
let deleteBckcs = null;
let editBckcs   = null;
let addBcks     = null;
let deleteBcks  = null;
let editBcks    = null;

const addBckcBtn   = document.getElementById('add-btn');
const closeBckcBtn = document.getElementById('add-bckc-close');
const bckcFrm      = document.getElementById('frm-bckc');
const closeBckBtn  = document.getElementById('add-bck-close');
const bckFrm       = document.getElementById('frm-bck');

addBckcBtn.addEventListener('click', showAddCategoryBox);
closeBckcBtn.addEventListener('click', closeAddCategoryBox);
bckcFrm.addEventListener('submit', saveBackgroundCategory);
closeBckBtn.addEventListener('click', closeAddBackgroundBox);
bckFrm.addEventListener('submit', saveBackground);

function updateEventListeners(){
  deploys = document.querySelectorAll('.obj-category-deploy');
  deploys.forEach(deploy => deploy.addEventListener('click', deployCategory));
  deleteBckcs = document.querySelectorAll('.obj-category-delete');
  deleteBckcs.forEach(del => del.addEventListener('click', deleteCategory));
  editBckcs = document.querySelectorAll('.obj-category-edit');
  editBckcs.forEach(bckc => bckc.addEventListener('click', editBackgroundCategory));
  addBcks = document.querySelectorAll('.obj-category-add');
  addBcks.forEach(bck => bck.addEventListener('click', showAddBackgroundBox));
  deleteBcks = document.querySelectorAll('.obj-delete');
  deleteBcks.forEach(del => del.addEventListener('click', deleteBackground));
  editBcks = document.querySelectorAll('.obj-edit');
  editBcks.forEach(bck => bck.addEventListener('click', editBackground));
}

function deployCategory(e,id){
  let item;
  if (typeof id == 'undefined'){
    item = this.parentNode.parentNode;
  }
  else{
    item = document.getElementById('bckc-'+id);
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

let editBackgroundCategoryId = 0;

function showAddCategoryBox(e){
  e.preventDefault();
  const ovl   = document.getElementById('add-bckc');
  const title = document.getElementById('add-bckc-title');
  const name  = document.getElementById('bckc-name');
  
  editBackgroundCategoryId = 0;
  title.innerHTML = 'Añadir categoría';
  name.value = '';

  ovl.classList.add('add-box-show');
  name.focus();
}

function closeAddCategoryBox(e){
  if (e){ e.preventDefault(); }
  document.getElementById('add-bckc').classList.remove('add-box-show');
}

function saveBackgroundCategory(e){
  e.preventDefault();
  const txt = document.getElementById('bckc-name');
  if (txt.value==''){
    alert('¡No puedes dejar el nombre de la categoría en blanco!');
    txt.focus();
    return false;
  }

  postAjax('/api/save-background-category', {id: editBackgroundCategoryId, name: urlencode(txt.value)}, saveBackgroundCategorySuccess);
}

function saveBackgroundCategorySuccess(data){
  if (data.status=='ok'){
    if (data.is_new){
      document.getElementById('bckc-list').innerHTML += template('bckc-tpl', {id: data.id, name: urldecode(data.name)});
      updateEventListeners();
    }
    else{
      const bckc = document.getElementById('bckc-'+data.id);
      bckc.querySelector('.obj-category-header span').innerHTML = urldecode(data.name);
    }
    closeAddCategoryBox();
  }
  else{
    alert('¡Ocurrió un error al guardar la nueva categoría!');
  }
}

function deleteCategory(){
  const bckc = this;
  const id = parseInt(bckc.parentNode.parentNode.dataset.id);
  const conf = confirm('¿Estás seguro de querer borrar esta categoría con todos sus fondos?');
  if (conf){
    postAjax('/api/delete-background-category', {id: id}, deleteBackgroundCategorySuccess);
  }
}

function deleteBackgroundCategorySuccess(data){
  const bckc = document.getElementById('bckc-'+data.id);
  bckc.parentNode.removeChild(bckc);
}

function editBackgroundCategory(){
  const ovl   = document.getElementById('add-bckc');
  const title = document.getElementById('add-bckc-title');
  const bckc  = this.parentNode.parentNode;
  const name  = bckc.querySelector('.obj-category-header span').innerHTML;

  editBackgroundCategoryId = parseInt(bckc.dataset.id);
  title.innerHTML = 'Editar categoría';
  let txt = document.getElementById('bckc-name');
  txt.value = name;
  
  ovl.classList.add('add-box-show');
  txt.focus();
}

let editBackgroundId = 0;

function showAddBackgroundBox(e){
  e.preventDefault();
  const bckc = this.parentNode.parentNode;
  const ovl = document.getElementById('add-bck');
  const name = document.getElementById('bck-name');
  name.value = '';
  const cls = document.getElementById('bck-class');
  cls.value = '';
  const css = document.getElementById('bck-css');
  css.value = '';
  const crossable = document.getElementById('bck-crossable');
  crossable.checked = true;
  
  editBackgroundId = 0;
  editBackgroundCategoryId = bckc.dataset.id;
  
  ovl.classList.add('add-box-show');
  name.focus();
}

function closeAddBackgroundBox(e){
  if (e){ e.preventDefault(); }
  document.getElementById('add-bck').classList.remove('add-box-show');
}

function saveBackground(e){
  e.preventDefault();
  const name = document.getElementById('bck-name');
  if (name.value==''){
    alert('¡No puedes dejar el nombre del fondo en blanco!');
    name.focus();
    return false;
  }
  const cls = document.getElementById('bck-class');
  if (cls.value==''){
    alert('¡No puedes dejar el nombre de la clase en blanco!');
    cls.focus();
    return false;
  }
  const css = document.getElementById('bck-css');
  if (css.value==''){
    alert('¡No puedes dejar el CSS de la clase en blanco!');
    css.focus();
    return false;
  }
  const crossable = document.getElementById('bck-crossable');

  const params = {
    id: editBackgroundId,
    id_category: editBackgroundCategoryId,
    name: urlencode(name.value),
    class: urlencode(cls.value),
    css: urlencode(css.value),
    crossable: crossable.checked
  };

  postAjax('/api/save-background', params, saveBackgroundSuccess);
}

function saveBackgroundSuccess(data){
  if (data.status=='ok'){
    if (data.is_new){
      const list = document.getElementById('bck-list-'+data.id_category);
      list.innerHTML += template('bck-tpl', {
        id: data.id,
        name: urldecode(data.name),
        class: urldecode(data.class),
        crs_img: data.crossable ? 'yes' : 'no',
        crossable: data.crossable ? '1': '0'
      });
      addCss(urldecode(data.class),urldecode(data.css));
      updateEventListeners();
      if (!list.classList.contains('obj-category-list-open')){
        deployCategory(null, data.id_category);
      }
    }
    else{
      const bck = document.getElementById('bck-'+data.id);
      bck.querySelector('.obj-item-name').innerHTML = urldecode(data.name);
      const sample = bck.querySelector('.obj-item-sample');
      sample.className = 'obj-item-sample';
      sample.classList.add(urldecode(data.class));
      const crs = bck.querySelector('.obj-item-info img');
      crs.src = '/img/' + ((data.crossable) ? 'yes':'no') + '.svg';
      crs.dataset.crossable = ((data.crossable) ? '1':'0');
      updateCss(urldecode(data.class), urldecode(data.css));
    }
    closeAddBackgroundBox();
  }
  else{
    alert('¡Ocurrió un error al guardar el fondo!');
  }
}

function addCss(cls, css){
  const obj = document.getElementById('backgrounds-css');
  obj.innerHTML += '.'+cls+'{'+css+'}';
}

function updateCss(cls, css){
  const obj = document.getElementById('backgrounds-css');
  const classes = obj.innerHTML;
  
  const exp = new RegExp('.'+cls+'{([\\s\\S]*?)}','g');
  obj.innerHTML = classes.replace(exp, '.'+cls+'{'+css+'}');
}

function getCss(cls){
  const obj = document.getElementById('backgrounds-css').innerHTML;
  const exp = new RegExp('.'+cls+'{([\\s\\S]*?)}','ig');
  const res = obj.match(exp);
  const ret = res[0].replace('.'+cls+'{','').replace('}','').replace(/^\s+|\s+$/g, '');
  return trim(ret);
}

function deleteBackground(){
  const bck = this;
  const id = parseInt(bck.parentNode.parentNode.dataset.id);
  const conf = confirm('¿Estás seguro de querer borrar este fondo?');
  if (conf){
    postAjax('/api/delete-background', {id: id}, deleteBackgroundSuccess);
  }
}

function deleteBackgroundSuccess(data){
  const bck = document.getElementById('bck-'+data.id);
  bck.parentNode.removeChild(bck);
}

function editBackground(){
  const ovl   = document.getElementById('add-bck');
  const title = document.getElementById('add-bck-title');
  const bck   = this.parentNode.parentNode;
  const name  = bck.querySelector('.obj-item-name').innerHTML;
  const cls   = bck.querySelector('.obj-item-sample').className.replace('obj-item-sample ', '');
  const css   = getCss(cls);
  const crs   = bck.querySelector('.obj-item-info img').dataset.crossable;

  editBackgroundCategoryId = parseInt(bck.parentNode.parentNode.dataset.id);
  editBackgroundId = parseInt(bck.dataset.id);
  title.innerHTML = 'Editar fondo';
  const txt_name = document.getElementById('bck-name');
  txt_name.value = name;
  const txt_cls = document.getElementById('bck-class');
  txt_cls.value = cls;
  const txt_css = document.getElementById('bck-css');
  txt_css.value = css;
  const chk_crs = document.getElementById('bck-crossable');
  chk_crs.checked = (crs=='1');

  ovl.classList.add('add-box-show');
  txt_name.focus();
}

updateEventListeners();