const addBtn   = document.getElementById('add-btn');
const closeBtn = document.getElementById('add-scn-close');
const saveBtn  = document.getElementById('new-scn-go');

addBtn.addEventListener('click', showAddBox);
closeBtn.addEventListener('click', closeAddBox);
saveBtn.addEventListener('click', newScenario);

function showAddBox(e) {
	e.preventDefault();
	const ovl = document.getElementById('add-scn');
	let txt = document.getElementById('new-scn-name');

	txt.value = '';
	ovl.classList.add('add-box-show');
	txt.focus();
}

function closeAddBox(e = null) {
	e && e.preventDefault();
	document.getElementById('add-scn').classList.remove('add-box-show');
}

function newScenario() {
	const txt = document.getElementById('new-scn-name');
	if (txt.value=='') {
		alert('¡No puedes dejar el nombre del escenario en blanco!');
		txt.focus();
		return false;
	}

	postAjax('/api/new-scenario', {name: urlencode(txt.value)}, newScenarioSuccess);
}

function newScenarioSuccess(data) {
	if (data.status=='ok') {
		document.getElementById('scn-list').innerHTML += template('scn-tpl' ,{id: data.id, name: urldecode(data.name), slug: slugify(urldecode(data.name))});
		closeAddBox();
	}
	else {
		alert('¡Ocurrió un error al guardar el nuevo escenario!');
	}
}