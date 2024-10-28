<?php if (is_null($scenariodata)): ?>
null
<?php else: ?>
{
	"id": <?php echo $scenariodata->id ?>,
	"idScenario": <?php echo $scenariodata->id_scenario ?>,
	"x": <?php echo $scenariodata->x ?>,
	"y": <?php echo $scenariodata->y ?>,
	"idBackground": <?php echo $scenariodata->id_background ?>,
	"backgroundName": <?php echo (!is_null($scenariodata->getBackground())) ? '"'.urlencode($scenariodata->getBackground()->name).'"' : 'null' ?>,
	"backgroundAssetUrl": <?php echo (!is_null($scenariodata->getBackground())) ? '"'.urlencode($scenariodata->getBackground()->getAsset()->getUrl()).'"' : 'null' ?>,
	"idScenarioObject": <?php echo is_null($scenariodata->id_scenario_object) ? 'null' : $scenariodata->id_scenario_object ?>,
	"scenarioObjectName": <?php echo (!is_null($scenariodata->getScenarioObject())) ? '"'.urlencode($scenariodata->getScenarioObject()->name).'"' : 'null' ?>,
	"scenarioObjectAssetUrl": <?php echo (!is_null($scenariodata->getScenarioObject())) ? '"'.urlencode($scenariodata->getScenarioObject()->getAsset()->getUrl()).'"' : 'null' ?>,
	"scenarioObjectWidth": <?php echo (!is_null($scenariodata->getScenarioObject())) ? $scenariodata->getScenarioObject()->width : 'null' ?>,
	"scenarioObjectHeight": <?php echo (!is_null($scenariodata->getScenarioObject())) ? $scenariodata->getScenarioObject()->height : 'null' ?>,
	"scenarioObjectBlockWidth": <?php echo (!is_null($scenariodata->getScenarioObject())) ? $scenariodata->getScenarioObject()->block_width : 'null' ?>,
	"scenarioObjectBlockHeight": <?php echo (!is_null($scenariodata->getScenarioObject())) ? $scenariodata->getScenarioObject()->block_height : 'null' ?>,
	"idCharacter": <?php echo is_null($scenariodata->id_character) ? 'null' : $scenariodata->id_character ?>,
	"characterName": <?php echo (!is_null($scenariodata->getCharacter())) ? '"'.urlencode($scenariodata->getCharacter()->name).'"' : 'null' ?>,
	"characterAssetUrl": <?php echo (!is_null($scenariodata->getCharacter())) ? '"'.urlencode($scenariodata->getCharacter()->getAsset('down')->getUrl()).'"' : 'null' ?>,
	"characterWidth": <?php echo (!is_null($scenariodata->getCharacter())) ? $scenariodata->getCharacter()->width : 'null' ?>,
	"characterHeight": <?php echo (!is_null($scenariodata->getCharacter())) ? $scenariodata->getCharacter()->height : 'null' ?>,
	"characterBlockWidth": <?php echo (!is_null($scenariodata->getCharacter())) ? $scenariodata->getCharacter()->block_width : 'null' ?>,
	"characterBlockHeight": <?php echo (!is_null($scenariodata->getCharacter())) ? $scenariodata->getCharacter()->block_height : 'null' ?>,
	"characterHealth": <?php echo is_null($scenariodata->character_health) ? 'null' : $scenariodata->character_health ?>
}
<?php endif ?>
