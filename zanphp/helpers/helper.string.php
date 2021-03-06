<?php
/**
 * ZanPHP
 *
 * An open source agile and rapid development framework for PHP 5
 *
 * @package		ZanPHP
 * @author		MilkZoft Developer Team
 * @copyright	Copyright (c) 2011, MilkZoft, Inc.
 * @license		http://www.zanphp.com/documentation/en/license/
 * @link		http://www.zanphp.com
 * @version		1.0
 */
 
/**
 * Access from index.php:
 */
if(!defined("_access")) {
	die("Error: You don't have permission to access here...");
}

/**
 * String Helper
 *
 * 
 *
 * @package		ZanPHP
 * @subpackage	core
 * @category	helpers
 * @author		MilkZoft Developer Team
 * @link		http://www.zanphp.com/documentation/en/helpers/string_helper
 */

/**
 * String Helper
 *
 * Cleans HTML from a String
 * 
 * @param string $HTML
 * @return string $text
 */ 
function cleanHTML($HTML) {
	$search = array ('@<script[^>]*?>.*?</script>@si',
					 '@<[\/\!]*?[^<>]*?>@si',
					 '@([\r\n])[\s]+@',
					 '@&(quot|#34);@i',
					 '@&(amp|#38);@i',
					 '@&(lt|#60);@i',
					 '@&(gt|#62);@i',
					 '@&(nbsp|#160);@i',
					 '@&(iexcl|#161);@i',
					 '@&(cent|#162);@i',
					 '@&(pound|#163);@i',
					 '@&(copy|#169);@i',
					 '@&#(\d+);@e');
	
	$replace = array('',
					 '',
					 '\1',
					 '"',
					 '&',
					 '<',
					 '>',
					 ' ',
					 chr(161),
					 chr(162),
					 chr(163),
					 chr(169),
					 'chr(\1)');
	
	$text = preg_replace($search, $replace, $HTML);	
	
	return $text;
}

/**
 * compress
 *
 * Compresses a string
 * 
 * @param string $text
 * @return string $text
 */ 
function compress($string) {
    $string = str_replace(array("\r\n", "\r", "\n", "\t", "  ", "    ", "    "), "", $string);
        
	return $string;	
}

/**
 * cut
 * 
 * Trims a string
 *
 * @param string $type = "Word"
 * @param string $text
 * @param string $length
 * @param string $nice
 * @param bool $file
 * @param bool   $elipsis 
 * @return string $
 */
function cut($type = "word", $text, $length = 12, $nice = TRUE, $file = FALSE, $elipsis = FALSE) {
	if($type === "text") {
		$elipsis = "...";
		$words   = explode(" ", $text);
				
		if(count($words) > $length) {
			return str_replace("\n", "", implode(" ", array_slice($words, 0, $length)) . $elipsis);
		}
		
		return $text;
	} elseif($type === "word") {
		if($file) {
			if(strlen($text) < $length) {
				$max = strlen($text);
			}
			
			if($nice) {
				return substr(nice($text), 0, $length);
			} else {
				return substr($text, 0, $length);			
			}
		} else {
			if(strlen($text) < 13) {
				return $text;
			}
			
			if(!$elipsis) {
				if($nice) {
					return substr(nice($text), 0, $length);
				} else {
					return substr($text, 0, $length);
				}
			} else {
				if($nice) {
					return substr(nice($text), 0, $length) . $elipsis;
				} else {
					return substr($text, 0, $length) . $elipsis;			
				}
			}
		}
	}
}

function decode($text, $URL = FALSE) {
	return (!$URL) ? utf8_decode($text) : urldecode($text);
}

/**
 * encode
 * 
 * Encodes a string and/or a URL
 *
 * @param string $text
 * @param string $URL = FALSE
 * @return string value
 */
function encode($text, $URL = FALSE) {
	return (!$URL) ? utf8_encode($text) : urlencode($text);
}

/**
 * FILES
 * 
 * Gets a specific position value from $_FILES
 * 
 * @param mixed  $name   = FALSE
 * @param string $coding = NULL
 * @return mixed
 */ 
function FILES($name = FALSE, $position = NULL, $i = NULL) {
	if(!$name) {
		____($_FILES);
	} elseif($position === NULL) {
		return isset($_FILES[$name]) ? $_FILES[$name] : FALSE;
	} elseif($i !== NULL and is_numeric($i)) {
		return isset($_FILES[$name][$position][$i]) ? $_FILES[$name][$position][$i] : FALSE;
	} else {
		return isset($_FILES[$name][$position]) ? $_FILES[$name][$position] : FALSE;
	}
}

/**
 * filter
 * 
 * Cleans a string
 *
 * @param string $text
 * @param string $cleanHTML = FALSE
 * @return string $text
 */
function filter($text, $filter = FALSE) {
	if($filter === TRUE) {
		$text = cleanHTML($text);
	} elseif($filter === "escape") {		
		$text = addslashes($text);
	} else {	
		$text = str_replace("'", "", $text);
		$text = str_replace('"', "", $text);
		$text = str_replace("\\", "", $text);
	}
		
	$text = str_replace("<", "", $text);
	$text = str_replace(">", "", $text);
	$text = str_replace("%27", "", $text);
	$text = str_replace("%22", "", $text);
	$text = str_replace("%20", "", $text);
		
	return $text;
}

/**
 * getFileSize
 * 
 * 
 *
 * @param string $position
 * @param string $coding = "decode"
 * @return string $coding = "decode"
 */
function getFileSize($size) {	
	if($size <= 0) {
		return FALSE;		
	} elseif($size < 1048576) {
		return round($size / 1024, 2) ." Kb";
	} else {
		return round($size / 1048576, 2) ." Mb";
	}
}

function getTotal($count, $singular, $plural) {
	if((int) $count === 0) {
		return $count ." ". __($plural);
	} elseif((int) $count === 1) {
		return $count ." ". __($singular);
	} else {
		return $count ." ". __($plural);
	}
}

/**
 * nice
 * 
 * Gets the nice form of a String
 *
 * @param string $title
 * @return string $title
 */
function nice($title) {		
	$characters = array("Á" => "A", "Ç" => "c", "É" => "e", "Í" => "i", "Ñ" => "n", "Ó" => "o", "Ú" => "u", 
						"á" => "a", "ç" => "c", "é" => "e", "í" => "i", "ñ" => "n", "ó" => "o", "ú" => "u"
	);
	
	$string = strtr($string, $characters);
	$string = strtolower(trim($string));
	$string = preg_replace("/[^a-z0-9-]/", "-", $string);
	$string = preg_replace("/-+/", "-", $string);
	
	if(substr($string, strlen($string) - 1, strlen($string)) === "-") {
		$string = substr($string, 0, strlen($string) - 1);
	}
	
	return $string;
}

function pageBreak($content, $URL = NULL) {
	$content = str_replace("<p><!-- pagebreak --></p>", "<!---->", $content);
	$content = str_replace('<p style="text-align: center;"><!-- pagebreak --></p>', "<!---->", $content);
	$content = str_replace('<p style="text-align: left;"><!-- pagebreak --></p>', "<!---->", $content);
	$content = str_replace('<p style="text-align: right;"><!-- pagebreak --></p>', "<!---->", $content);
	$content = str_replace('<p style="text-align: justify;"><!-- pagebreak --></p>', "<!---->", $content);
	$content = str_replace('<p style="text-align: center;"><span style="color: #ff0000;"><!----></span></p>', "<!---->", $content);
	$content = str_replace('<p style="text-align: center;"><em><!-- pagebreak --></em></p>', "<!---->", $content);
	$content = str_replace('<p style="text-align: center;"><strong><!-- pagebreak --></strong></p>', "<!---->", $content);
	$content = str_replace('<p style="text-align: center;"><span style="text-decoration: underline;"><!-- pagebreak --></span></p>', "<!---->", $content);
	$content = str_replace('<p style="text-align: justify;"><!-- pagebreak --></p>', "<!---->", $content);
	$content = str_replace('<p><!-- pagebreak -->', "<p><!-- pagebreak --></p>\n<p>", $content);
	$content = str_replace("<p><!-- pagebreak --></p>", "<!---->", $content);
	$content = str_replace('<!-- pagebreak -->', "<!---->", $content);		
			
	$parts = explode("<!---->", $content);

	if(count($parts) > 1) {
		return $parts[0] .'<p><a href="'. $URL .'" title="'. __("Read more") .'">&raquo;'. __("Read more") .'...</a></p>';
	}
	
	return $content;		
}

/**
 * POST
 * 
 * Gets a specific position value from $_POST
 * 
 * @param string $position
 * @param string $coding   = "decode"
 * @return mixed
 */ 
function POST($position = FALSE, $coding = "decode", $filter = TRUE) {
	if($position === TRUE) {
		return $_POST;
	} elseif(!$position) {
		____($_POST);
	} elseif(isset($_POST[$position]) and is_array($_POST[$position])) {
		return $_POST[$position];
	} elseif(isset($_POST[$position]) and $_POST[$position] === "") {
		return NULL;
	} elseif(isset($_POST[$position])) {
		if($coding === "encrypt") {
			if($filter === TRUE) {
				return encrypt(encode($_POST[$position]));
			} elseif($filter === "escape") {
				return encrypt(filter(encode($_POST[$position]), "escape"));
			} else {
				return encrypt(filter(encode($_POST[$position]), TRUE));
			}
		} elseif($coding === "encode") {
			if($filter === TRUE) {
				return encode($_POST[$position]);
			} elseif($filter === "escape") {
				return filter(encode($_POST[$position]), "escape");
			}  else {
				return filter(encode($_POST[$position]), TRUE);
			}
		} elseif($coding === "decode-encrypt") {
			if($filter === TRUE) {
				return encrypt(filter($_POST[$position], TRUE));
			} elseif($filter === "escape") {
				return encrypt(filter($_POST[$position], "escape"));
			}  else {
				return encrypt($_POST[$position]);
			}		
		} elseif($coding === "decode") {			
			if($filter === TRUE) {
				return filter(decode($_POST[$position]), TRUE);
			} elseif($filter === "escape") {
				return filter(decode($_POST[$position]), "escape");
			}  else {
				$data = decode($_POST[$position]);
				$data = str_replace("'", "\'", $data);
				
				return $data;
			}
		} else {
			if($filter === TRUE) {
				return filter($_POST[$position], TRUE);
			} elseif($filter === "escape") {
				return filter($_POST[$position], "escape");
			}  else {
				return $_POST[$position];
			}		
		}
	} else {
		return FALSE;
	}
}

/**
 * recoverPOST
 * 
 * Recovers data from $_POST
 *
 * @parama string $position
 * @parama string $value = NULL
 * @return string
 */
function recoverPOST($position, $value = NULL) {
	if(!$value) {
		return (POST($position)) ? htmlentities(POST($position, "decode", FALSE)) : NULL;
	} else {
		if(is_array($value)) {
			foreach($value as $val) {
				$data[] = htmlentities($val);
			}
			
			return $data;
		} else {
			return (POST($position)) ? htmlentities(POST($position, "decode", FALSE)) : htmlentities(decode($value));
		}	
	}
}

/**
 * removeSpaces
 *
 * Removes blank spaces
 * 
 * @param string $text
 * @param bool   $trim
 * @return string $text
 */ 
function removeSpaces($text, $trim = FALSE) {
	$text = preg_replace("/\s+/", " ", $text);
	
	if($trim) {
		return trim($text);
	}
	
	return $text;
}
