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
  
    const where = document.getElementById('cell_'+this.getPositionX()+'_'+this.getPositionY());
    where.appendChild(obj);
  },
  
  moveUp: function(){
    const new_pos = {
      x: this.getPositionX() -1,
      y: this.getPositionY(),
      orientation: 'up'
    }
    this.move(new_pos);
  },
  moveRight: function(){
    const new_pos = {
      x: this.getPositionX(),
      y: this.getPositionY() +1,
      orientation: 'right'
    }
    this.move(new_pos);
  },
  moveDown: function(){
    const new_pos = {
      x: this.getPositionX() +1,
      y: this.getPositionY(),
      orientation: 'down'
    }
    this.move(new_pos);
  },
  moveLeft: function(){
    const new_pos = {
      x: this.getPositionX(),
      y: this.getPositionY() -1,
      orientation: 'left'
    }
    this.move(new_pos);
  },
  move: function(pos){
    if ( (pos.x==-1) || (pos.x==scenario.length) || (pos.y==scenario[pos.x].length) || (pos.y==-1) ){
      return false;
    }
    
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
    this.setPosition(pos.x, pos.y);
    const obj_player = document.getElementById('player');
    
    obj_player.classList.remove('player_'+this.getOrientation());
    obj_player.classList.add('player_'+pos.orientation);
    
    this.setOrientation(pos.orientation);
    const dest = document.getElementById('cell_'+this.getPositionX()+'_'+this.getPositionY());
    dest.appendChild(obj_player);
  }
};