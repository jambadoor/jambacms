<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class UI {
	var $CI;
	var $html;
	var $indent_level;

	/*
	 * CONSTRUCTOR
	 * set up our ci instance and load in the required semantic files
	 */
	public function __construct() {
		$CI =& get_instance();
		$this->CI =& $CI;
		
		$css_plugins = array('reset', 'site', 'button', 'grid', 'tab', 'menu', 'divider', 'header', 'segment', 'icon');
		foreach ($css_plugins as $plugin) {
			if (!in_array("semantic-ui/$plugin.css", $CI->view_data['css_plugins'])) $CI->view_data['css_plugins'][] = "semantic-ui/$plugin.css";
		}
		$this->indent_level = 0;
	}

	/*
	 * creates a ui button with options
	 */
	public function add_button ($config = array()) {
		//get all of our config values as local variables
		foreach ($config as $key => $value) {
			${$key} = $value;
		}

		if (isset($indent_level)) {
			$this->indent_level = $indent_level;
		} else {
			$this->indent_level = 0;
		}

		$this->indent();

		if (!isset($tag)) { $tag = 'a'; }

		//open up our tag
		$this->html .= '<'.$tag.' class="';
		if (isset($class)) {
			$this->html .= $class;
		} else {
			$this->html .= 'ui button';
		}
		$this->html .= '"';

		if (isset($id)) { $this->html .= ' id="'.$id.'"'; } 		

		if (isset($href)) { $this->html .= ' href="'.$href.'"'; }

		$this->html .= '>'."\n";

		//move our indent up a level and indent
		$this->indent_level++;
		$this->indent();

		if (isset($icon)) {
			$this->html .= '<i class="'.$icon.' icon"></i>'."\n";
	   		$this->indent();
		}

		if (isset($text)) {
			$this->html .= $text."\n";
		}

		$this->indent_level--;
		$this->indent();

		$this->html .= '</'.$tag.'>'."\n";

	}

	/*
	 * we keep our indents pretty
	 */
	private function indent() {
		for ($i = 0; $i < $this->indent_level; $i++) {
			$this->html .= "\t";
		}
	}

	/*
	 * actually output the markup
	 * and reset it
	 */
	public function render() {
		echo $this->html;
		$this->html = '';
	}

	/*
	 * return the markup without outputting
	 */
	public function get() {
		return $this->html;
	}
}

?>
