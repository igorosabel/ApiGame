'use strict';

function makeCanvas(
  width = 256, height = 256,
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

class Tile{
  constructor(ind, pos, size){
    this.ind = ind;
    this.pos = pos;
    this.size = size;
    this.bck = null;
    this.spr = null;
    this.crossable = true;
  }
  addBck(bck){
    this.bck = bck;
    if (bck.crossable===false){ this.crossable = false; }
  }
  deleteBck(){
    this.bck = null;
  }
  addSpr(spr){
    this.spr = spr;
    if (spr.crossable===false){ this.crossable = false; }
  }
  deleteSpr(){
    this.spr = null;
  }
  render(ctx){
    if (stage.debug) {
      ctx.strokeStyle = 'black';
      ctx.lineWidth = 1;
      ctx.fillStyle = 'white';
      ctx.beginPath();
      ctx.rect(this.pos.x, this.pos.y, this.size.w, this.size.h);
      ctx.stroke();
      ctx.fill();
    }

    if (this.bck && this.bck.img){
      ctx.drawImage(this.bck.img, this.pos.x, this.pos.y, this.size.w, this.size.h);
    }
    if (this.spr && this.spr.img){
      ctx.drawImage(this.spr.img, this.pos.x, this.pos.y, this.size.w, this.size.h);
    }
  }
}

function makeTile(ind, pos, size){
  return new Tile(ind, pos, size);
}

class Sprite{
  constructor(img, crossable){
    this.img = img;
    this.crossable = crossable;
  }
}

function makeSprite(img, crossable){
  return new Sprite(img, crossable);
}

class Player{
  constructor(pos, size){
    this.orientation = 'down';
    this.pos = {
      x: pos.x * size.w,
      y: pos.y * size.h
    };
    this.size = size;
    this.sprites = {
      up: null,
      right: null,
      down: null,
      left: null
    }
    this.vx = 0;
    this.vy = 0;
    this.moving = {
      up: false,
      down: false,
      right: false,
      left: false
    }
  }
  setSprite(ind, sprite){
    this.sprites[ind.replace('player_','')] = sprite;
  }
  up(){
    if (!this.moving.up){
      this.vy = -1;
      this.moving.up = true;
    }
    this.orientation = 'up';
  }
  stopUp(){
    this.moving.up = false;
    this.vy = 0;
  }
  down(){
    if (!this.moving.down){
      this.vy = 1;
      this.moving.down = true;
    }
    this.orientation = 'down';
  }
  stopDown(){
    this.moving.down = false;
    this.vy = 0;
  }
  right(){
    if (!this.moving.right){
      this.vx = 1;
      this.moving.right = true;
    }
    this.orientation = 'right';
  }
  stopRight(){
    this.moving.right = false;
    this.vx = 0;
  }
  left(){
    if (!this.moving.left){
      this.vx = -1;
      this.moving.left = true;
    }
    this.orientation = 'left';
  }
  stopLeft(){
    this.moving.left = false;
    this.vx = 0;
  }
  move(){
    if (this.moving.up || this.moving.down || this.moving.right || this.moving.left){
      this.pos.x += this.vx;
      this.pos.y += this.vy;
    }
  }
  render(ctx){
    ctx.drawImage(this.sprites[this.orientation].img, this.pos.x, this.pos.y, this.size.w, this.size.h);
  }
}

function makePlayer(pos, size){
  return new Player(pos, size);
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
      if (key.isUp && key.press) key.press();
      key.isDown = true;
      key.isUp = false;
    }
    event.preventDefault();
  };
  key.upHandler = function(event) {
    if (event.keyCode === key.code) {
      if (key.isDown && key.release) key.release();
      key.isDown = false;
      key.isUp = true;
    }
    event.preventDefault();
  };

  window.addEventListener('keydown', key.downHandler.bind(key), false);
  window.addEventListener('keyup', key.upHandler.bind(key), false);
  return key;
}

class Stage{
  constructor(width = 256, height = 256, rows = 16, cols = 16) {
    // Modo debug
    this.debug = false;

    // Creo el canvas
    this.canvas = makeCanvas(width,height);

    // Calculo tamaño de cada tile
    this.tile_width = width / cols;
    this.tile_height = height / rows;

    // Creo los tiles
    this.tiles = {};
    for (let y=1; y<=rows; y++){
      for (let x=1; x<=cols; x++) {
        let pos = {
          x: (x-1) * this.tile_width,
          y: (y-1) * this.tile_height
        };
        this.tiles[x+'-'+y] = makeTile({x, y}, pos, {w: this.tile_width, h: this.tile_height});
      }
    }
  }
  addBck(bck, x, y){
    this.tiles[x+'-'+y].addBck(bck);
  }
  addSpr(spr, x, y){
    this.tiles[x+'-'+y].addSpr(spr);
  }
  removeTile(x,y){
    delete this.tiles[x+'-'+y];
  }
  getCtx(){
    return this.canvas.ctx;
  }
  render() {
    for (let i in this.tiles){
      this.tiles[i].render(this.canvas.ctx);
    }
  }
}