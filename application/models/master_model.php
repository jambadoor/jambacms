<?php
	class Master_Model extends CI_Model {
		/*
		 * DATA MEMBERS
		 */
		private $tables;
		private $cols_by_table;
		private $user;
		
		//---------------------------------------------------------------------------
		/*
		 * CONSTRUCTOR
		 * -----------
		 *
		 */
		public function __construct() {
			parent::__construct();

			$table_objs = $this->db->query("SHOW TABLES")->result();

			$tables = array();

			$cols_by_table = array();

			foreach ($table_objs as $table_obj) {
				$table_name = $table_obj->{"Tables_in_".$this->db->database};
				$tables[] = $table_name;

				$cols_by_table[$table_name] = array();

				$col_objs = $this->db->query("DESCRIBE $table_name")->result();
				foreach ($col_objs as $col_obj) {
					$col_name = $col_obj->Field;
					$cols_by_table[$table_name][] = $col_name;
				}
			}

			$this->tables = $tables;
			$this->cols_by_table = $cols_by_table;
		}

		//get tables variable
		//public function get_tables() {
//			return $this->tables;
//		}

		//---------------------------------------------------------------------------
		/*
		 * CREATE
		 */
		public function insert($table, $record) {
			//prevent any errors from hitting the db
			//is table in tables?
			if (!in_array($table, $this->tables)) {
				exit("Crap.  $table not in database.");
			} else {
				//ok, table is there, are all the cols?
				$all_there = true;
				foreach ($record as $col_name=>$value) { 
					if (!in_array($col_name, $this->cols_by_table[$table])) {
						$all_there = false;
						exit("$col_name not in $table<br>");
					}
				}
				if (!$all_there) {
					exit("Some table didn't exist. But this should never get hit.");
				} else {
					//ok, all the cols exist
					$sql = "INSERT INTO $table (";

					foreach($record as $col_name=>$value)
						$sql .= "$col_name, ";
					//get rid of last ", "
					$sql = substr($sql, 0, -2);

					$sql .= ") VALUES (";

					foreach($record as $col_name=>$value)
						$sql .= "'$value', ";
					//get rid of last ", "
					$sql = substr($sql, 0, -2);
					$sql .= ")";

					if (!$this->db->query($sql))
						exit("Insert failed");
				}
			}
		}


		//---------------------------------------------------------------------------
		/*
		 * READ
		 */
		public function get($table, $id, $cols='') {
			//check that table exists
			if (!in_array($table, $this->tables)) {
				exit("$table not in database.");
			} else {
				$sql = "SELECT ";
				if (is_array($cols)) {
					foreach ($cols as $col) {
						$sql .= "$col, ";
					}
					//get rid of last ", "
					$sql = substr($sql, 0, -2);
				} else {
					$sql .= "* ";
				}
				$sql .= " FROM $table WHERE id=$id";

				$query = $this->db->query($sql);
				if ($query->num_rows == 1) {
					return $query->result()[0];
				} else {
					exit("Database Error");
				}
			}
		}

		public function get_all($table) {
			//check that table exists
			if (!in_array($table, $this->tables)) {
				exit("$table not in database.");
			} else { 
				$query = $this->db->query("SELECT * FROM $table");
				return $query->result();
			}
		}

		public function get_cols_from_table($table) {
			//check that table exists
			if (!in_array($table, $this->tables)) {
				exit("$table not in database.");
			} else {
				return $this->cols_by_table[$table];
			}
		}

		public function get_tables() {
			return $this->tables;
		}

		//---------------------------------------------------------------------------
		/*
		 * UPDATE
		 */

		public function update($table, $id, $data) {
			$sql = "UPDATE $table SET ";
			foreach ($data as $key=>$value) {
				$sql .= "$key='$value', ";	
			}
			//get rid of last ", "
			$sql = substr($sql, 0, -2);
			$sql .= " WHERE id=$id";

			if (!$this->db->query($sql)) {
				exit("Database Error - Update $table id $id");
			}
		}

		//---------------------------------------------------------------------------
		/*
		 * DELETE
		 */

		public function del($table, $id) {
			if (!$this->db->query("DELETE FROM $table WHERE id=$id")) {
				exit("Delete failed at DB for $table id $id");
			}
		}
	}
?>
