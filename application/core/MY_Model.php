<?php
	class MY_Model extends CI_Model {
		protected $columns;
		protected $table='users';

		public function __construct() {
			parent::__construct();

			//set up columns array
			$col_objs = $this->db->query("DESCRIBE $this->table")->result();
			foreach ($col_objs as $col_obj) {
				$this->columns[] = $col_obj->Field;
			}
		}

		//---------------------------------------------------------------------------
		/*
		 * CREATE
		 */
		public function insert($record) {
			$this->db->insert($this->table, $record);
		}

		//---------------------------------------------------------------------------
		/*
		 * READ
		 */
		protected function _get_by_id($id, $cols='') {
			if ($cols !== '')
				$this->db->select($cols);
			$query = $this->db->where('id', $id)->get($this->table);
			if ($query->num_rows === 1) {
				return $query->result()[0];
			}
		}

		protected function _get_all($cols='') {
			if ($cols !== '')
				$this->db->select($cols);
			$query = $this->db->get($this->table);
			return $query->result();
		}

		protected function _get_all_active($cols='') {
			if ($cols !== '')
				$this->db->select($cols);
			$query = $this->db->where('active', 1)->get($this->table);
			return $query->result();
		}

		public function get_columns() {
			return $this->columns;
		}

		//---------------------------------------------------------------------------
		/*
		 * UPDATE
		 */
		public function update($id, $record) {
			$this->db->where('id', $id);
			$this->db->update($this->table, $record);
		}

		//---------------------------------------------------------------------------
		/*
		 * DELETE (SOFT)
		 */

		public function del($id) {
			if (!$this->db->where('id', $id)->update($this->table, array('active' => 0))) {
				exit("Soft delete failed at DB for $table id $id");
			}
		}
	}
?>
