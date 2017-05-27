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
    this.center = {
      x: this.pos.x + (this.size.w/2),
      y: this.pos.y + (this.size.h/2)
    }
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
    this.center = {};
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
    this.updateCenter();
  }
  setSprite(ind, sprite){
    this.sprites[ind.replace('player_','')] = sprite;
  }
  updateCenter(){
    this.center = {
      x: this.pos.x + (this.size.w/2),
      y: this.pos.y + (this.size.h/2)
    }
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
      let newPosX = this.pos.x + this.vx;
      let newPosY = this.pos.y + this.vy;
      // Colisión con los bordes de la pantalla
      if (newPosX<0 || newPosY<0 || (newPosX+this.size.w)>stage.canvas.width || (newPosY+this.size.h)>stage.canvas.height){
        return false;
      }
      // Colisión con objetos
      let hit = false;
      let newPos = {
        pos: {x: newPosX, y: newPosY},
        size: this.size
      }
      stage.blockers.forEach(tile => {
        if (collission(newPos,tile)){
          console.log('colision',newPos,tile);
          hit = true;
        }
      });
      if (hit){
        return false;
      }
      // Actualizo posición
      this.pos.x += this.vx;
      this.pos.y += this.vy;
      this.updateCenter();
    }
  }
  render(ctx){
    ctx.drawImage(this.sprites[this.orientation].img, this.pos.x, this.pos.y, this.size.w, this.size.h);
  }
}

function makePlayer(pos, size){
  return new Player(pos, size);
}

function collission(obj1, obj2){
  var rect1 = {x: obj1.pos.x, y: obj1.pos.y, width: obj1.size.w, height: obj1.size.h};
  var rect2 = {x: obj2.pos.x, y: obj2.pos.y, width: obj2.size.w, height: obj2.size.h};
  
  if (rect1.x < rect2.x + rect2.width &&
     rect1.x + rect1.width > rect2.x &&
     rect1.y < rect2.y + rect2.height &&
     rect1.height + rect1.y > rect2.y) {
      return true;
  }

  return false;
}

function hitTestRectangle(r1, r2){
  let hit, combinedHalfWidths, combinedHalfHeights, vx, vy;
  //A variable to determine whether there's a collision
  hit = false;
  //Calculate the distance vector
  vx = r1.center.x - r2.center.x;
  vy = r1.center.y - r2.center.y;

  //Figure out the combined half-widths and half-heights
  combinedHalfWidths = (r1.size.w /2) + (r2.size.w /2);
  combinedHalfHeights = (r1.size.h /2) + (r2.size.h /2);
  
  //Check for a collision on the x axis
  if (Math.abs(vx) < combinedHalfWidths) {
    //A collision might be occurring. Check for a collision on the y axis
    if (Math.abs(vy) < combinedHalfHeights) {
      //There's definitely a collision happening
      hit = true;
    } else {
      //There's no collision on the y axis
      hit = false;
    }
  } else {
    //There's no collision on the x axis
    hit = false;
  }
  //`hit` will be either `true` or `false`
  return hit;
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
    this.debug = true;

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
    
    // Tiles con colision
    this.blockers = [];
  }
  addBck(bck, x, y){
    this.tiles[x+'-'+y].addBck(bck);
    if (this.tiles[x+'-'+y].crossable===false){
      this.addBlocker(this.tiles[x+'-'+y]);
    }
  }
  addSpr(spr, x, y){
    this.tiles[x+'-'+y].addSpr(spr);
    if (this.tiles[x+'-'+y].crossable===false){
      this.addBlocker(this.tiles[x+'-'+y]);
    }
  }
  removeTile(x,y){
    let tile = this.tiles[x+'-'+y];
    this.blockers.splice(this.blockers.indexOf(tile),1);
    delete this.tiles[x+'-'+y];
  }
  addBlocker(tile){
    this.blockers.push(tile);
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