<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class UI {
	var $CI;
	var $html;
	public $indent_level;

	/*
	 * CONSTRUCTOR
	 * set up our ci instance and load in the required semantic files
	 */
	public function __construct() {
		$CI =& get_instance();
		$this->CI =& $CI;
		
		$css_plugins = array('reset', 'site', 'button', 'grid', 'tab', 'menu', 'divider', 'header', 'segment', 'icon', 'breadcrumb', 'image');
		foreach ($css_plugins as $plugin) {
			if (!in_array("semantic-ui/$plugin.min.css", $CI->view_data['css_plugins'])) $CI->view_data['css_plugins'][] = "semantic-ui/$plugin.css";
		}
		$this->indent_level = 0;
	}

	/*
	 * elements that open and close in the same function
	 ****************************************************************************/
	/*
	 * creates a ui button with options
	 */
	public function add_button ($config = array()) {
		//get all of our config values as local variables
		foreach ($config as $key => $value) {
			${$key} = $value;
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
	 * creates a breadcrumb element using config data
	 */
	public function add_breadcrumb($config) {
		//get all of our config values as local variables
		foreach ($config as $key => $value) {
			${$key} = $value;
		}

		//open up our tag
		$this->indent();
		$this->html .= '<div class="ui ';
		if (isset($breadcrumb_class)) {
			$this->html .= $breadcrumb_class.' ';
		}
		$this->html .= 'breadcrumb">'."\n";
		$this->indent_level++;
		if (isset($crumbs)) {
			foreach ($crumbs as $href => $text) {
				$this->indent();
				if ($href !== '') {
					$this->html .= '<a href="'.$href.'" class="section">'.$text.'</a>'."\n";
					$this->indent();
					$this->html .= '<div class="divider">/</div>'."\n";
				} else {
					$this->html .= '<div class="section">'.$text.'</div>'."\n";
				}
			}
		}
		$this->indent_level--;
		$this->indent();
		$this->html .= '</div>'."\n";
	}

	/*
	 * create a link
	 */
	public function add_link($href, $text, $class='', $id='') {
		$this->indent();
		$this->html .= '<a href="'.$href.'"';
		if ($class !== '') {
			$this->html .= ' class="'.$class.'"';
		}
		if ($id !== '') {
			$this->html .= ' id="'.$id.'"';
		}
		$this->html .= '>'.$text.'</a>'."\n";
	}

	/*
	 * creates headers
	 */
	public function add_h($size, $content, $class = '', $id = '') {
		$this->indent();
		$this->html .= '<h'.$size;
		if ($class !== '') {
			$this->html .= ' class="'.$class.'"';
		}
		if ($id !== '') {
			$this->html .= ' id="'.$id.'"';
		}
		$this->html .= '>'.$content.'</h'.$size.'>'."\n";
	}

	/*
	 * insert some content
	 */
	public function add_content($content) {
		$this->indent();
		$this->open_div();
		$this->html .= $content."\n";
		$this->close_div();
	}

	/*
	 * elements that require open and close calls
	 ****************************************************************************/
	/*
	 * div
	 */
	public function open_div($class = '', $id = '') {
		$this->indent();
		$this->html .= '<div';
		if ($class !== '') {
			$this->html .= ' class="'.$class.'"';
		}
		if ($id !== '') {
			$this->html .= ' id="'.$id.'"';
		}
		$this->html .= '>'."\n";
		$this->indent_level++;
	}

	public function close_div() {
		$this->indent_level--;
		$this->indent();
		$this->html .= '</div>'."\n";
	}

	/*
	 * grid columns
	 ****************************************************************************/
	public function open_column($class = '') {
		$this->indent();
		$this->html .= '<div class="';
		if ($class !== '') {
			$this->html .= $class.' ';
		}
		$this->html .= 'column">'."\n";

		$this->indent_level++;
	}

	public function close_column() {
		$this->indent_level--;
		$this->indent();
		$this->html .= '</div>'."\n";
	}



	/*
	 * utility functions
	 ****************************************************************************/
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
