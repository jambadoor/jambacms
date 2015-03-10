<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class UI_Form {
	var $CI;
	var $html;

	public function __construct() {
		$CI =& get_instance();
		$this->CI =& $CI;
		if (!in_array('semantic-ui/form.css', $CI->view_data['css_plugins'])) $CI->view_data['css_plugins'][] = 'semantic-ui/form.css';

		$this->html = '';
	}

	public function open($config = array()) {
		foreach ($config as $key => $value) {
			${$key} = $value;
		}

		//open and set up class
		$this->html .= '<form class="';
		if (isset($class)) {
			$this->html .= $class;
		} else {
			$this->html .= 'ui form';
		}
		$this->html .= '"';

		if (isset($id)) {
			$this->html .= ' id="'.$id.'"';
		} 		

		if (isset($action)) {
			$this->html .= ' action="'.$action.'"';

		}

		$this->html .= ' method="POST"';
		$this->html .= '>'."\n";

		if (isset($header)) {
			$this->html .= '<h3>'.$header.'</h3>';
		}

	}

	public function close() {
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
	}

	public function close_group() {
		$this->html .= "</div>\n";
	}

	public function add_input_field($name, $label='', $value='') {
		$this->html .= '<div class="field">'."\n";
		$this->html .= '<label>'.$label.'</label>'."\n";
		$this->html .= '<input type="text" name="'.$name.'" value="'.$value.'">'."\n";
		$this->html .= '</div>';
	}

	public function add_textarea($name, $label='', $value='') {
		$this->html .= '<div class="field">'."\n";
		$this->html .= '<textarea name="'.$name.'" label="'.$label.'">'."\n";
		$this->html .= $value."\n";
		$this->html .= '</textarea>'."\n";
		$this->html .= '</div>'."\n";
	}

	public function add_submit($label = "Submit") {
		$this->html .= '<input type="submit" value="'.$label.'" class="ui button">'."\n";

	}
	
}
 ?>
