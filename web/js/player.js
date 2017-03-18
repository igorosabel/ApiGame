/*
 * Objeto que contiene al jugador
 */
const player = {
  name: 'dunedain',
  position: {
    x: position_x,
    y: position_y
  },
  orientation: 'right',
  weapon: {
    name: 'Rusted sword',
    damage: 1
  },
  inventory: [],
  
  setName: function(n){
    this.name = n;
  },
  getName: function(){
    return this.name;
  },
  
  setPosition: function(x,y){
    this.position.x = x;
    this.position.y = y;
  },
  getPosition: function(){
    return this.position;
  },
  
  setOrientation: function(o){
    this.orientation = o;
  },
  getOrientation: function(){
    return this.orientation;
  },
  
  setPositionX: function(x){
    this.position.x = x;
  },
  getPositionX: function(){
    return this.position.x;
  },
  
  setPositionY: function(y){
    this.position.y = y;
  },
  getPositionY: function(){
    return this.position.y;
  },
  
  load: function(){
    let obj = document.createElement('div');
    obj.id = 'player';
    obj.className = 'player';
    obj.classList.add('player_'+this.getOrientation());
  
    const where      = document.getElementById('cell_'+this.getPositionX()+'_'+this.getPositionY());
    const coords     = where.getBoundingClientRect();

    obj.style.top    = where.offsetTop + 'px';
    obj.style.left   = where.offsetLeft + 'px';
    obj.style.height = coords.height + 'px';
    obj.style.width  = coords.width + 'px';
    this.setPosition(where.offsetLeft, where.offsetTop);
    board.appendChild(obj);
  },
  
  moveUp: function(){
    const new_pos = {
      x: this.getPositionX(),
      y: this.getPositionY() - Val.step,
      orientation: 'up'
    }
    this.move(new_pos);
  },
  moveRight: function(){
    const new_pos = {
      x: this.getPositionX() + Val.step,
      y: this.getPositionY(),
      orientation: 'right'
    }
    this.move(new_pos);
  },
  moveDown: function(){
    const new_pos = {
      x: this.getPositionX(),
      y: this.getPositionY() + Val.step,
      orientation: 'down'
    }
    this.move(new_pos);
  },
  moveLeft: function(){
    const new_pos = {
      x: this.getPositionX() - Val.step,
      y: this.getPositionY(),
      orientation: 'left'
    }
    this.move(new_pos);
  },
  move: function(pos){
    const obj_player = document.getElementById('player');
    const coords = obj_player.getBoundingClientRect();
    pos.width = Math.floor(coords.width)-1;
    pos.height = Math.floor(coords.height)-1;

    if ( (pos.x<0) || ( (pos.x+pos.width)>=board.clientWidth) || ( (pos.y+pos.height)>=board.clientHeight) || (pos.y<0) ){
      return false;
    }
    
    let hasBlocker = false;
    for (let i in blockers){
      let obj = blockers[i];
      if (modo_debug){
        console.log('pos',{xy: pos.x+'-'+pos.y, wh: pos.width+'-'+pos.height});
        console.log('obj',{xy: obj.x+'-'+obj.y, wh: obj.width+'-'+obj.height});
      }
      if (pos.x < obj.x + obj.width && pos.x + pos.width > obj.x && pos.y < obj.y + obj.height && pos.height + pos.y > obj.y) {
        hasBlocker = true;
        break;
      }
    }
    if (hasBlocker){
      return false;
    }

/*
    // Busco casilla de destino
    const new_pos_tile = scenario[pos.x][pos.y];
    // Si la casilla de destino no se puede cruzar, fuera
    if (!backgrounds.list['bck_'+new_pos_tile.bck].crossable){
      return false;
    }
    // Si la casilla de destino no se puede cruzar, fuera
    if (new_pos_tile.spr && !sprites.list['spr_'+new_pos_tile.spr].crossable){
      return false;
    }
*/
    this.setPosition(pos.x, pos.y);
    
    
    obj_player.classList.remove('player_'+this.getOrientation());
    obj_player.classList.add('player_'+pos.orientation);
    
    this.setOrientation(pos.orientation);
    obj_player.style.left  = pos.x + 'px';
    obj_player.style.top = pos.y + 'px';
    //const dest = document.getElementById('cell_'+this.getPositionX()+'_'+this.getPositionY());
    //dest.appendChild(obj_player);
  }
};