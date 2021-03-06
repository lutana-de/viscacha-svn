<?php
/**
 * Base class for custom data field data storage and view positions.
 *
 * @package		Cms
 * @subpackage	DataFields
 * @author		Matthias Mohr
 * @since 		1.0
 */

class CustomData {

	private $position;
	private $data;
	private $template;
	private $pk;

	public function __construct(CustomDataPosition $position) {
		$this->template = null;
		$this->position = $position;
		$this->pk = 0;
		$this->data = array();
	}

	public function getOutputTemplate() {
		if (empty($this->template)) {
			return '/Cms/bits/positions/output';
		}
		return $this->template;
	}

	public function setOutputTemplate($path = null) {
		$this->template = $path;
	}

	public function setCalculated(array &$data, $fields) {
		$field = new UnknownDataField();
		foreach ($fields as $name) {
			$value = null;
			if (isset($data[$name])) {
				$value = $data[$name];
			}
			$this->data[$name] = new CustomFieldData($field, $value);
		}
	}
	
	public function set(array &$data, $fromDb = true, array $fields = array()) {
		if (empty($fields)) {
			$fields = $this->position->getFields();
		}
		foreach ($fields as $name => $field) {
			$value = null;
			if (isset($data[$name])) {
				$value = $data[$name];
			}
			if ($fromDb) {
				$value = $field->formatDataFromDb($value);
			}
			$this->data[$name] = new CustomFieldData($field, $value);
		}
		if (isset($data[$this->position->getPrimaryKey()])) {
			$this->pk = $data[$this->position->getPrimaryKey()];
		}
	}

	public function setToDefault() {
		foreach ($this->position->getFields() as $name => $field) {
			$this->data[$name] = new CustomFieldData($field, $field->getDefaultData());
		}
	}

	public function load($pkValue) {
		$filter = new CustomDataFilter($this->position);
		$filter->condition($this->position->getPrimaryKey(), $pkValue);
		$filter->limit(1);
		return $filter->retrieveTo($this);
	}

	public function remove($pkValue = null) {
		if ($pkValue === null) {
			$pkValue = $this->pk;
		}
		$data = array(
			'id' => $pkValue,
			'table' => $this->position->getDbTable(),
			'pk' => $this->position->getPrimaryKey()
		);
		foreach ($this->data as $field) {
			if ($field instanceof CustomExternalDataField) {
				$field->deleteData();
			}
		}
		return Database::getObject()->query("DELETE FROM <p><table:noquote> WHERE <pk:noquote> = <id:int>", $data);
	}

	public function edit($pkValue = null) {
		if ($pkValue === null) {
			$pkValue = $this->pk;
		}
		$sql = array();
		$data = array(
			'id' => $pkValue,
			'table' => $this->position->getDbTable(),
			'pk' => $this->position->getPrimaryKey()
		);
		foreach ($this->data as $field) {
			if ($field->getDbDataType() != null) {
				$name = $field->getFieldName();
				$sql[] = "{$name} = <{$name}>";
				if ($field instanceof CustomExternalDataField) {
					if ($pkValue > 0)
						$field->updateData();
					else
						$field->insertData();
				}
				$data[$name] = $field->formatDataForDb();
			}
		}
		$sql = implode(', ', $sql);
		$db = Database::getObject();
		if ($pkValue > 0) {
			return $db->query("UPDATE <p><table:noquote> SET {$sql} WHERE <pk:noquote> = <id:int>", $data);
		}
		else {
			return $db->query("INSERT INTO <p><table:noquote> SET {$sql}", $data);
		}
	}

	public function add() {
		if ($this->edit(0)) {
			$id = Database::getObject()->insertId();
			return iif($id > 0, $id, 0);
		}
		else {
			return 0;
		}
	}

	public function getId() {
		return $this->pk;
	}

	public function getData($internal, $key = null) {
		return $this->data[$internal]->getData($key);
	}

	public function getField($internal) {
		if (isset($this->data[$internal])) {
			return $this->data[$internal];
		}
		return null;
	}

	public function getFields($internal = null) {
		if (is_array($internal)) {
			return array_intersect_key($this->data, array_fill_keys($internal, null));
		}
		return $this->data;
	}

	public function getFieldsExcept($internal) {
		if (is_array($internal)) {
			return array_diff_key($this->data, array_fill_keys($internal, null));
		}
		return $this->data;
	}

	public function outputField($internal, $label = true) {
		return $this->output($this->getField($internal), $label);
	}

	public function outputFields($internal = null, $label = true) {
		return $this->outputMultiple($this->getFields($internal), $label);
	}

	public function outputFieldsExcept($internal, $label = true) {
		return $this->outputMultiple($this->getFieldsExcept($internal), $label);
	}
	
	protected function outputMultiple(array $fields, $label) {
		$html = '';
		foreach ($fields as $field) {
			$html .= $this->output($field, $label) . NL;
		}
		return $html;
	}

	protected function output(CustomFieldData $field, $label) {
		if ($field == null) {
			return '';
		}
		else {
			$tpl = Response::getObject()->getTemplate($this->getOutputTemplate());
			$tpl->assign('field', $field, false);
			$tpl->assign('output', $field->getOutputCode(), false);
			$tpl->assign('label', $label, false);
			return $tpl->parse();
		}
	}

}
?>