<?php

class XmlElement
{
	var $name;
	var $attributes;
	var $content;
	var $children;
};

class xml
{
	function __construct()
	{
		if (!$this->required_functions())
		{
			die();
		}
		$this->result=false;
	}

	private function required_functions()
	{
		$result = true;
		$essential = array('xml_parser_create','xml_parser_set_option', 'xml_parse_into_struct', 'xml_parser_free');
		foreach ($essential as $name)
		{
			if (!function_exists($name))
			{
				$result = false;
				trigger_error('xml error - this class need some functions like '.$name,E_USER_WARNING);
			}
		}
		if (!$result)
		{
			trigger_error('xml error - can\'t proceed', E_USER_ERROR);
		}
		return $result;
	}

	public function xml_code_to_object($xml)
	{
		// Template: http://www.php.net/manual/de/function.xml-parse-into-struct.php#66487
		// Changed for usage in ViaThinkSoft Personal WebBase

		$parser = xml_parser_create();
		xml_parser_set_option($parser, XML_OPTION_CASE_FOLDING, 0);
		xml_parser_set_option($parser, XML_OPTION_SKIP_WHITE, 0);
		xml_parser_set_option($parser, XML_OPTION_TARGET_ENCODING, 'UTF-8');

		xml_parse_into_struct($parser, $xml, $tags);
		xml_parser_free($parser);

		$elements = array();
		$stack = array();
		foreach ($tags as $tag)
		{
			$index = count($elements);
			if ($tag['type'] == "complete" || $tag['type'] == "open")
			{
				$elements[$index] = new XmlElement;
				$elements[$index]->name = $tag['tag'];
				if ((isset($tag['attributes'])) && ($tag['attributes'] != ''))
				{
					foreach ($tag['attributes'] as $m1 => $m2)
					{
						$elements[$index]->attributes[$m1] = $this->xml_unescape($tag['attributes'][$m1]);
					}
				}
				else
				{
					$elements[$index]->attributes = array();
				}
				if (isset($tag['value']))
				{
					$elements[$index]->content = $this->xml_unescape($tag['value']);
				}
				if ($tag['type'] == "open")
				{
					$elements[$index]->children = array();
					$stack[count($stack)] = &$elements;
					$elements = &$elements[$index]->children;
				}
			}
			if ($tag['type'] == "close")
			{
				$elements = &$stack[count($stack) - 1];
				unset($stack[count($stack) - 1]);
			}
		}// echo $xml;
		//print_r($elements);
		return $elements[0];
	}

	public function xml_file_to_object($filename)
	{
		// Daniel Marschall

		$xml = file_get_contents($filename);
		return $this->xml_code_to_object($xml);
	}

	private function xml_escape($input)
	{
		// Daniel Marschall

		$input = str_replace('&', '&amp;',	$input);
		$input = str_replace("'", '&apos;', $input);
		$input = str_replace('"', '&quot;', $input);
		$input = str_replace('<', '&lt;',	 $input);
		$input = str_replace('>', '&gt;',	 $input);

		$input = utf8_encode($input);

		return $input;
	}

	private function xml_unescape($input)
	{
		// Daniel Marschall

		$input = utf8_decode($input);

		return $input;
	}

	private function recursive_xml_build($cu, $level = 0)
	{
		// Daniel Marschall

		$code = str_repeat("\t", $level).'<'.$cu->name;
		if (count($cu->attributes) > 0)
		{
			foreach ($cu->attributes as $m1 => $m2)
			{
				$code .= ' '.$m1.'="'.$this->xml_escape($m2).'"';
			}
		}
		if (($cu->content == '') && (count($cu->children) == 0))
		{
			$code .= ' /';
		}
		else
		{
			$code .= '>';
			if ($cu->content != '')
			{
				$code .= $this->xml_escape($cu->content);
			}
			if (count($cu->children) > 0)
			{
				$code .= "\r\n";
				foreach ($cu->children as $n1 => $n2)
				{
					$code .= $this->{__FUNCTION__}($n2, $level+1);
				}
				$code .= str_repeat("\t", $level);
			}
			$code .= '</'.$cu->name;
		}
		$code .= ">\r\n";

		return $code;
	}

	public function object_to_xml_code($object)
	{
		// Daniel Marschall

		$code = '<?xml version="1.0" encoding="utf8"?>'."\r\n\r\n";

		$code .= $this->recursive_xml_build($object);

		return $code;
	}

	public function object_to_xml_file($object, $filename)
	{
		// Daniel Marschall

		if (is_writable($filename))
		{
			$text = $this->recursive_xml_build($object);

			if ($handler = @fopen($filename, 'w'))
			{
				if (@fwrite($handler, $text))
				{
					@fclose($handler);
					return true;
				}
				else
				{
					return false;
				}
			}
			else
			{
				return false;
			}
		}
		else
		{
			return false;
		}
	}
}

?>