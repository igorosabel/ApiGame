{{backgrounds_css}}
{{sprites_css}}
<header>
  <img src="/img/triforce.png" />
  The Legend Of Zelda
</header>

<div class="game">
  <div id="board" class="board"></div>
</div>

<script>
  const scenario    = JSON.parse('{{scn_data}}');
  const position_x  = {{position_x}};
  const position_y  = {{position_y}};
  const player_name = '{{player_name}}';
  const backgrounds = JSON.parse('{{bcks_data}}');
  const sprites     = JSON.parse('{{sprs_data}}');
</script>
<script src="/js/player.js"></script>
<script src="/js/game.js"></script>