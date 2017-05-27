<header>
  <img src="/img/triforce.png" />
  The Legend Of Zelda
</header>

<div class="game"></div>

<script src="/js/lib/assets.js"></script>
<script src="/js/lib/game.js"></script>
<script src="/js/lib/stage.js"></script>
<script>
  const res = {{res}};
  let dataToLoad = [ {{assets}},
    {type: 'player', x: 0, y: 0, id: 'up'},
    {type: 'player', x: 0, y: 0, id: 'right'},
    {type: 'player', x: 0, y: 0, id: 'down'},
    {type: 'player', x: 0, y: 0, id: 'left'} ];
  const startPos = { x: {{position_x}}, y: {{position_y}} };
  assets.load(dataToLoad).then(() => setup());
</script>