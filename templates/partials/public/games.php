<?php foreach ($values['games'] as $i => $game): ?>
  <div class="player-select-game<?php if ($i==0): ?> player-select-game-selected<?php endif ?>" id="player-select-game-<?php echo ($i+1) ?>" data-id="<?php echo $game->get('id') ?>">
    <img src="/img/player-<?php echo ($i+1) ?>.png" />
    <div class="player-select-name"><?php echo $game->get('name') ?></div>
  </div>
<?php endforeach ?>