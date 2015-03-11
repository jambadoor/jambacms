<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class UI_Table {
	var $CI;
	var $html;

	/*
	 * CONSTRUCTOR
	 * set up our ci instance and load in the required semantic files
	 */
	public function __construct() {
		$CI =& get_instance();
		$this->CI =& $CI;
		if (!in_array('semantic-ui/table.css', $CI->view_data['css_plugins'])) $CI->view_data['css_plugins'][] = 'semantic-ui/table.css';
	}

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
		$this->indent();

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
		$this->indent();


		if (isset($headers)) {
			$this->html .= '<thead>'."\n";
			$this->indent_level++;
			$this->indent();
			$this->html .= '<tr>'."\n";
			$this->indent_level++;
			foreach($headers as $header) {
				$this->indent();
				$this->html .= '<th>'.$header.'</th>'."\n"; 
			}
			$this->indent_level--;
			$this->indent();
			$this->html .= '</tr>'."\n";
			$this->indent_level--;
			$this->indent();
			$this->html .= '</thead>'."\n";
		}
		$this->indent();
		$this->html .= '<tbody>';
		$this->html .= "\n";
		$this->indent_level++;
	}

	public function open_row() {
		$this->indent();
		$this->html .= '<tr>'."\n";
		$this->indent_level++;
	}

	public function close_row() {
		$this->indent_level--;
		$this->indent();
		$this->html .= '</tr>'."\n";
	}

	public function add_column($content) {
		$this->indent();
		$this->html .= '<td>'."\n";
		$this->indent_level++;
		$this->indent();
		$this->html .= $content."\n";
		$this->indent_level--;
		$this->indent();
		$this->html .= '</td>'."\n";
	}

	public function close() {
		$this->indent_level--;
		$this->indent();
		$this->html .= '</tbody>'."\n";
		$this->indent_level--;
		$this->indent();
		$this->html .= '</table>'."\n";
	}

	private function indent() {
		for ($i = 0; $i < $this->indent_level; $i++) {
			$this->html .= "\t";
		}
	}

	public function render () {
		echo $this->html;
	}
}
?>

