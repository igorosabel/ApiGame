<?php foreach ($values['list'] as $i => $sce): ?>
<?php
echo OTools::getPartial($values['route'], [ 'sce' => $sce ]);
if ($i<count($values['list'])-1) {
	echo ",\n";
}
?>
<?php endforeach ?>