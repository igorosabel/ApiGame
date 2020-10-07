const tags = document.querySelector('#assets-filter-tag');
const list = document.querySelector('#list');
const addBtn = document.querySelector('#add-btn');
addBtn.addEventListener('click', showAddAsset);
const assetDetail = document.querySelector('#asset');
const assetDetailHeader = document.querySelector('#asset-header');
const assetDetailClose = document.querySelector('#asset-close');
assetDetailClose.addEventListener('click', showAddAsset);
const assetDetailName = document.querySelector('#asset-name');
const assetDetailWorld = document.querySelector('#asset-world');
const assetDetailImage = document.querySelector('#asset-image');
const assetDetailFileGo = document.querySelector('#asset-file-go');
assetDetailFileGo.addEventListener('click', openFile);
const assetDetailFileGoLoading = document.querySelector('#asset-file-go-loading');
const assetDetailFile = document.querySelector('#asset-file');
assetDetailFile.addEventListener('change', onFileChange);
const assetDetailTags = document.querySelector('#asset-tags');
const assetGo = document.querySelector('#asset-go');
assetGo.addEventListener('click', saveAsset);
const assetGoLoading = document.querySelector('#asset-go-loading');

window.onload = () => {
	updateList();
};

function loadAssets() {
	list.innerHTML = template('asset-list-empty', {mesg: 'Cargando...'});
	postAjax('/admin/asset-list', {}, loadAssetsSuccess);
}

function loadAssetsSuccess(result) {
	if (result.status=='ok') {
		assetList = result.list;
		updateList();
	}
	else {
		alert('¡Ocurrió un error al obtener la lista de recursos!');
		list.innerHTML = template('asset-list-empty', {mesg: 'ERROR'});
	}
}

function updateList() {
	list.innerHTML = template('asset-list-empty', {mesg: 'Cargando...'});
	if (assetList.length>0) {
		list.innerHTML = '';
		for (let asset of assetList) {
			let str = template('asset-list-item', {
				id: asset.id,
				name: urldecode(asset.name),
				url: urldecode(asset.url)
			});
			list.innerHTML += str;
		}
		let editButtons = document.querySelectorAll('.asset-edit');
		editButtons.forEach((item, i) => {
			item.addEventListener('click', editAsset);
		});
		let deleteButtons = document.querySelectorAll('.asset-delete');
		deleteButtons.forEach((item, i) => {
			item.addEventListener('click', deleteAsset);
		});
	}
	else {
		list.innerHTML = template('asset-list-empty', {mesg: 'Todavía no hay ningún recurso.'});
	}
}

function loadTags() {
	postAjax('/admin/tag-list', {}, loadTagsSuccess);
}

function loadTagsSuccess(result) {
	let str = '<option value="0">Elige una tag</option>';
	for (let tag of result.list) {
		str += '<option value="' + tag.id + '">' + urldecode(tag.name) + '</option>';
	}
	tags.innerHTML = str;
	tags.value = 0;
}

const loadedAsset = {
	id: null,
	id_world: null,
	name: null,
	url: null,
	modified: false,
	tags: []
};

function resetLoadedAsset() {
	loadedAsset.id = null;
	loadedAsset.id_world = 'null';
	loadedAsset.name = null;
	loadedAsset.url = null;
	loadedAsset.modified = false;
	loadedAsset.tags = [];
}

function loadAsset() {
	assetDetailWorld.value = loadedAsset.id_world;
	assetDetailName.value = loadedAsset.name;
	if (loadedAsset.url!=null) {
		assetDetailImage.style.background = 'url(' + loadedAsset.url + ') no-repeat center center / 100% 100% transparent';
	}
	else {
		assetDetailImage.style.background = '';
	}
	let str_tags = [];
	loadedAsset.tags.forEach(item => {
		str_tags.push(urldecode(item.name));
	});
	assetDetailTags.value = str_tags.join(', ');
}

function updateAsset() {
	loadedAsset.id_world = assetDetailWorld.value;
	loadedAsset.name = assetDetailName.value;
	loadedAsset.tags = assetDetailTags.value;
}

function showAddAsset(ev = null) {
	ev && ev.preventDefault();
	if (!assetDetail.classList.contains('asset-detail-show')) {
		resetLoadedAsset();
		assetDetailHeader.innerHTML = 'Nuevo recurso';
		loadAsset();

		assetDetail.classList.add('asset-detail-show');
	}
	else {
		assetDetail.classList.remove('asset-detail-show');
	}
}

function openFile() {
	assetDetailFile.click();
}

function onFileChange(ev) {
	let reader = new FileReader();
	if ( event.target.files && event.target.files.length > 0) {
		let file = event.target.files[0];
		assetDetailFileGo.classList.add('btn-hide');
		assetDetailFileGoLoading.classList.remove('btn-hide');
		reader.readAsDataURL(file);
		reader.onload = () => {
			loadedAsset.url = reader.result;
			loadedAsset.modified = true;
			loadAsset();
			assetDetailFile.value = '';
			assetDetailFileGoLoading.classList.add('btn-hide');
			assetDetailFileGo.classList.remove('btn-hide');
		};
	}
}

function saveAsset() {
	let validate = true;
	if (assetDetailName.value=='') {
		validate = false;
		alert('¡No puedes dejar el nombre del recurso en blanco!');
		assetDetailName.focus();
	}

	if (validate && loadedAsset.url===null) {
		validate = false;
		alert('¡No has elegido ningún archivo!');
	}

	if (validate) {
		updateAsset();
		if (!loadedAsset.modified) {
			loadedAsset.url = null;
		}
		else {
			loadedAsset.url = urlencode(loadedAsset.url);
		}
		assetGo.classList.add('btn-hide');
		assetGoLoading.classList.remove('btn-hide');
		postAjax('/admin/save-asset', loadedAsset, saveAssetSuccess);
	}
}

function saveAssetSuccess(result) {
	assetGoLoading.classList.add('btn-hide');
	assetGo.classList.remove('btn-hide');
	if (result.status=='ok') {
		showAddAsset();
		loadAssets();
		loadTags();
	}
	else {
		alert('¡Ocurrió un error al guardar el recurso!');
	}
}

function editAsset(ev) {
	const assetId = parseInt(ev.target.dataset.id);
	const ind = assetList.findIndex(x => x.id==assetId);

	loadedAsset.id = assetList[ind].id;
	loadedAsset.id_world = assetList[ind].id_world;
	loadedAsset.name = urldecode(assetList[ind].name);
	loadedAsset.url = urldecode(assetList[ind].url);
	loadedAsset.tags = assetList[ind].tags;

	assetDetailHeader.innerHTML = 'Editar recurso';
	loadAsset();
	assetDetail.classList.add('asset-detail-show');
}

function deleteAsset(ev) {
	const assetId = parseInt(ev.target.dataset.id);
	const ind = assetList.findIndex(x => x.id==assetId);

	const conf = confirm('¿Estás seguro de querer borrar el recurso "'+urldecode(assetList[ind].name)+'"?');
	if (conf) {
		postAjax('/admin/delete-asset', {id: assetList[ind].id}, deleteAssetSuccess);
	}
}

function deleteAssetSuccess(result) {
	if (result.status=='ok') {
		loadAssets();
		loadTags();
	}
	else {
		alert('¡Ocurrio un error al borrar el recurso!');
	}
}