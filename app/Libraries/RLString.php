<?php
/**
 * Common functions for string manipulation
 *
 * @author pne
 */
namespace Helper;
 use Michelf\Markdown;

 class RLString{
 	/**
 	 * This function normalizes a string so it can be used as a filename or foldername
 	 *
 	 * @param string $s the string to normalize
 	 * @author pne
 	 * @return string the normalized string
 	 */
 	public static function normalize($s)
 	{
 		return self::clean($s);
 	}

 	/** 
 	 * Cleans up a string
 	 * @param string the string to clean up
 	 * @author http://stackoverflow.com/a/14114419
 	 * @return string the cleaned up string
 	 */
 	public static function clean($string) {
	   $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.
	   $string = preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.

	   return strtolower(preg_replace('/-+/', '-', $string)); // Replaces multiple hyphens with single one.
	}

	public static function beautify($string)
	{
		$text = preg_replace('#(script|about|applet|activex|chrome):#is', "\\1:", htmlentities($string));

		$ret = ' ' . $text;
		
		// Replace Links with http://
		$ret = preg_replace("#(^|[\n ])([\w]+?://[\w\#$%&~/.\-;:=,?@\[\]+]*)#is", "\\1<a href=\"\\2\" target=\"_blank\" rel=\"nofollow\">\\2</a>", $ret);
		
		// Replace Links without http://
		$ret = preg_replace("#(^|[\n ])((www|ftp)\.[\w\#$%&~/.\-;:=,?@\[\]+]*)#is", "\\1<a href=\"http://\\2\" target=\"_blank\" rel=\"nofollow\">\\2</a>", $ret);

		// Replace Email Addresses
		$ret = preg_replace("#(^|[\n ])([a-z0-9&\-_.]+?)@([\w\-]+\.([\w\-\.]+\.)*[\w]+)#i", "\\1<a href=\"mailto:\\2@\\3\">\\2@\\3</a>", $ret);
		$ret = substr($ret, 1);

		$text = Markdown::defaultTransform(nl2br(trim($ret)));

		//$text = preg_replace("/kappa\b/i", '<img src="'.asset('assets/images/emoticons/kappa.png').'" class="emote emote-kappa" />', $text);

		return $text;
	}
 }


?>