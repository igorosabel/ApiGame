'use strict';

let stage;
let player;

function setup(){
  stage = new Stage(800, 600, 18, 24);
  player = makePlayer(startPos, {w: stage.tile_width, h: stage.tile_height});

  assets.list.forEach(asset => {
    if (asset.type==='bck') {
      let bck = makeSprite(asset.image, asset.crossable);
      stage.addBck(bck, asset.x, asset.y);
    }
    if (asset.type==='spr'){
      let spr = makeSprite(asset.image, asset.crossable);
      stage.addSpr(spr, asset.x, asset.y);
    }
    if (asset.type==='player'){
      let orient = makeSprite(asset.image);
      player.setSprite(asset.id, orient);
    }
  });
  stage.render();
  player.render(stage.getCtx());
  
  let up = keyboard(38);
  up.press = () => player.up();
  up.release = () => player.stopUp();
  
  let down = keyboard(40);
  down.press = () => player.down();
  down.release = () => player.stopDown();
  
  let right = keyboard(39);
  right.press = () => player.right();
  right.release = () => player.stopRight();
  
  let left = keyboard(37);
  left.press = () => player.left();
  left.release = () => player.stopLeft();
  
  gameLoop();
}

function gameLoop(){
  requestAnimationFrame(gameLoop);
  stage.render();
  player.move();
  player.render(stage.getCtx());
}