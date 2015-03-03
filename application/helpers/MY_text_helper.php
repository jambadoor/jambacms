<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if (!function_exists('ascii_to_html')) {
	function ascii_to_html($str, $paragraphs = TRUE) {
		if ($paragraphs)
			$html = '<p>';

		$strlen = strlen($str);

		for ($i = 0; $i < $strlen; ++$i) {
			switch ($str[$i]) {
				case "\r" :
				case "\n" : 
					if ($paragraphs)
						$html .= '</p><p>'; 
					else
						$html .= '</br>';
					break;
				case "\t" :
					break;
				case '&' :
					$html .= '&amp;';
					break;
				case '"' :
					$html .= '&quot;';
					break;
				default: $html .= $str[$i];
			}
		}

		if ($paragraphs)
			$html .= '</p>';

		return $html;
	}
}
