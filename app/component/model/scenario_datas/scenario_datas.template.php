<?php foreach ($values['list'] as $i => $scenario_data): ?>
	{
		"id": <?php echo $scenario_data->get('id') ?>,
		"idScenario": <?php echo $scenario_data->get('id_scenario') ?>,
		"x": <?php echo $scenario_data->get('x') ?>,
		"y": <?php echo $scenario_data->get('y') ?>,
		"idBackground": <?php echo (!is_null($scenario_data->get('id_background'))) ? $scenario_data->get('id_background') : 'null' ?>,
		"backgroundName": <?php echo (!is_null($scenario_data->getBackground())) ? '"'.urlencode($scenario_data->getBackground()->get('name')).'"' : 'null' ?>,
		"backgroundAssetUrl": <?php echo (!is_null($scenario_data->getBackground())) ? '"'.urlencode($scenario_data->getBackground()->getAsset()->getUrl()).'"' : 'null' ?>,
		"idScenarioObject": <?php echo (!is_null($scenario_data->get('id_scenario_object'))) ? $scenario_data->get('id_scenario_object') : 'null' ?>,
		"scenarioObjectName": <?php echo (!is_null($scenario_data->getScenarioObject())) ? '"'.urlencode($scenario_data->getScenarioObject()->get('name')).'"' : 'null' ?>,
		"scenarioObjectAssetUrl": <?php echo (!is_null($scenario_data->getScenarioObject())) ? '"'.urlencode($scenario_data->getScenarioObject()->getAsset()->getUrl()).'"' : 'null' ?>,
		"scenarioObjectWidth": <?php echo (!is_null($scenario_data->getScenarioObject())) ? $scenario_data->getScenarioObject()->get('width') : 'null' ?>,
		"scenarioObjectHeight": <?php echo (!is_null($scenario_data->getScenarioObject())) ? $scenario_data->getScenarioObject()->get('height') : 'null' ?>,
		"scenarioObjectBlockWidth": <?php echo (!is_null($scenario_data->getScenarioObject())) ? $scenario_data->getScenarioObject()->get('block_width') : 'null' ?>,
		"scenarioObjectBlockHeight": <?php echo (!is_null($scenario_data->getScenarioObject())) ? $scenario_data->getScenarioObject()->get('block_height') : 'null' ?>,
		"idCharacter": <?php echo (!is_null($scenario_data->get('id_character'))) ? $scenario_data->get('id_character') : 'null' ?>,
		"characterName": <?php echo (!is_null($scenario_data->getCharacter())) ? '"'.urlencode($scenario_data->getCharacter()->get('name')).'"' : 'null' ?>,
		"characterAssetUrl": <?php echo (!is_null($scenario_data->getCharacter())) ? '"'.urlencode($scenario_data->getCharacter()->getAsset('down')->getUrl()).'"' : 'null' ?>,
		"characterWidth": <?php echo (!is_null($scenario_data->getCharacter())) ? $scenario_data->getCharacter()->get('width') : 'null' ?>,
		"characterHeight": <?php echo (!is_null($scenario_data->getCharacter())) ? $scenario_data->getCharacter()->get('height') : 'null' ?>,
		"characterBlockWidth": <?php echo (!is_null($scenario_data->getCharacter())) ? $scenario_data->getCharacter()->get('block_width') : 'null' ?>,
		"characterBlockHeight": <?php echo (!is_null($scenario_data->getCharacter())) ? $scenario_data->getCharacter()->get('block_height') : 'null' ?>,
		"characterHealth": <?php echo (!is_null($scenario_data->get('character_health'))) ? $scenario_data->get('character_health') : 'null' ?>
	}<?php if ($i<count($values['list'])-1): ?>,<?php endif ?>
<?php endforeach ?>