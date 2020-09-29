'use strict';

function makeCanvas(
	width = 256,
	height = 256,
	border = '1px dashed black',
	backgroundColor = 'white'
) {
	let canvas = document.createElement('canvas');
	canvas.id = 'board';
	canvas.className = 'board';
	canvas.width = width;
	canvas.height = height;
	canvas.style.border = border;
	canvas.style.backgroundColor = backgroundColor;
	document.querySelector('.game').appendChild(canvas);

	canvas.ctx = canvas.getContext('2d');

	return canvas;
}

class Scenario {
	constructor(width = 256, height = 256, rows = 16, cols = 16) {
		// Modo debug
		this.debug = false;

		// Creo el canvas
		this.canvas = makeCanvas(width, height);
		this._width = width;
		this._height = height;

		// Calculo tamaño de cada tile
		this.tile_width = width / cols;
		this.tile_height = height / rows;

		// Creo los tiles
		this.tiles = {};
		for (let y=1; y<=rows; y++) {
			for (let x=1; x<=cols; x++) {
				let pos = {
					x: (x-1) * this.tile_width,
					y: (y-1) * this.tile_height
				};
				this.tiles[x + '-' + y] = makeTile({x, y}, pos, {w: this.tile_width, h: this.tile_height});
			}
		}

		// Tiles con colision
		this.blockers = [];
	}
	get width() {
		return this._width;
	}
	get height() {
		return this._height;
	}
	get ctx() {
		return this.canvas.ctx;
	}
	addBck(pos, bck) {
		this.tiles[pos.x + '-' + pos.y].addBck(bck);
		if (this.tiles[pos.x + '-' + pos.y].crossable===false) {
			this.addBlocker(this.tiles[pos.x + '-' + pos.y]);
		}
	}
	addSpr(pos, spr) {
		this.tiles[pos.x + '-' + pos.y].addSpr(spr);
		if (this.tiles[pos.x + '-' + pos.y].crossable===false) {
			this.addBlocker(this.tiles[pos.x + '-' + pos.y]);
		}
	}
	removeTile(pos) {
		let tile = this.tiles[pos.x + '-' + pos.y];
		this.blockers.splice(this.blockers.indexOf(tile), 1);
		delete this.tiles[pos.x + '-' + pos.y];
	}
	addBlocker(tile) {
		this.blockers.push(tile);
	}
	render() {
		for (let i in this.tiles) {
			this.tiles[i].render(this.ctx);
		}
	}
}

function makeScenario(width, height, rows, cols) {
	return new Scenario(width, height, rows, cols);
}

class Tile {
	constructor(ind, pos, size) {
		this.ind = ind;
		this.pos = pos;
		this.size = size;
		this.center = {
			x: this.pos.x + (this.size.w / 2),
			y: this.pos.y + (this.size.h / 2)
		};
		this.bck = null;
		this.spr = null;
		this.crossable = true;
	}
	addBck(bck) {
		this.bck = bck;
		if (bck.crossable===false) { this.crossable = false; }
	}
	deleteBck() {
		this.bck = null;
	}
	addSpr(spr) {
		this.spr = spr;
		if (spr.crossable===false) { this.crossable = false; }
	}
	deleteSpr() {
		this.spr = null;
	}
	render() {
		let ctx = scenario.ctx;
		if (scenario.debug) {
			ctx.strokeStyle = 'black';
			ctx.lineWidth = 1;
			ctx.fillStyle = 'white';
			ctx.beginPath();
			ctx.rect(this.pos.x, this.pos.y, this.size.w, this.size.h);
			ctx.stroke();
			ctx.fill();
		}

		if (this.bck && this.bck.img) {
			ctx.drawImage(this.bck.img, this.pos.x, this.pos.y, this.size.w, this.size.h);
		}
		if (this.spr && this.spr.img){
			ctx.drawImage(this.spr.img, this.pos.x, this.pos.y, this.size.w, this.size.h);
		}
	}
}

function makeTile(ind, pos, size) {
	return new Tile(ind, pos, size);
}

class Sprite {
	constructor(img, crossable) {
		this.img = img;
		this.crossable = crossable;
	}
}

function makeSprite(img, crossable) {
	return new Sprite(img, crossable);
}

class Hud {
	constructor(health, currentHealth, money) {
		this.health = health;
		this.currentHealth = currentHealth;
		this.money = money;
		this.sprites = {};
	}
	addSprite(ind, spr) {
		this.sprites[ind] = spr;
	}
	render() {
		let ctx = scenario.ctx;
		let posY = 20;

		// Money
		ctx.drawImage(this.sprites['money'].img, 10, posY, 8, 10);
		ctx.font = "18px 'GraphicPixel'";
		ctx.fillStyle = '#fff';
		ctx.fillText(this.money, 25, 32);

		// Health
		let hearts = this.health / 20;
		let posX = 60;
		for (let i=0; i<hearts; i++) {
			ctx.drawImage(this.sprites['heart_full'].img, (posX + (i * 20)), posY, 14, 13);
		}
	}
}

function makeHud(health, currentHealth, money) {
	return new Hud(health, currentHealth, money);
}

function collission(obj1, obj2) {
	let rect1 = {x: obj1.pos.x, y: obj1.pos.y, width: obj1.size.w, height: obj1.size.h};
	let rect2 = {x: obj2.pos.x, y: obj2.pos.y, width: obj2.size.w, height: obj2.size.h};

	if (rect1.x < rect2.x + rect2.width &&
		rect1.x + rect1.width > rect2.x &&
		rect1.y < rect2.y + rect2.height &&
		rect1.height + rect1.y > rect2.y) {
		return true;
	}

	return false;
}

function keyboard(keyCode) {
	let key = {};
	key.code = keyCode;
	key.isDown = false;
	key.isUp = true;
	key.press = undefined;
	key.release = undefined;

	key.downHandler = function(event) {
		if (event.keyCode === key.code) {
			if (key.isUp && key.press) { key.press(); }
			key.isDown = true;
			key.isUp = false;
		}
		event.preventDefault();
	};
	key.upHandler = function(event) {
		if (event.keyCode === key.code) {
			if (key.isDown && key.release) { key.release(); }
			key.isDown = false;
			key.isUp = true;
		}
		event.preventDefault();
	};

	window.addEventListener('keydown', key.downHandler.bind(key), false);
	window.addEventListener('keyup', key.upHandler.bind(key), false);
	return key;
}