<?php
/**
 * Access from index.php:
 */
if(!defined("_access")) {
	die("Error: You don't have permission to access here...");
}

function translation($text) {
	switch($text) {
		case "Hello": return "Hola"; break;
		case "Hi, I'm agenda": return "Hola, soy agenda"; break;
		case "Hello World!": return "Hola Mundo!"; break;
		case "Goodbye Cruel World!": return "Adiós Mundo Cruel!"; break;
		case "The contact has been edited correctly": return "El contacto ha sido editado correctamente"; break;
	}
	
	return $text;
}
