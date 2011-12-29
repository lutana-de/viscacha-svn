<?php
/**
 * Base implementation for custom fields.
 *
 * @package		Cms
 * @author		Matthias Mohr
 * @since 		1.0
 */

abstract class CustomDataField {

	protected $id;
	protected $internal;
	protected $name;
	protected $description;
	protected $priority;
	protected $position;
	protected $implemented;

	protected $data;
	protected $params;

	public static function constructObject($data) {
		$obj = Core::constructObject($data['type']);
		$obj->injectData($data);
		return $obj;
	}

	public function injectData($data) {
		$params = $this->getParamNames();
		foreach ($data as $key => $value) {
			switch ($key) {
				case 'position':
					$this->position = Core::constructObject($value);
					break;
				case 'type':
					break;
				case 'params':
					$this->params = empty($data['params']) ? array() : unserialize($data['params']);
					break;
				default:
					if (in_array($key, $params)) {
						$this->params[$key] = $value;
					}
					else {
						$this->$key = $value;
					}
			}
		}
	}

	public function getId() {
		return $this->id;
	}
	public function getFieldName() {
		if (empty($this->internal)) {
			return 'field' . $this->id;
		}
		else {
			return $this->internal;
		}
	}
	public function getName() {
		return $this->name;
	}
	public function setName($name) {
		$this->name = $name;
	}
	public function getDescription() {
		return $this->description;
	}
	public function setDescription($description) {
		$this->description = $description;
	}
	public function getPriority() {
		return $this->priority;
	}
	public function setPriority($priority) {
		$this->priority = $priority;
	}
	public function getPosition() {
		return $this->position;
	}
	public function setPosition(CustomDataPosition $pos) {
		$this->position = $pos;
	}
	public function isImplemented() {
		return !empty($this->implemented);
	}

	public abstract function getTypeName();
	public abstract function getClassPath(); // Example: Cms.DataFields.CustomDataField

	public function getData() {
		return $this->data;
	}
	public function setData($data) {
		$this->data = $data;
	}
	public abstract function getDataType(); // Example: VAR_INT
	public abstract function getDbDataType(); // Example: INT(10)
	public abstract function getInputCode();
	public abstract function getOutputCode();
	public abstract function getValidation();

	public abstract function getParamNames($add = false);
	public function getParamsData($add = false) {
		if (!is_array($this->params)) {
			$this->params = array();
		}
		return array_merge(
			array_fill_keys($this->getParamNames(), null),
			$this->params
		);
	}
	public abstract function getParamsCode($add = false);
	public abstract function getValidationParams($add = false);

	protected function getCodeImpl($file) {
		$tpl = Core::_(TPL);
		$tpl->assign('field', $this->getFieldName());
		$tpl->assign('data', Sanitize::saveHTML($this->data));
		$tpl->assign('params', Sanitize::saveHTML($this->getParamsData()));
		return $tpl->parse($file);
	}

	public function create() {
		$db = Core::_(DB);
		try {
			$db->begin();
			// Einf�gen in Felder-Tabelle
			$insert = array(
				'name' => $this->name,
				'desc' => $this->description,
				'internal' => $this->getFieldName(),
				'type' => $this->getClassPath(),
				'pos' => $this->position->getClassPath(),
				'prio' => $this->priority,
				'params' => serialize($this->getParamsData())
			);
			$db->query("
				INSERT INTO <p>fields (internal, name, description, type, position, priority, params)
				VALUES (<internal>, <name>, <desc>, <type>, <pos>, <prio:int>, <params>)", $insert);
			// Save generated id to have it for the field name
			$this->id = $db->insertId();

			// Spalte erstellen in Daten-Tabelle
			$alter = array(
				'table' => $this->position->getDbTable(),
				'field' => $this->getFieldName(),
				'datatype' => $this->getDbDataType()
			);
			$db->query("ALTER TABLE <p><table:noquote> ADD <field:noquote> <datatype:noquote> NULL DEFAULT NULL", $alter);

			$db->commit();
			return true;
		} catch(QueryException $e) {
			$db->rollback();
			return false;
		}
	}

	public function update() {
		$db = Core::_(DB);
		// Aktualisierung in Daten-Tabelle wird nicht erlaubt
		// Aktualisiere in Felder-Tabelle
		$update = array(
			'name' => $this->name,
			'desc' => $this->description,
			'prio' => $this->priority,
			'params' => serialize($this->getParamsData()),
			'position' => $this->position->getClassPath(),
			'id' => $this->id
		);
		return $db->query("UPDATE <p>fields SET name = <name>, description = <desc>, priority = <prio:int>, params = <params>, position = <position> WHERE id = <id:int>", $update);
	}

	public function remove() {
		$db = Core::_(DB);
		try {
			$db->begin();
			// L�schen in Felder-Tabelle
			$db->query("DELETE FROM <p>fields WHERE id = <id:int>", array('id' => $this->id));

			// Spalte l�schen aus Daten-Tabelle
			$alter = array(
				'table' => $this->position->getDbTable(),
				'field' => $this->getFieldName()
			);
			$db->query("ALTER TABLE <p><table:noquote> DROP <field:noquote>", $alter); // Default value?

			$db->commit();
			return true;
		} catch(QueryException $e) {
			$db->rollback();
			return false;
		}
	}

}
?>