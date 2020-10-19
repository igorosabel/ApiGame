<?php foreach ($values['list'] as $i => $scenario_data): ?>
	{
		"id": <?php echo $scenario_data->get('id') ?>,
		"x": <?php echo $scenario_data->get('x') ?>,
		"y": <?php echo $scenario_data->get('y') ?>,
		"idBackground": <?php echo (!is_null($scenario_data->get('id_background'))) ? $scenario_data->get('id_background') : 'null' ?>,
		"backgroundName": <?php echo (!is_null($scenario_data->getBackground())) ? urlencode($scenario_data->getBackground()->get('name')) : 'null' ?>,
		"backgroundAssetUrl": <?php echo (!is_null($scenario_data->getBackground())) ? urlencode($scenario_data->getBackground()->getAsset()->getUrl()) : 'null' ?>,
		"idScenarioObject": <?php echo (!is_null($scenario_data->get('id_scenario_object'))) ? $scenario_data->get('id_scenario_object') : 'null' ?>,
		"scenarioObjectName": <?php echo (!is_null($scenario_data->getScenarioObject())) ? urlencode($scenario_data->getScenarioObject()->get('name')) : 'null' ?>,
		"scenarioObjectAssetUrl": <?php echo (!is_null($scenario_data->getScenarioObject())) ? urlencode($scenario_data->getScenarioObject()->getAsset()->getUrl()) : 'null' ?>,
		"idCharacter": <?php echo (!is_null($scenario_data->get('id_character'))) ? $scenario_data->get('id_character') : 'null' ?>,
		"characterName": <?php echo (!is_null($scenario_data->getCharacter())) ? urlencode($scenario_data->getCharacter()->get('name')) : 'null' ?>,
		"characterAssetUrl": <?php echo (!is_null($scenario_data->getCharacter())) ? urlencode($scenario_data->getCharacter()->getAsset('down')[0]->getUrl()) : 'null' ?>
	}<?php if ($i<count($values['list'])-1): ?>,<?php endif ?>
<?php endforeach ?>