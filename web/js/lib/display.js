class DisplayObject {
  constructor() {
    //The sprite's position and size
    this.x = 0;
    this.y = 0;
    this.width = 0;
    this.height = 0;

    //Rotation, alpha, visible and scale properties
    this.rotation = 0;
    this.alpha = 1;
    this.visible = true;
    this.scaleX = 1;
    this.scaleY = 1;

    //`pivotX` and `pivotY` let you set the sprite's axis of rotation
    this.pivotX = 0.5;
    this.pivotY = 0.5;

    //Add `vx` and `vy` (velocity) variables that will help us move the sprite
    this.vx = 0;
    this.vy = 0;

    //A "private" `_layer` property
    this._layer = 0;

    //A `children` array on the sprite that will contain all the
    //child sprites in this container
    this.children = [];

    //The sprite's `parent` property
    this.parent = undefined;

    //The sprite's `children` array
    this.children = [];

    //Optional drop shadow properties.
    //Set `shadow` to `true` if you want the sprite to display a
    //shadow
    this.shadow = false;
    this.shadowColor = "rgba(100, 100, 100, 0.5)";
    this.shadowOffsetX = 3;
    this.shadowOffsetY = 3;
    this.shadowBlur = 3;

    //Optional blend mode property
    this.blendMode = undefined;

    //Properties for advanced features:

    //Image states and animation
    this.frames = [];
    this.loop = true;
    this._currentFrame = 0;
    this.playing = false;

    //Is the sprite circular? If it is, it will be given a `radius`
    //and `diameter`
    this._circular = false;

    //The sprite's previous x and y positions
    this.previousX = 0;
    this.previousY = 0;
  }

  /* Essentials */

  //Global position
  get gx() {
    if (this.parent) {

      //The sprite's global x position is a combination of
      //its local x value and its parent's global x value
      return this.x + this.parent.gx;
    } else {
      return this.x;
    }
  }
  get gy() {
    if (this.parent) {
      return this.y + this.parent.gy;
    } else {
      return this.y;
    }
  }

  //Depth layer
  get layer() {
    return this._layer;
  }
  set layer(value) {
    this._layer = value;
    if (this.parent) {
      //Sort the sprite’s parent’s `children` array so that sprites with a
      //higher `layer` value are moved to the end of the array
      this.parent.children.sort((a, b) => a.layer - b.layer);
    }
  }

  //The `addChild` method lets you add sprites to this container
  addChild(sprite) {
    //Remove the sprite from its current parent, if it has one, and
    //the parent isn't already this object
    if (sprite.parent) {
      sprite.parent.removeChild(sprite);
    }
    //Make this object the sprite's parent and
    //add it to this object's `children` array
    sprite.parent = this;
    this.children.push(sprite);
  }

  //The `removeChild` method lets you remove a sprite from its
  //parent container
  removeChild(sprite) {
    if(sprite.parent === this) {
      this.children.splice(this.children.indexOf(sprite), 1);
    } else {
      throw new Error(sprite + "is not a child of " + this);
    }
  }

  //Getters that return useful points on the sprite
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

  /* Conveniences */

  //A `position` getter. It returns an object with x and y properties
  get position() {
    return {x: this.x, y: this.y};
  }

  //A `setPosition` method to quickly set the sprite's x and y values
  setPosition(x, y) {
    this.x = x;
    this.y = y;
  }

  //The `localBounds` and `globalBounds` methods return an object
  //with `x`, `y`, `width`, and `height` properties that define
  //the dimensions and position of the sprite. This is a convenience
  //to help you set or test boundaries without having to know
  //these numbers or request them specifically in your code.
  get localBounds() {
    return {
      x: 0,
      y: 0,
      width: this.width,
      height: this.height
    };
  }
  get globalBounds() {
    return {
      x: this.gx,
      y: this.gy,
      width: this.gx + this.width,
      height: this.gy + this.height
    };
  }

  //`empty` is a convenience property that will return `true` or
  //`false` depending on whether or not this sprite's `children`
  //array is empty
  get empty() {
    return (this.children.length === 0);
  }

  //The "put" methods help you position
  //another sprite in and around this sprite. You can position
  //sprites relative to this sprite's center, top, eight, bottom or
  //left sides. The `xOffset` and `yOffset`
  //arguments determine by how much the other sprite's position
  //should be offset from the position.
  //In all these methods, `b` is the second sprite that is being
  //positioned relative to the first sprite (this one), `a`

  //Center `b` inside `a`
  putCenter(b, xOffset = 0, yOffset = 0) {
    let a = this;
    b.x = (a.x + a.halfWidth - b.halfWidth) + xOffset;
    b.y = (a.y + a.halfHeight - b.halfHeight) + yOffset;
  }
  //Position `b` above `a`
  putTop(b, xOffset = 0, yOffset = 0) {
    let a = this;
    b.x = (a.x + a.halfWidth - b.halfWidth) + xOffset;
    b.y = (a.y - b.height) + yOffset;
  }
  //Position `b` to the right of `a`
  putRight(b, xOffset = 0, yOffset = 0) {
    let a = this;
    b.x = (a.x + a.width) + xOffset;
    b.y = (a.y + a.halfHeight - b.halfHeight) + yOffset;
  }
  //Position `b` below `a`
  putBottom(b, xOffset = 0, yOffset = 0) {
    let a = this;
    b.x = (a.x + a.halfWidth - b.halfWidth) + xOffset;
    b.y = (a.y + a.height) + yOffset;
  }
  //Position `b` to the left of `a`
  putLeft(b, xOffset = 0, yOffset = 0) {
    let a = this;
    b.x = (a.x - b.width) + xOffset;
    b.y = (a.y + a.halfHeight - b.halfHeight) + yOffset;
  }

  //Some extra conveniences for working with child sprites

  //Swap the depth layer positions of two child sprites
  swapChildren(child1, child2) {
    let index1 = this.children.indexOf(child1),
      index2 = this.children.indexOf(child2);
    if (index1 !== -1 && index2 !== -1) {
      //Swap the indexes
      child1.childIndex = index2;
      child2.childIndex = index1;
      //Swap the array positions
      this.children[index1] = child2;
      this.children[index2] = child1;
    } else {
      throw new Error(`Both objects must be a child of the caller ${this}`);
    }
  }

  //`add` and `remove` let you add and remove many sprites at the same time
  add(...spritesToAdd) {
    spritesToAdd.forEach(sprite => this.addChild(sprite));
  }
  remove(...spritesToRemove) {
    spritesToRemove.forEach(sprite => this.removeChild(sprite));
  }

  /* Advanced features */

  //If the sprite has more than one frame, return the
  //value of `_currentFrame`
  get currentFrame() {
    return this._currentFrame;
  }

  //The `circular` property lets you define whether a sprite
  //should be interpreted as a circular object. If you set
  //`circular` to `true`, the sprite is given `radius` and `diameter`
  //properties. If you set `circular` to `false`, the `radius`
  //and `diameter` properties are deleted from the sprite
  get circular() {
    return this._circular;
  }
  set circular (value) {

    //Give the sprite `diameter` and `radius` properties
    //if `circular` is `true`
    if (value === true && this._circular === false) {
      Object.defineProperties(this, {
        diameter: {
          get () {
            return this.width;
          },
          set (value) {
            this.width = value;
            this.height = value;
          },
          enumerable: true, configurable: true
        },
        radius: {
          get() {
            return this.halfWidth;
          },
          set(value) {
            this.width = value * 2;
            this.height = value * 2;
          },
          enumerable: true, configurable: true
        }
      });
      //Set this sprite's `_circular` property to `true`
      this._circular = true;
    }
    //Remove the sprite's `diameter` and `radius` properties
    //if `circular` is `false`
    if (value === false && this._circular === true) {
      delete this.diameter;
      delete this.radius;
      this._circular = false;
    }
  }
}

export let stage = new DisplayObject();

export function makeCanvas(
  width = 256, height = 256,
  border = "1px dashed black",
  backgroundColor = "white"
) {

  //Make the canvas element and add it to the DOM
  let canvas = document.createElement("canvas");
  canvas.width = width;
  canvas.height = height;
  canvas.style.border = border;
  canvas.style.backgroundColor = backgroundColor;
  document.body.appendChild(canvas);

  //Create the context as a property of the canvas
  canvas.ctx = canvas.getContext("2d");

  //Return the canvas
  return canvas;
}

class Group extends DisplayObject {
  constructor(...spritesToGroup){

    //Call the DisplayObject's constructor
    super();

    //Group all the sprites listed in the constructor arguments
    spritesToGroup.forEach(sprite => this.addChild(sprite));
  }
  //Groups have custom `addChild` and `removeChild` methods that call
  //a `calculateSize` method when any sprites are added or removed
  //from the group
  //
  addChild(sprite) {
    if (sprite.parent) {
      sprite.parent.removeChild(sprite);
    }
    sprite.parent = this;
    this.children.push(sprite);

    //Figure out the new size of the group
    this.calculateSize();
  }

  removeChild(sprite) {
    if(sprite.parent === this) {
      this.children.splice(this.children.indexOf(sprite), 1);

      //Figure out the new size of the group
      this.calculateSize();
    } else {
      throw new Error(`${sprite} is not a child of ${this}`);
    }
  }

  calculateSize() {

    //Calculate the width based on the size of the largest child
    //that this sprite contains
    if (this.children.length > 0) {

      //Some temporary private variables to help track the new
      //calculated width and height
      this._newWidth = 0;
      this._newHeight = 0;

      //Find the width and height of the child sprites furthest
      //from the top left corner of the group
      this.children.forEach(child => {

        //Find child sprites that combined x value and width
        //that's greater than the current value of `_newWidth`
        if (child.x + child.width > this._newWidth) {

          //The new width is a combination of the child's
          //x position and its width
          this._newWidth = child.x + child.width;
        }
        if (child.y + child.height > this._newHeight) {
          this._newHeight = child.y + child.height;
        }
      });

      //Apply the `_newWidth` and `_newHeight` to this sprite's width
      //and height
      this.width = this._newWidth;
      this.height = this._newHeight;
    }
  }
}

//A higher level wrapper for the group sprite
export function group(...spritesToGroup) {

  //Create the sprite
  let sprite = new Group(...spritesToGroup);

  //Add the sprite to the stage
  stage.addChild(sprite);

  //Return the sprite to the main program
  return sprite;
}

/*
 Sprite
 ---------

 A Sprite class to make sprites from images
 */

class Sprite extends DisplayObject {
  constructor(
    source,
    x = 0,
    y = 0
  ){
    //Call the DisplayObject's constructor
    super();

    //Assign the argument values to this sprite
    Object.assign(this, {x, y});

    //We need to figure out what the source is, and then use
    //use that source data to display the sprite image correctly
    //Is the source a JavaScript Image object?
    if(source instanceof Image) {
      this.createFromImage(source);
    }
    //Is the source a tileset from a texture atlas?
    //(It is if it has a `frame` property)
    else if (source.frame) {
      this.createFromAtlas(source);
    }
    //If the source contains an `image` sub-property, this must
    //be a `frame` object that's defining the rectangular area of an inner sub-image
    //Use that sub-image to make the sprite. If it doesn't contain a
    //`data` property, then it must be a single frame.
    else if (source.image && !source.data) {
      this.createFromTileset(source);
    }
    //If the source contains an `image` sub-property
    //and a `data` property, then it contains multiple frames
    else if (source.image && source.data) {
      this.createFromTilesetFrames(source);
    }
    //Is the source an array? If so, what kind of array?
    else if (source instanceof Array) {
      if (source[0] && source[0].source) {
        //The source is an array of frames on a texture atlas tileset
        this.createFromAtlasFrames(source);
      }
      //It must be an array of image objects
      else if (source[0] instanceof Image){
        this.createFromImages(source);
      }
      //throw an error if the sources in the array aren't recognized
      else {
        throw new Error(`The image sources in ${source} are not recognized`);
      }
    }
    //Throw an error if the source is something we can't interpret
    else {
      throw new Error(`The image source ${source} is not recognized`);
    }
  }
  createFromImage(source) {
    //Throw an error if the source is not an Image object
    if (!(source instanceof Image)) {
      throw new Error(`${source} is not an image object`);
    } else {
      this.source = source;
      this.sourceX =  0;
      this.sourceY =  0;
      this.width = source.width;
      this.height = source.height;
      this.sourceWidth = source.width;
      this.sourceHeight = source.height;
    }
  }
  createFromAtlas(source) {
    this.tilesetFrame = source;
    this.source = this.tilesetFrame.source;
    this.sourceX = this.tilesetFrame.frame.x;
    this.sourceY = this.tilesetFrame.frame.y;
    this.width = this.tilesetFrame.frame.w;
    this.height = this.tilesetFrame.frame.h;
    this.sourceWidth = this.tilesetFrame.frame.w;
    this.sourceHeight = this.tilesetFrame.frame.h;
  }
  createFromTileset(source) {
    //Throw an error if the source is not an image object
    if (!(source.image instanceof Image)) {
      throw new Error(`${source.image} is not an image object`);
    } else {
      this.source = source.image;
      this.sourceX = source.x;
      this.sourceY = source.y;
      this.width = source.width;
      this.height = source.height;
      this.sourceWidth = source.width;
      this.sourceHeight = source.height;
    }
  }
  createFromTilesetFrames(source) {
    //Throw an error if the source is not an Image object
    if (!(source.image instanceof Image)) {
      throw new Error(`${source.image} is not an image object`);
    } else {
      this.source = source.image;
      this.frames = source.data;
      //Set the sprite to the first frame
      this.sourceX = this.frames[0][0];
      this.sourceY = this.frames[0][1];
      this.width = source.width;
      this.height = source.height;
      this.sourceWidth = source.width;
      this.sourceHeight = source.height;
    }
  }
  createFromAtlasFrames(source) {
    this.frames = source;
    this.source = source[0].source;
    this.sourceX = source[0].frame.x;
    this.sourceY = source[0].frame.y;
    this.width = source[0].frame.w;
    this.height = source[0].frame.h;
    this.sourceWidth = source[0].frame.w;
    this.sourceHeight = source[0].frame.h;
  }
  createFromImages(source) {
    this.frames = source;
    this.source = source[0];
    this.sourceX = 0;
    this.sourceY = 0;
    this.width = source[0].width;
    this.height = source[0].width;
    this.sourceWidth = source[0].width;
    this.sourceHeight = source[0].height;
  }

  //Add a `gotoAndStop` method to go to a specific frame.
  gotoAndStop(frameNumber) {
    if (this.frames.length > 0 && frameNumber < this.frames.length) {

      //a. Frames made from tileset sub-images.
      //If each frame is an array, then the frames were made from an
      //ordinary Image object using the `frames` method
      if (this.frames[0] instanceof Array) {
        this.sourceX = this.frames[frameNumber][0];
        this.sourceY = this.frames[frameNumber][1];
      }

      //b. Frames made from texture atlas frames.
      //If each frame isn't an array, and it has a sub-object called `frame`,
      //then the frame must be a texture atlas id name.
      //In that case, get the source position from the atlas's `frame` object.
      else if (this.frames[frameNumber].frame) {
        this.sourceX = this.frames[frameNumber].frame.x;
        this.sourceY = this.frames[frameNumber].frame.y;
        this.sourceWidth = this.frames[frameNumber].frame.w;
        this.sourceHeight = this.frames[frameNumber].frame.h;
        this.width = this.frames[frameNumber].frame.w;
        this.height = this.frames[frameNumber].frame.h;
      }

      //c. Frames made from individual image objects.
      //If neither of the above are true, then each frame must be
      //an individual Image object
      else {
        this.source = this.frames[frameNumber];
        this.sourceX = 0;
        this.sourceY = 0;
        this.width = this.source.width;
        this.height = this.source.height;
        this.sourceWidth = this.source.width;
        this.sourceHeight = this.source.height;
      }
      //Set the `_currentFrame` value to the chosen frame
      this._currentFrame = frameNumber;
    }
    //Throw an error if this sprite doesn't contain any frames
    else {
      throw new Error(`Frame number ${frameNumber} does not exist`);
    }
  }

  //The `render` method explains how to draw the sprite
  render(ctx) {
    ctx.drawImage(
      this.source,
      this.sourceX, this.sourceY,
      this.sourceWidth, this.sourceHeight,
      -this.width * this.pivotX,
      -this.height * this.pivotY,
      this.width, this.height
    );
  }
}

//A higher level wrapper
export function sprite(source, x, y) {
  //Create the sprite
  let sprite = new Sprite(source, x, y);

  //Add the state player (to control animation) if the
  //sprite has multiple frames
  if (sprite.frames.length > 0) addStatePlayer(sprite);

  //Add the sprite to the stage
  stage.addChild(sprite);

  //Return the sprite to the main program
  return sprite;
}