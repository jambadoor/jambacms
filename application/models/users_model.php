<?php
	class Users_Model extends CI_Model {
		private $columns = array();
		private $table = 'users';

		public function __construct() {
			parent::__construct();

			//set up columns
			$col_objs = $this->db->query("DESCRIBE $table")->result();
			foreach ($col_objs as $col_obj) {
				$this->columns[] = $col_obj->Field;
			}
		}

		//---------------------------------------------------------------------------
		/*
		 * CREATE
		 */
		public function insert($record) {
			//check the record for possible errors
			$all_there = true;
			foreach ($record as $col_name=>$value) { 
				if (!in_array($col_name, $this->columns)) {
					$all_there = false;
					exit("$col_name not in $table<br>");
				}
			}
			if (!$all_there) {
				exit("Some table didn't exist. But this should never get hit.");
			} else {
				//ok, all the cols exist
				$sql = "INSERT INTO $this->table (";

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


		//---------------------------------------------------------------------------
		/*
		 * READ
		 */
		public function get($id, $cols='') {
			//check that table exists
			if (!in_array($table, $this->tables)) {
				exit("$table not in database.");
			} else {
				$sql = "SELECT ";
				if (is_array($cols)) {
					$all_there = true;
					foreach ($cols as $col) {
						if (!in_array($col, $this->columns)) {
							$all_there = false;
							exit("$col not in $table");
						}
						$sql .= "$col, ";
					}
					//get rid of last ", "
					$sql = substr($sql, 0, -2);
				} else {
					$sql .= "* ";
				}
				$sql .= " FROM $table WHERE id=$id";

				if (!$all_there) {
					exit("Some table didn't exist.");
				} else {
					$query = $this->db->query($sql);
					if ($query->num_rows === 1) {
						return $query->result()[0];
					} else {
						exit("Database Error");
					}
				}
			}
		}

		public function get_all() {
			$query = $this->db->query("SELECT * FROM $table");
		}

		public function get_columns($table) {
			//check that table exists
			if (!in_array($table, $this->tables)) {
				exit("$table not in database.");
			} else {
				return $this->columns;
			}
		}

		//---------------------------------------------------------------------------
		/*
		 * UPDATE
		 */
		public function update($id, $record) {
			//check that all fields in $record exist
			$all_there = true;
			foreach ($record as $col_name=>$value) { 
				if (!in_array($col_name, $this->columns)) {
					$all_there = false;
					exit("$col_name not in $table<br>");
				}
			}

			if (!$all_there) {
				exit("Some table(s) didn't exist. But this should never get hit.");
			} else {
				//ok, start the query
				$sql = "UPDATE $table SET ";
				foreach ($record as $key=>$value) {
					$sql .= "$key='$value', ";	
				}
				//get rid of last ", "
				$sql = substr($sql, 0, -2);
				$sql .= " WHERE id=$id";

				if (!$this->db->query($sql)) {
					exit("Database Error - Update $table id $id");
				}
			}
		}

		//---------------------------------------------------------------------------
		/*
		 * DELETE
		 */

		public function del($id) {
			if (!$this->db->query("DELETE FROM $table WHERE id=$id")) {
				exit("Delete failed at DB for $table id $id");
			}
		}
	}
