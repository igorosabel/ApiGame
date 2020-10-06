const list = document.querySelector('#list');
const addBtn = document.querySelector('#add-btn');
addBtn.addEventListener('click', showAddScenario);
const scenarioDetail = document.querySelector('#scenario');
const scenarioDetailHeader = document.querySelector('#scenario-header');
const scenarioDetailClose = document.querySelector('#scenario-close');
scenarioDetailClose.addEventListener('click', showAddScenario);
const scenarioDetailName = document.querySelector('#scenario-name');
const scenarioDetailFriendly = document.querySelector('#scenario-friendly');
const scenarioGo = document.querySelector('#scenario-go');
scenarioGo.addEventListener('click', saveScenario);

window.onload = () => {
	updateList();
};

function loadScenarios() {
	list.innerHTML = template('scenario-list-empty', {mesg: 'Cargando...'});
	postAjax('/admin/scenario-list', {id: worldId}, loadScenariosSuccess);
}

function loadScenariosSuccess(result) {
	if (result.status=='ok') {
		scenarioList = result.list;
		updateList();
	}
	else {
		alert('¡Ocurrió un error al obtener la lista de escenarios!');
		list.innerHTML = template('scenario-list-empty', {mesg: 'ERROR'});
	}
}

function updateList() {
	list.innerHTML = template('scenario-list-empty', {mesg: 'Cargando...'});
	if (scenarioList.length>0) {
		list.innerHTML = '';
		for (let scenario of scenarioList) {
			let str = template('scenario-list-item', {
				id: scenario.id,
				id_world: scenario.id_world,
				name: urldecode(scenario.name)
			});
			list.innerHTML += str;
		}
		let editButtons = document.querySelectorAll('.scenario-edit');
		editButtons.forEach((item, i) => {
			item.addEventListener('click', editScenario);
		});
		let deleteButtons = document.querySelectorAll('.scenario-delete');
		deleteButtons.forEach((item, i) => {
			item.addEventListener('click', deleteScenario);
		});
	}
	else {
		list.innerHTML = template('scenario-list-empty', {mesg: 'Todavía no hay ningún escenario.'});
	}
}

const loadedScenario = {
	id: null,
	id_world: worldId,
	name: null,
	friendly: false
};

function resetLoadedScenario() {
	loadedScenario.id = null;
	loadedScenario.name = null;
	loadedScenario.friendly = false;
}

function loadScenario() {
	scenarioDetailName.value = loadedScenario.name;
	scenarioDetailFriendly.checked = loadedScenario.friendly;
}

function updateScenario() {
	loadedScenario.name = scenarioDetailName.value;
	loadedScenario.friendly = scenarioDetailFriendly.checked;
}

function showAddScenario(ev = null) {
	ev && ev.preventDefault();
	if (!scenarioDetail.classList.contains('scenario-detail-show')) {
		resetLoadedScenario();
		scenarioDetailHeader.innerHTML = 'Nuevo escenario';
		loadScenario();

		scenarioDetail.classList.add('scenario-detail-show');
	}
	else {
		scenarioDetail.classList.remove('scenario-detail-show');
	}
}

function saveScenario() {
	let validate = true;
	if (scenarioDetailName.value=='') {
		validate = false;
		alert('¡No puedes dejar el nombre del escenario en blanco!');
		scenarioDetailName.focus();
	}

	if (validate) {
		updateScenario();
		postAjax('/admin/save-scenario', loadedScenario, saveScenarioSuccess);
	}
}

function saveScenarioSuccess(result) {
	if (result.status=='ok') {
		showAddScenario();
		loadScenarios();
	}
	else {
		alert('¡Ocurrió un error al guardar el escenario!');
	}
}

function editScenario(ev) {
	const scenarioId = parseInt(ev.target.dataset.id);
	const ind = scenarioList.findIndex(x => x.id==scenarioId);

	loadedScenario.id = scenarioList[ind].id;
	loadedScenario.name = urldecode(scenarioList[ind].name);
	loadedScenario.friendly = scenarioList[ind].friendly;

	scenarioDetailHeader.innerHTML = 'Editar escenario';
	loadScenario();
	scenarioDetail.classList.add('scenario-detail-show');
}

function deleteScenario(ev) {
	const scenarioId = parseInt(ev.target.dataset.id);
	const ind = scenarioList.findIndex(x => x.id==scenarioId);

	const conf = confirm('¿Estás seguro de querer borrar el escenario "'+urldecode(scenarioList[ind].name)+'"?');
	if (conf) {
		postAjax('/admin/delete-scenario', {id: scenarioList[ind].id}, deleteScenarioSuccess);
	}
}

function deleteScenarioSuccess(result) {
	if (result.status=='ok') {
		loadScenarios();
	}
	else {
		alert('¡Ocurrio un error al borrar el escenario!');
	}
}