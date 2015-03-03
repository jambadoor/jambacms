<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
 * Author: Jason Benford
 * File: /application/core/MY_Controller
 * Description: The lowest level application controller, from which all others will inherit.
 * 	Multiple layers of inheritence is supported.
 */
abstract class Base_Controller extends CI_Controller {
	public function __construct() {
		parent::__construct();


		//the view_data that all controllers need
	}

}
// End of Base_Controller class

/* End of file MY_Controller.php */
/* Location: ./application/core/MY_Controller.php */
?>
