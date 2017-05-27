class Character{
  constructor(){
    this.x = 0;
    this.y = 0;
    this.width = 0;
    this.height = 0;

    this.vx = 0;
    this.vy = 0;

    this.frames = [];
    this.loop = true;
    this._currentFrame = 0;
    this.playing = false;

    this.previousX = 0;
    this.previousY = 0;

    this.health = 10;
    this.isNpc = false;
    this.items  = [];
  }

  get gx() {
    return this.x;
  }
  get gy() {
    return this.y;
  }
  get halfWidth() {
    return this.width / 2;
  }
  get halfHeight() {
    return this.height / 2;
  }
  get centerX() {
    return this.x + this.halfWidth;
  }
  get centerY() {
    return this.y + this.halfHeight;
  }
  get position() {
    return {x: this.x, y: this.y};
  }
  setPosition(x, y) {
    this.x = x;
    this.y = y;
  }
  get currentFrame() {
    return this._currentFrame;
  }
  addItem(item) {
    this.items.add(item);
  }
  removeItem(item) {
    this.items.splice(this.items.indexOf(item), 1);
  }
}

class Player extends Character{
  constructor() {
    super();
  }
}

class NPC extends Character{
  constructor() {
    super();
    this.isNpc = true;
  }
}

class Monster extends Character{
  constructor() {
    super();
  }
}