'use strict';

class Asset{
  constructor(type, x, y, id, crossable){
    this.type = type;
    this.x = x;
    this.y = y;
    this.id = id;
    this.image = null;
    this.crossable = crossable;
  }
}

let assets = {
  toLoad: 0,
  loaded: 0,
  list: [],
  load(items) {
    return new Promise(resolve => {
      this.toLoad = items.length;

      let loadHandler = () => {
        this.loaded += 1;
        if (this.toLoad === this.loaded) {
          this.toLoad = 0;
          this.loaded = 0;
          resolve();
        }
      };

      items.forEach(item => {
        let asset = new Asset(item.type, item.x, item.y, item.id, res[item.type][item.type+'_'+item.id].crossable);
        asset.image = new Image();
        asset.image.addEventListener('load', loadHandler, false);
        let folder;
        switch (item.type){
          case 'bck': { folder = 'background'; }
          break;
          case 'spr': { folder = 'sprite'; }
          break;
          case 'player': { folder = 'player'; }
          break;
        }

        asset.image.src = '/assets/' + folder + '/' + res[item.type][item.type+'_'+item.id].url + '.png';

        this.list.push(asset);
      });
    });
  }
};