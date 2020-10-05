const list = document.querySelector('#list');
const addBtn = document.querySelector('#add-btn');
addBtn.addEventListener('click', showAddWorld);
const worldDetail = document.querySelector('#world');
const worldDetailHeader = document.querySelector('#world-header');
const worldDetailClose = document.querySelector('#world-close');
worldDetailClose.addEventListener('click', showAddWorld);
const worldDetailName = document.querySelector('#world-name');
const worldDetailDescription = document.querySelector('#world-description');
const worldDetailWordOne = document.querySelector('#world-word-one');
const worldDetailWordTwo = document.querySelector('#world-word-two');
const worldDetailWordThree = document.querySelector('#world-word-three');
const worldDetailFriendly = document.querySelector('#world-friendly');
const worldGo = document.querySelector('#world-go');
worldGo.addEventListener('click', saveWorld);

window.onload = () => {
	loadWorlds();
};

let worldList = [];

function loadWorlds() {
	list.innerHTML = template('world-list-empty', {mesg: 'Cargando...'});
	postAjax('/admin/world-list', {}, loadWorldsSuccess);
}

function loadWorldsSuccess(result) {
	if (result.status=='ok') {
		worldList = result.list;
		updateList();
	}
	else {
		alert('¡Ocurrió un error al obtener la lista de mundos!');
		list.innerHTML = template('world-list-empty', {mesg: 'ERROR'});
	}
}

function updateList() {
	list.innerHTML = template('world-list-empty', {mesg: 'Cargando...'});
	if (worldList.length>0) {
		list.innerHTML = '';
		for (let world of worldList) {
			let str = template('world-list-item', {
				id: world.id,
				name: urldecode(world.name)
			});
			list.innerHTML += str;
		}
		let editButtons = document.querySelectorAll('.world-edit');
		editButtons.forEach((item, i) => {
			item.addEventListener('click', editWorld);
		});
		let deleteButtons = document.querySelectorAll('.world-delete');
		deleteButtons.forEach((item, i) => {
			item.addEventListener('click', deleteWorld);
		});
	}
	else {
		list.innerHTML = template('world-list-empty', {mesg: 'Todavía no hay ningún mundo.'});
	}
}

const loadedWorld = {
	id: null,
	name: null,
	description: null,
	word_one: null,
	word_two: null,
	word_three: null,
	friendly: false
};

function resetLoadedWorld() {
	loadedWorld.id = null;
	loadedWorld.name = null;
	loadedWorld.description = null;
	loadedWorld.word_one = null;
	loadedWorld.word_two = null;
	loadedWorld.word_three = null;
	loadedWorld.friendly = false;
}

function loadWorld() {
	worldDetailName.value = loadedWorld.name;
	worldDetailDescription.value = loadedWorld.description;
	worldDetailWordOne.value = loadedWorld.word_one;
	worldDetailWordTwo.value = loadedWorld.word_two;
	worldDetailWordThree.value = loadedWorld.word_three;
	worldDetailFriendly.checked = loadedWorld.friendly;
}

function updateWorld() {
	loadedWorld.name = worldDetailName.value;
	loadedWorld.description = (worldDetailDescription.value!='' ? worldDetailDescription.value : null);
	loadedWorld.word_one = worldDetailWordOne.value;
	loadedWorld.word_two = worldDetailWordTwo.value;
	loadedWorld.word_three = worldDetailWordThree.value;
	loadedWorld.friendly = worldDetailFriendly.checked;
}

function showAddWorld(ev = null) {
	ev && ev.preventDefault();
	if (!worldDetail.classList.contains('world-detail-show')) {
		resetLoadedWorld();
		worldDetailHeader.innerHTML = 'Nuevo mundo';
		loadWorld();

		worldDetail.classList.add('world-detail-show');
	}
	else {
		worldDetail.classList.remove('world-detail-show');
	}
}

function saveWorld() {
	let validate = true;
	if (worldDetailName.value=='') {
		validate = false;
		alert('¡No puedes dejar el nombre del mundo en blanco!');
		worldDetailName.focus();
	}

	if (validate && worldDetailWordOne.value=='') {
		validate = false;
		alert('¡No puedes dejar la primera palabra en blanco!');
		worldDetailWordOne.focus();
	}

	if (validate && worldDetailWordTwo.value=='') {
		validate = false;
		alert('¡No puedes dejar la segunda palabra en blanco!');
		worldDetailWordTwo.focus();
	}

	if (validate && worldDetailWordThree.value=='') {
		validate = false;
		alert('¡No puedes dejar la tercera palabra en blanco!');
		worldDetailWordThree.focus();
	}

	updateWorld();
	postAjax('/admin/save-world', loadedWorld, saveWorldSuccess);
}

function saveWorldSuccess(result) {
	if (result.status=='ok') {
		showAddWorld();
		loadWorlds();
	}
	else {
		alert('¡Ocurrió un error al guardar el mundo!');
	}
}

function editWorld(ev) {
	console.log(ev);
}

function deleteWorld(ev) {
	console.log(ev);
}