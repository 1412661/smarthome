<?php

class MyDB extends SQLite3 {
	public function __construct($dbname) {
		$this->open($dbname);
	}

	public function install() {
	
	}
	
	public function setquery($query) {
		$this->result = $this->query($query);
		
		if (!$this->result) {
			die('<html><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/></head><body><div style="color: red;">Query bị lỗi: <b>'.$query.'</b></div>'.$this->lastErrorMsg().'</body></html>');
		} else {
			return $this->result;
		}
	}
	
	public function get_setting($setting) {
		$query = $this->query('SELECT "value" FROM "setting" WHERE "id_name" = "'.$setting.'"');
		$result = $query->fetchArray(SQLITE3_ASSOC);
		return $result['value'];
	}
	
	public function change_setting($setting,$val) {
		$this->query('UPDATE "setting" SET "value" = "'.$val.'" WHERE "id_name" = "'.$setting.'"');
	}
	
	public function begin_transaction() {
		$this->exec('BEGIN TRANSACTION;');
	}
	
	public function last_row($table) {
		$this->result = $this->query("SELECT * FROM '$table' WHERE id = (SELECT MAX(id) FROM '$table')");
		
		return $this->result;
	}
	
	public function rollback_transaction() {
		$this->exec('ROLLBACK;');
	}
	
	public function save_transaction() {
		$this->exec('END TRANSACTION;');
	}
	
	
	
	public function __destruct() {
		
	}
}


?>