const addCat = document.querySelector('.admin-header-add');
addCat.addEventListener('click', showAddCategoryBox);
const addCatClose = document.getElementById('add-bckc-close');
addCatClose.addEventListener('click', closeAddCategoryBox);
const frmBckc = document.getElementById('frm-bckc');
frmBckc.addEventListener('submit', saveBackgroundCategory);
const bckcDel = document.getElementById('bckc-delete');
bckcDel.addEventListener('click', deleteCategory);
const tabs = document.querySelectorAll('.admin-tabs li');
tabs.forEach(tab => tab.addEventListener('click',selectTab));
const tabsEdit = document.querySelectorAll('.admin-tabs li img');
tabsEdit.forEach(img => img.addEventListener('click', editBackgroundCategory));
const items = document.querySelectorAll('.item-list li');
items.forEach(item => item.addEventListener('click', editBackground));
const addBckClose = document.getElementById('add-bck-close');
addBckClose.addEventListener('click', closeAddBackgroundBox);
const addBckFile = document.querySelector('.add-file');
addBckFile.addEventListener('click', bckFileSelect);
const bckFile = document.getElementById('bck-file');
bckFile.addEventListener('change', bckFileUpload);
const frmBck = document.getElementById('frm-bck');
frmBck.addEventListener('submit', saveBackground);
const bckDel = document.getElementById('bck-delete');
bckDel.addEventListener('click', deleteBackground);
const addBtn = document.getElementById('add-btn');
addBtn.addEventListener('click', showAddBackgroundBox);

/*
 * Función para cambiar entre pestañas
 */
function selectTab() {
	const tab = this;
	const id = tab.dataset.id;

	const tabs = document.querySelectorAll('.admin-tabs li');
	tabs.forEach(tab => tab.classList.remove('admin-tab-selected'));
	tab.classList.add('admin-tab-selected');

	const tabContents = document.querySelectorAll('.admin-tab');
	tabContents.forEach(tabContent => tabContent.classList.remove('admin-tab-selected'));
	document.getElementById('bckc-tab-'+id).classList.add('admin-tab-selected');
}

/*
 * Id de la categoría que se está editando
 */
let editBackgroundCategoryId = 0;

/*
 * Función para mostrar el cuadro de añadir categoría
 */
function showAddCategoryBox(e) {
	e.preventDefault();
	const ovl   = document.getElementById('add-bckc');
	const title = document.getElementById('add-bckc-title');
	const name  = document.getElementById('bckc-name');

	editBackgroundCategoryId = 0;
	title.innerHTML = 'Añadir categoría';
	name.value = '';
	bckcDel.style.display = 'none';

	ovl.classList.add('add-box-show');
	name.focus();
}

/*
 * Función para cerrar el cuadro de añadir categoría
 */
function closeAddCategoryBox(e = null) {
	e && e.preventDefault();
	document.getElementById('add-bckc').classList.remove('add-box-show');
}

/*
 * Función para guardar una categoría
 */
function saveBackgroundCategory(e) {
	e.preventDefault();
	const txt = document.getElementById('bckc-name');
	if (txt.value==='') {
		alert('¡No puedes dejar el nombre de la categoría en blanco!');
		txt.focus();
		return false;
	}

	postAjax('/api/save-background-category', {id: editBackgroundCategoryId, name: urlencode(txt.value)}, saveBackgroundCategorySuccess);
}

/*
 * Función callback tras guardar una categoría
 */
function saveBackgroundCategorySuccess(data) {
	if (data.status==='ok') {
		if (data.is_new) {
			const tab = document.createElement('li');
			tab.innerHTML = '<span>' + urldecode(data.name) + '</span>';
			tab.id = 'bckc-' + data.id;
			tab.dataset.id = data.id;
			tab.addEventListener('click', selectTab);

			const img = document.createElement('img');
			img.src = '/img/edit.svg';
			img.addEventListener('click', editBackgroundCategory);
			tab.appendChild(img);

			document.querySelector('.admin-tabs').appendChild(tab);

			const tabContent = document.createElement('div');
			tabContent.className = 'admin-tab';
			tabContent.id = 'bckc-tab-' + data.id;
			tabContent.innerHTML = '<ul class="item-list"></ul>';
			document.getElementById('bckc-list').appendChild(tabContent);
		}
		else {
			document.querySelector('#bckc-' + data.id + ' span').innerHTML = urldecode(data.name);
		}
		closeAddCategoryBox();
	}
	else {
		alert('¡Ocurrió un error al guardar la nueva categoría!');
	}
}

/*
 * Función para borrar una categoría
 */
function deleteCategory() {
	const conf = confirm('¿Estás seguro de querer borrar esta categoría con todos sus fondos?');
	if (conf) {
		postAjax('/api/delete-background-category', {id: editBackgroundCategoryId}, deleteBackgroundCategorySuccess);
	}
}

/*
 * Función callback tras borrar una categoría
 */
function deleteBackgroundCategorySuccess(data) {
	const bckc = document.getElementById('bckc-' + data.id);
	bckc.parentNode.removeChild(bckc);
	const bckcContent = document.getElementById('bckc-tab-' + data.id);
	bckcContent.parentNode.removeChild(bckcContent);
	closeAddCategoryBox();
}

/*
 * Función para editar el nombre de una categoría
 */
function editBackgroundCategory(e) {
	e.stopPropagation();
	const ovl   = document.getElementById('add-bckc');
	const title = document.getElementById('add-bckc-title');
	const bckc  = this.parentNode;
	const name  = bckc.querySelector('span').innerHTML;

	editBackgroundCategoryId = parseInt(bckc.dataset.id);
	title.innerHTML = 'Editar categoría';
	let txt = document.getElementById('bckc-name');
	txt.value = name;
	bckcDel.style.display = 'inline-block';

	ovl.classList.add('add-box-show');
	txt.focus();
}

/*
 * Foto seleccionada
 */
const uploadedBackground = {
	name: '',
	data: null
};

/*
 * Id del fondo que se está editando
 */
let editBackgroundId = 0;

/*
 * Función para mostrar el cuadro de añadir fondo
 */
function showAddBackgroundBox(e) {
	e.preventDefault();
	const bckc = document.querySelector('.admin-tabs li.admin-tab-selected');
	const ovl  = document.getElementById('add-bck');
	const name = document.getElementById('bck-name');
	name.value = '';
	bckFile.value = '';
	uploadedBackground.name = '';
	uploadedBackground.data = null;
	addBckFile.innerHTML    = '';
	const crossable   = document.getElementById('bck-crossable');
	crossable.checked = true;
	const del         = document.getElementById('bck-delete');
	del.style.display = 'none';

	editBackgroundId = 0;
	editBackgroundCategoryId = bckc.dataset.id;

	ovl.classList.add('add-box-show');
	name.focus();
}

/*
 * Función para cerrar el cuadro de añadir fondo
 */
function closeAddBackgroundBox(e = null) {
	e && e.preventDefault();
	document.getElementById('add-bck').classList.remove('add-box-show');
}

/*
 * Función para abrir la ventana de elegir archivo
 */
function bckFileSelect() {
	bckFile.click();
}

/*
 * Función para subir un archivo de imagen
 */
function bckFileUpload() {
	const f = bckFile.files[0];
	const r = new FileReader();
	r.onload = function(e) {
		const data = e.target.result;
		uploadedBackground.name = f.name;
		uploadedBackground.data = data;
		addBckFile.innerHTML = '';
		const img = document.createElement('img');
		img.src = data;
		addBckFile.appendChild(img);
	};
	r.readAsDataURL(f);
}

/*
 * Función para guardar un fondo
 */
function saveBackground(e) {
	e.preventDefault();
	const name = document.getElementById('bck-name');
	if (name.value==='') {
		alert('¡No puedes dejar el nombre del fondo en blanco!');
		name.focus();
		return false;
	}
	const file = document.getElementById('bck-file');
	if (editBackgroundId===0 && file.value==='') {
		alert('¡No has elegido ninguna imagen!');
		return false;
	}
	const crossable = document.getElementById('bck-crossable');

	const params = {
		id: editBackgroundId,
		id_category: editBackgroundCategoryId,
		name: urlencode(name.value),
		file_name: uploadedBackground.name,
		file: uploadedBackground.data,
		crossable: crossable.checked
	};

	postAjaxFile('/api/save-background', params, saveBackgroundSuccess);
}

/*
 * Función callback tras guardar un fondo
 */
function saveBackgroundSuccess(data) {
	if (data.status==='ok') {
		if (data.is_new) {
			const list = document.getElementById('bck-list-' + data.id_category);
			const item = document.createElement('li');
			item.id = 'bck-' + data.id;
			item.dataset.id = data.id;
			item.innerHTML += template('bck-tpl', {
				id: data.id,
				name: urldecode(data.name),
				file: data.file,
				crossable: data.crossable ? 'on' : 'off',
				crs: data.crossable ? '1': '0'
			});
			item.addEventListener('click', editBackground);
			list.appendChild(item);
			addCss(data.category, data.file);
		}
		else {
			const bck = document.getElementById('bck-' + data.id);
			bck.querySelector('span').innerHTML = urldecode(data.name);
			const sample = bck.querySelector('.item-list-sample');
			sample.className = 'item-list-sample';
			sample.classList.add(data.file);
			const crs = bck.querySelector('.crossable');
			crs.src = '/img/crossable_' + ((data.crossable) ? 'on':'off') + '.png';
			crs.dataset.crossable = ((data.crossable) ? '1':'0');
			updateCss(data.category, data.file);
		}
		closeAddBackgroundBox();
	}
	else {
		alert('¡Ocurrió un error al guardar el fondo!');
	}
}

/*
 * Función para añadir una nueva clase CSS
 */
function addCss(category, file) {
	const obj = document.getElementById('backgrounds-css');
	obj.innerHTML += "." + file + "{background: url('/assets/background/" + category + "/" + file + ".png') no-repeat center center transparent;background-size: 100% 100% !important;}";
}

/*
 * Función para actualizar una clase CSS
 */
function updateCss(category, file) {
	const obj = document.getElementById('backgrounds-css');
	const classes = obj.innerHTML;

	const exp = new RegExp('.'+file+'{([\\s\\S]*?)}','g');
	obj.innerHTML = classes.replace(exp, "." + file + "{background: url('/assets/background/" + category + "/" + file + ".png') no-repeat center center transparent;background-size: 100% 100% !important;}");
}

/*
 * Función para borrar un fondo
 */
function deleteBackground() {
	const bck = this;
	const conf = confirm('¿Estás seguro de querer borrar este fondo?');
	if (conf) {
		postAjax('/api/delete-background', {id: editBackgroundId}, deleteBackgroundSuccess);
	}
}

/*
 * Función callback tras borrar un fondo
 */
function deleteBackgroundSuccess(data) {
	const bck = document.getElementById('bck-' + data.id);
	bck.parentNode.removeChild(bck);
	closeAddBackgroundBox();
}

/*
 * Función para editar un fondo
 */
function editBackground() {
	const bck   = this;
	const bckc  = document.querySelector('.admin-tabs li.admin-tab-selected');
	const ovl   = document.getElementById('add-bck');
	const title = document.getElementById('add-bck-title');
	const name  = bck.querySelector('span').innerHTML;
	const file  = bck.querySelector('.item-list-sample').className.replace('item-list-sample ', '');
	const crs   = bck.querySelector('.crossable').dataset.crossable;

	editBackgroundCategoryId = parseInt(bckc.dataset.id);
	editBackgroundId = parseInt(bck.dataset.id);
	title.innerHTML = 'Editar fondo';
	const txt_name = document.getElementById('bck-name');
	txt_name.value = name;

	const category = slugify(bckc.querySelector('span').innerHTML);
	addBckFile.innerHTML = '';
	const img = document.createElement('img');
	img.src = '/assets/background/' + category + '/' + file + '.png';
	addBckFile.appendChild(img);

	const chk_crs     = document.getElementById('bck-crossable');
	chk_crs.checked   = (crs==='1');
	const del         = document.getElementById('bck-delete');
	del.style.display = 'inline-block';

	ovl.classList.add('add-box-show');
	txt_name.focus();
}