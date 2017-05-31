'use strict';

let scenario,
    player,
    defaultVX = 3,
    defaultVY = 3,
    fps = 30,
    start = 0,
    frameDuration = 1000 / fps;

function setup(){
  scenario = makeScenario(800, 600, 18, 24);
  player = makePlayer({x: startPos.x * scenario.tile_width, y: startPos.y * scenario.tile_height}, {w: scenario.tile_width, h: (scenario.tile_height * 1.5)});

  // Cargo assets en el escenario
  assets.list.forEach(asset => {
    if (asset.type==='bck') {
      let bck = makeSprite(asset.image, asset.crossable);
      scenario.addBck({x: asset.x, y: asset.y}, bck);
    }
    if (asset.type==='spr'){
      let spr = makeSprite(asset.image, asset.crossable);
      scenario.addSpr({x: asset.x, y: asset.y}, spr);
    }
    if (asset.type==='player'){
      let fr = makeSprite(asset.image);
      let ind = asset.id.replace('player_','');
      ind = ind.split('_').shift();
      player.setSprite(ind, fr);
    }
  });
  
  // Pinto escenario
  scenario.render();
  player.render();
  
  // Eventos de teclado
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
  
  // Bucle del juego
  gameLoop();
}

function gameLoop(timestamp){
  requestAnimationFrame(gameLoop);
  if (timestamp >= start){
    scenario.render();
    player.move();
    player.render();
    
    start = timestamp + frameDuration;
  }
}