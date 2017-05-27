/*
 * Objeto que contiene al jugador
 */
const player = {
  name: '',
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
    this.setName(player_name);
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
  
  getDestinationTile: function(pos){
    const x = (this.getOrientation()==='right') ? (pos.x + pos.width)  : pos.x;
    const y = (this.getOrientation()==='down')  ? (pos.y + pos.height) : pos.y;
    return {
      x: Math.floor( x / Val.cell.width),
      y: Math.floor( y / Val.cell.height),
    };
  },
  
  moveUp: function(){
    const new_pos = {
      x: this.getPositionX(),
      y: this.getPositionY() - Val.step,
      orientation: 'up'
    };
    this.move(new_pos);
  },
  moveRight: function(){
    const new_pos = {
      x: this.getPositionX() + Val.step,
      y: this.getPositionY(),
      orientation: 'right'
    };
    this.move(new_pos);
  },
  moveDown: function(){
    const new_pos = {
      x: this.getPositionX(),
      y: this.getPositionY() + Val.step,
      orientation: 'down'
    };
    this.move(new_pos);
  },
  moveLeft: function(){
    const new_pos = {
      x: this.getPositionX() - Val.step,
      y: this.getPositionY(),
      orientation: 'left'
    };
    this.move(new_pos);
  },

  move: function(pos){
    const obj_player = document.getElementById('player');
    obj_player.classList.remove('player_'+this.getOrientation());
    obj_player.classList.add('player_'+pos.orientation);
    this.setOrientation(pos.orientation);

    const coords = obj_player.getBoundingClientRect();
    pos.width = Math.floor(coords.width)-1;
    pos.height = Math.floor(coords.height)-1;

    if ( (pos.x<0) || ( (pos.x+pos.width)>=board.clientWidth) || ( (pos.y+pos.height)>=board.clientHeight) || (pos.y<0) ){
      return false;
    }
    
    const dest = this.getDestinationTile(pos);
    console.log(dest);
    const dest_scn = scenario[dest.y][dest.x];
    console.log(dest_scn);
    let destIsBlocker = false;
    if (dest_scn.bck && !backgrounds.list['bck_'+dest_scn.bck].crossable){
      destIsBlocker = true;
    }
    if (dest_scn.spr && !sprites.list['spr_'+dest_scn.spr].crossable){
      destIsBlocker = true;
    }
    if (destIsBlocker) {
      const dest_cell = document.getElementById('cell_' + dest.x + '_' + dest.y);
      console.log(dest_cell);
      const obj = {
        x: dest_cell.offsetLeft,
        y: dest_cell.offsetTop,
        width: dest_cell.offsetWidth,
        height: dest_cell.offsetHeight
      };

      let hasBlocker = false;
      if (pos.x < obj.x + obj.width && pos.x + pos.width > obj.x && pos.y < obj.y + obj.height && pos.height + pos.y > obj.y) {
        hasBlocker = true;
      }

      if (hasBlocker) {
        return false;
      }
    }

    this.setPosition(pos.x, pos.y);
    obj_player.style.left  = pos.x + 'px';
    obj_player.style.top = pos.y + 'px';
  }
};