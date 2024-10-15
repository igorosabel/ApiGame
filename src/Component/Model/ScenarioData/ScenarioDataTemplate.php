<?php if (is_null($scenariodata)): ?>
null
<?php else: ?>
{
	"id": <?php echo $scenariodata->get('id') ?>,
	"idScenario": <?php echo $scenariodata->get('id_scenario') ?>,
	"x": <?php echo $scenariodata->get('x') ?>,
	"y": <?php echo $scenariodata->get('y') ?>,
	"idBackground": <?php echo $scenariodata->get('id_background') ?>,
	"backgroundName": <?php echo (!is_null($scenariodata->getBackground())) ? '"'.urlencode($scenariodata->getBackground()->get('name')).'"' : 'null' ?>,
	"backgroundAssetUrl": <?php echo (!is_null($scenariodata->getBackground())) ? '"'.urlencode($scenariodata->getBackground()->getAsset()->getUrl()).'"' : 'null' ?>,
	"idScenarioObject": <?php echo is_null($scenariodata->get('id_scenario_object')) ? 'null' : $scenariodata->get('id_scenario_object') ?>,
	"scenarioObjectName": <?php echo (!is_null($scenariodata->getScenarioObject())) ? '"'.urlencode($scenariodata->getScenarioObject()->get('name')).'"' : 'null' ?>,
	"scenarioObjectAssetUrl": <?php echo (!is_null($scenariodata->getScenarioObject())) ? '"'.urlencode($scenariodata->getScenarioObject()->getAsset()->getUrl()).'"' : 'null' ?>,
	"scenarioObjectWidth": <?php echo (!is_null($scenariodata->getScenarioObject())) ? $scenariodata->getScenarioObject()->get('width') : 'null' ?>,
	"scenarioObjectHeight": <?php echo (!is_null($scenariodata->getScenarioObject())) ? $scenariodata->getScenarioObject()->get('height') : 'null' ?>,
	"scenarioObjectBlockWidth": <?php echo (!is_null($scenariodata->getScenarioObject())) ? $scenariodata->getScenarioObject()->get('block_width') : 'null' ?>,
	"scenarioObjectBlockHeight": <?php echo (!is_null($scenariodata->getScenarioObject())) ? $scenariodata->getScenarioObject()->get('block_height') : 'null' ?>,
	"idCharacter": <?php echo is_null($scenariodata->get('id_character')) ? 'null' : $scenariodata->get('id_character') ?>,
	"characterName": <?php echo (!is_null($scenariodata->getCharacter())) ? '"'.urlencode($scenariodata->getCharacter()->get('name')).'"' : 'null' ?>,
	"characterAssetUrl": <?php echo (!is_null($scenariodata->getCharacter())) ? '"'.urlencode($scenariodata->getCharacter()->getAsset('down')->getUrl()).'"' : 'null' ?>,
	"characterWidth": <?php echo (!is_null($scenariodata->getCharacter())) ? $scenariodata->getCharacter()->get('width') : 'null' ?>,
	"characterHeight": <?php echo (!is_null($scenariodata->getCharacter())) ? $scenariodata->getCharacter()->get('height') : 'null' ?>,
	"characterBlockWidth": <?php echo (!is_null($scenariodata->getCharacter())) ? $scenariodata->getCharacter()->get('block_width') : 'null' ?>,
	"characterBlockHeight": <?php echo (!is_null($scenariodata->getCharacter())) ? $scenariodata->getCharacter()->get('block_height') : 'null' ?>,
	"characterHealth": <?php echo is_null($scenariodata->get('character_health')) ? 'null' : $scenariodata->get('character_health') ?>
}
<?php endif ?>
