<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
 * Author: Jason Benford
 * File: ./application/libraries/UI_Table.php
 * Description: This is a helpful little library for creating SemanticUI tables.  
 * 	With perfect indentation withing the form.
 */

class UI_Table {
	var $html;

	/*
	 * CONSTRUCTOR
	 * set up our ci instance and load in the required semantic files
	 */
	public function __construct() {
	}

	/*
	 * open up our table tags
	 */
	public function open($config = array()) {
		//get all of our config values as local variables
		foreach ($config as $key => $value) {
			${$key} = $value;
		}

		if (isset($indent_level)) {
			$this->indent_level = $indent_level;
		} else {
			$this->indent_level = 0;
		}

		//reset our html
		$this->html = "\n";
		$this->_indent();

		//open up our tag
		$this->html .= '<table class="';
		if (isset($class)) {
			$this->html .= $class;
		} else {
			$this->html .= 'ui table';
		}
		$this->html .= '"';

		if (isset($id)) { $this->html .= ' id="'.$id.'"'; } 		

		$this->html .= '>'."\n";

		//move our indent up a level and indent
		$this->indent_level++;
		$this->_indent();


		if (isset($headers)) {
			$this->html .= '<thead>'."\n";
			$this->indent_level++;
			$this->_indent();
			$this->html .= '<tr>'."\n";
			$this->indent_level++;
			foreach($headers as $header) {
				$this->_indent();
				$this->html .= '<th>'.$header.'</th>'."\n"; 
			}
			$this->indent_level--;
			$this->_indent();
			$this->html .= '</tr>'."\n";
			$this->indent_level--;
			$this->_indent();
			$this->html .= '</thead>'."\n";
		}
		$this->_indent();
		$this->html .= '<tbody>';
		$this->html .= "\n";
		$this->indent_level++;
	}

	/*
	 * open up a new row
	 */
	public function open_row() {
		$this->_indent();
		$this->html .= '<tr>'."\n";
		$this->indent_level++;
	}

	/*
	 * close a row
	 */
	public function close_row() {
		$this->indent_level--;
		$this->_indent();
		$this->html .= '</tr>'."\n";
	}

	/*
	 * add in a column
	 */
	public function add_column($content) {
		$this->_indent();
		$this->html .= '<td>'."\n";
		$this->indent_level++;
		$this->_indent();
		$this->html .= $content."\n";
		$this->indent_level--;
		$this->_indent();
		$this->html .= '</td>'."\n";
	}

	/*
	 * close the table
	 */
	public function close() {
		$this->indent_level--;
		$this->_indent();
		$this->html .= '</tbody>'."\n";
		$this->indent_level--;
		$this->_indent();
		$this->html .= '</table>'."\n";
	}

	/*
	 * utility function for our perfect indentation
	 */
	private function _indent() {
		for ($i = 0; $i < $this->indent_level; $i++) {
			$this->html .= "\t";
		}
	}

	/*
	 * echo the table
	 */
	public function render () {
		echo $this->html;
	}
}

// End of UI_Table class
/* End of file UI_Table.php */
/* Location: ./application/libraries/UI_Table.php */
