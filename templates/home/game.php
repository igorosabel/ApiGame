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
  let   position_x  = {{position_x}};
  let   position_y  = {{position_y}};
  const backgrounds = JSON.parse('{{bcks_data}}');
  const sprites     = JSON.parse('{{sprs_data}}');
</script>
<script src="/js/player.js"></script>
<script src="/js/game.js"></script>