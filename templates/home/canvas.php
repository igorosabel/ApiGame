<header>
  <img src="/img/triforce.png" />
  The Legend Of Zelda
</header>

<div class="game"></div>

<script src="/js/lib/assets.js"></script>
<script src="/js/lib/characters.js"></script>
<script src="/js/lib/game.js"></script>
<script src="/js/lib/stage.js"></script>
<script>
  const res = {{res}};
  let dataToLoad = [ {{assets}},
    {type: 'player', x: 0, y: 0, id: 'up'},
    {type: 'player', x: 0, y: 0, id: 'up_walking_1'},
    {type: 'player', x: 0, y: 0, id: 'up_walking_2'},
    {type: 'player', x: 0, y: 0, id: 'up_walking_3'},
    {type: 'player', x: 0, y: 0, id: 'up_walking_4'},
    {type: 'player', x: 0, y: 0, id: 'up_walking_5'},
    {type: 'player', x: 0, y: 0, id: 'up_walking_6'},
    {type: 'player', x: 0, y: 0, id: 'up_walking_7'},
    {type: 'player', x: 0, y: 0, id: 'right'},
    {type: 'player', x: 0, y: 0, id: 'right_walking_1'},
    {type: 'player', x: 0, y: 0, id: 'right_walking_2'},
    {type: 'player', x: 0, y: 0, id: 'right_walking_3'},
    {type: 'player', x: 0, y: 0, id: 'right_walking_4'},
    {type: 'player', x: 0, y: 0, id: 'right_walking_5'},
    {type: 'player', x: 0, y: 0, id: 'right_walking_6'},
    {type: 'player', x: 0, y: 0, id: 'right_walking_7'},
    {type: 'player', x: 0, y: 0, id: 'down'},
    {type: 'player', x: 0, y: 0, id: 'down_walking_1'},
    {type: 'player', x: 0, y: 0, id: 'down_walking_2'},
    {type: 'player', x: 0, y: 0, id: 'down_walking_3'},
    {type: 'player', x: 0, y: 0, id: 'down_walking_4'},
    {type: 'player', x: 0, y: 0, id: 'down_walking_5'},
    {type: 'player', x: 0, y: 0, id: 'down_walking_6'},
    {type: 'player', x: 0, y: 0, id: 'down_walking_7'},
    {type: 'player', x: 0, y: 0, id: 'left'},
    {type: 'player', x: 0, y: 0, id: 'left_walking_1'},
    {type: 'player', x: 0, y: 0, id: 'left_walking_2'},
    {type: 'player', x: 0, y: 0, id: 'left_walking_3'},
    {type: 'player', x: 0, y: 0, id: 'left_walking_4'},
    {type: 'player', x: 0, y: 0, id: 'left_walking_5'},
    {type: 'player', x: 0, y: 0, id: 'left_walking_6'},
    {type: 'player', x: 0, y: 0, id: 'left_walking_7'}
  ];
  const startPos = { x: {{position_x}}, y: {{position_y}} };
  assets.load(dataToLoad).then(() => setup());
</script>