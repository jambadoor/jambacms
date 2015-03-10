<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class UI_Form {
	var $CI;
	var $html;

	/*
	 * CONSTRUCTOR
	 * set up our ci instance and load in the required semantic files
	 */
	public function __construct() {
		$CI =& get_instance();
		$this->CI =& $CI;
		if (!in_array('semantic-ui/form.css', $CI->view_data['css_plugins'])) $CI->view_data['css_plugins'][] = 'semantic-ui/form.css';
		if (!in_array('semantic-ui/form.js', $CI->view_data['js_plugins'])) $CI->view_data['js_plugins'][] = 'semantic-ui/form.js';
	}

	/*
	 * starts the form, takes a config array to get it started
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
		$this->indent();

		//open up our tag
		$this->html .= '<form class="';
		if (isset($class)) {
			$this->html .= $class;
		} else {
			$this->html .= 'ui form';
		}
		$this->html .= '"';

		if (isset($id)) { $this->html .= ' id="'.$id.'"'; } 		

		if (isset($action)) { $this->html .= ' action="'.$action.'"'; }

		$this->html .= ' method="POST"';
		$this->html .= '>'."\n";

		//move our indent up a level and indent
		$this->indent_level++;
		$this->indent();

		if (isset($header)) {
			$this->html .= '<h3>'.$header.'</h3>';
		}
		$this->html .= "\n";
	}

	public function close() {
		$this->indent_level--;
		$this->indent();
		$this->html .= "</form>\n";
	}

	public function render() {
		echo $this->html;
	}

	public function open_group($num_fields = 0) {
		$this->html .= '<div class="';

		switch ($num_fields) {
			case 1: $this->html .= 'one '; break;
			case 2: $this->html .= 'two '; break;
			case 3: $this->html .= 'three '; break;
			case 4: $this->html .= 'four '; break;
			case 5: $this->html .= 'five '; break;
			case 6: $this->html .= 'six '; break;
			case 7: $this->html .= 'seven '; break;
			case 8: $this->html .= 'eight '; break;
			case 9: $this->html .= 'nine '; break;
			case 10: $this->html .= 'ten '; break;
			case 11: $this->html .= 'eleven '; break;
			case 12: $this->html .= 'twelve '; break;
			case 13: $this->html .= 'thirteen '; break;
			case 14: $this->html .= 'fourteen '; break;
			case 15: $this->html .= 'fifteen '; break;
			case 16: $this->html .= 'sixteen '; break;
			default: break;
		}
		$this->html .= 'fields">'."\n";
		$this->indent_level++;
		$this->indent();
	}

	public function close_group() {
		$this->indent_level--;
		$this->indent();
		$this->html .= "</div>\n";
	}

	public function add_input_field($name, $label='', $value='') {
		$this->indent();
		$this->html .= '<div class="field">'."\n";
		$this->indent_level++;
		$this->indent();
		$this->html .= '<label>'.$label.'</label>'."\n";
		$this->indent();
		$this->html .= '<input type="text" name="'.$name.'" value="'.$value.'">'."\n";
		$this->indent_level--;
		$this->indent();
		$this->html .= '</div>'."\n";
	}

	public function add_tinyeditor($name, $label='', $value='') {
		$this->indent();
		$this->html .= '<div class="field">'."\n";
		$this->indent_level++;
		$this->indent();
		$this->html .= '<label>'.$label.'</label>'."\n";
		$this->indent();
		$this->html .= '<textarea id="input" name="'.$name.'" label="'.$label.'">'."\n";
		$this->indent_level++;
		$this->indent();
		$this->html .= $value."\n";
		$this->indent_level--;
		$this->indent();
		$this->html .= '</textarea>'."\n";
		$this->indent();
		$this->html .= '<script type="text/javascript" src="/assets/js/init_tinyeditor.js"></script>'."\n";
		$this->indent_level--;
		$this->indent();
		$this->html .= '</div>'."\n";
	}


	public function add_textarea($name, $label='', $value='') {
		$this->indent();
		$this->html .= '<div class="field">'."\n";
		$this->indent_level++;
		$this->indent();
		$this->html .= '<label>'.$label.'</label>'."\n";
		$this->indent();
		$this->html .= '<textarea name="'.$name.'" label="'.$label.'">'."\n";
		$this->html .= $value."\n";
		$this->html .= '</textarea>'."\n";
		$this->indent_level--;
		$this->indent();
		$this->html .= '</div>'."\n";

	}

	public function add_submit($label = "Submit") {
		$this->indent();
		$this->html .= '<input type="submit" value="'.$label.'" class="ui button">'."\n";

	}

	private function indent() {
		for ($i = 0; $i < $this->indent_level; $i++) {
			$this->html .= "\t";
		}
	}
	
}
 ?>
