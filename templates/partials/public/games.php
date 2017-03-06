<?php foreach ($values['games'] as $i => $game): ?>
  <div class="player-select-game<?php if ($i==0): ?> player-select-game-selected<?php endif ?>" data-id="<?php echo $game->get('id') ?>">
    <img src="/img/player-<?php echo ($i+1) ?>.png" />
    <?php echo $i ?>
  </div>
<?php endforeach ?>