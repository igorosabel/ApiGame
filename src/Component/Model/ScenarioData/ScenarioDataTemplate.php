<?php if (is_null($values['ScenarioData'])): ?>
null
<?php else: ?>
{
	"id": <?php echo $values['ScenarioData']->get('id') ?>,
	"idScenario": <?php echo $values['ScenarioData']->get('id_scenario') ?>,
	"x": <?php echo $values['ScenarioData']->get('x') ?>,
	"y": <?php echo $values['ScenarioData']->get('y') ?>,
	"idBackground": <?php echo $values['ScenarioData']->get('id_background') ?>,
	"backgroundName": <?php echo (!is_null($values['ScenarioData']->getBackground())) ? '"'.urlencode($values['ScenarioData']->getBackground()->get('name')).'"' : 'null' ?>,
	"backgroundAssetUrl": <?php echo (!is_null($values['ScenarioData']->getBackground())) ? '"'.urlencode($values['ScenarioData']->getBackground()->getAsset()->getUrl()).'"' : 'null' ?>,
	"idScenarioObject": <?php echo is_null($values['ScenarioData']->get('id_scenario_object')) ? 'null' : $values['ScenarioData']->get('id_scenario_object') ?>,
	"scenarioObjectName": <?php echo (!is_null($values['ScenarioData']->getScenarioObject())) ? '"'.urlencode($values['ScenarioData']->getScenarioObject()->get('name')).'"' : 'null' ?>,
	"scenarioObjectAssetUrl": <?php echo (!is_null($values['ScenarioData']->getScenarioObject())) ? '"'.urlencode($values['ScenarioData']->getScenarioObject()->getAsset()->getUrl()).'"' : 'null' ?>,
	"scenarioObjectWidth": <?php echo (!is_null($values['ScenarioData']->getScenarioObject())) ? $values['ScenarioData']->getScenarioObject()->get('width') : 'null' ?>,
	"scenarioObjectHeight": <?php echo (!is_null($values['ScenarioData']->getScenarioObject())) ? $values['ScenarioData']->getScenarioObject()->get('height') : 'null' ?>,
	"scenarioObjectBlockWidth": <?php echo (!is_null($values['ScenarioData']->getScenarioObject())) ? $values['ScenarioData']->getScenarioObject()->get('block_width') : 'null' ?>,
	"scenarioObjectBlockHeight": <?php echo (!is_null($values['ScenarioData']->getScenarioObject())) ? $values['ScenarioData']->getScenarioObject()->get('block_height') : 'null' ?>,
	"idCharacter": <?php echo is_null($values['ScenarioData']->get('id_character')) ? 'null' : $values['ScenarioData']->get('id_character') ?>,
	"characterName": <?php echo (!is_null($values['ScenarioData']->getCharacter())) ? '"'.urlencode($values['ScenarioData']->getCharacter()->get('name')).'"' : 'null' ?>,
	"characterAssetUrl": <?php echo (!is_null($values['ScenarioData']->getCharacter())) ? '"'.urlencode($values['ScenarioData']->getCharacter()->getAsset('down')->getUrl()).'"' : 'null' ?>,
	"characterWidth": <?php echo (!is_null($values['ScenarioData']->getCharacter())) ? $values['ScenarioData']->getCharacter()->get('width') : 'null' ?>,
	"characterHeight": <?php echo (!is_null($values['ScenarioData']->getCharacter())) ? $values['ScenarioData']->getCharacter()->get('height') : 'null' ?>,
	"characterBlockWidth": <?php echo (!is_null($values['ScenarioData']->getCharacter())) ? $values['ScenarioData']->getCharacter()->get('block_width') : 'null' ?>,
	"characterBlockHeight": <?php echo (!is_null($values['ScenarioData']->getCharacter())) ? $values['ScenarioData']->getCharacter()->get('block_height') : 'null' ?>,
	"characterHealth": <?php echo is_null($values['ScenarioData']->get('character_health')) ? 'null' : $values['ScenarioData']->get('character_health') ?>
}
<?php endif ?>
