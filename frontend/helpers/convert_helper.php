<?php

/**
 * Convert From Minute(s) to Hour(s).
 * 
 * @param integer $value 
 * 
 * @return string text value
 */
function ConvertMinutesHours($value = 0)
{
    if ($value > 60) {
        $hours = floor($value / 60);
        $minutes = ($value % 60);
        // return $hours. ' '. get_lang_text('general', 'general_text_hour'). ' '. $minutes. ' '. get_lang_text('general', 'general_text_minute');
        return $hours. ' : '. $minutes;
    }

    // return $value. ' '. get_lang_text('general', 'general_text_minute');
    return $value;
}

/**
* convert xml string to php array - useful to get a serializable value
*
* @param object $node
* @return array
*
* @author Adrien aka Gaarf & contributors
* @see http://gaarf.info/2009/08/13/xml-string-to-php-array/
*/
function domnode_to_array($node) {
    $output = array();
    switch ($node->nodeType) {
        case XML_CDATA_SECTION_NODE:
        case XML_TEXT_NODE:
        $output = trim($node->textContent);
        break;
        case XML_ELEMENT_NODE:
        for ($i=0, $m=$node->childNodes->length; $i<$m; $i++) {
            $child = $node->childNodes->item($i);
            $v = domnode_to_array($child);
            if(isset($child->tagName)) {
                $t = $child->tagName;
                if(!isset($output[$t])) {
                    $output[$t] = array();
                }
                $output[$t][] = $v;
            }
            elseif($v || $v === '0') {
                $output = (string) $v;
            }
        }
        if($node->attributes->length && !is_array($output)) { //Has attributes but isn't an array
            $output = array('@content'=>$output); //Change output into an array.
        }
        if(is_array($output)) {
            if($node->attributes->length) {
                $a = array();
                foreach($node->attributes as $attrName => $attrNode) {
                    $a[$attrName] = (string) $attrNode->value;
                }
                $output['@attributes'] = $a;
            }
            foreach ($output as $t => $v) {
                if(is_array($v) && count($v)==1 && $t!='@attributes') {
                    $output[$t] = $v[0];
                }
            }
        }
        break;
    }
    return $output;
}

/**
* convert xml string to php array - useful to get a serializable value
*
* @param string $xmlstr
* @return array
*
* @author Adrien aka Gaarf & contributors
* @see http://gaarf.info/2009/08/13/xml-string-to-php-array/
*/
function xmlstr_to_array($xmlstr) {
    $doc = new DOMDocument();
    $doc->loadXML($xmlstr);
    $root = $doc->documentElement;
    $output = domnode_to_array($root);
    $output['@root'] = $root->tagName;

    return $output;
}

/**
 * Parsing XML into array.
 *
 * @param string $contents      string containing XML
 * @param bool   $getAttributes
 * @param bool   $tagPriority   priority of values in the array - `true` if the higher priority in the tag,
 * `false` if only the attributes needed
 * @param string $encoding      target XML encoding
 *
 * @return array
 * 
 * @author Anton Trofimenko
 * @see https://github.com/r37r0m0d3l/XmlToArray
 */
function xmlToArray($contents, $getAttributes = true, $tagPriority = true, $encoding = 'utf-8')
{
    $contents = trim($contents);
    if (empty($contents)) {
        return [];
    }
    $parser = xml_parser_create('');
    xml_parser_set_option($parser, XML_OPTION_TARGET_ENCODING, $encoding);
    xml_parser_set_option($parser, XML_OPTION_CASE_FOLDING, 0);
    xml_parser_set_option($parser, XML_OPTION_SKIP_WHITE, 1);
    if (xml_parse_into_struct($parser, $contents, $xmlValues) === 0) {
        xml_parser_free($parser);
        return [];
    }
    xml_parser_free($parser);
    if (empty($xmlValues)) {
        return [];
    }
    unset($contents, $parser);
    $xmlArray = [];
    $current = &$xmlArray;
    $repeatedTagIndex = [];
    foreach ($xmlValues as $num => $xmlTag) {
        $result = null;
        $attributesData = null;
        if (isset($xmlTag['value'])) {
            if ($tagPriority) {
                $result = $xmlTag['value'];
            } else {
                $result['value'] = $xmlTag['value'];
            }
        }
        if (isset($xmlTag['attributes']) and $getAttributes) {
            foreach ($xmlTag['attributes'] as $attr => $val) {
                if ($tagPriority) {
                    $attributesData[$attr] = $val;
                } else {
                    $result['@attributes'][$attr] = $val;
                }
            }
        }
        if ($xmlTag['type'] == 'open') {
            $parent[$xmlTag['level'] - 1] = &$current;
            if (!is_array($current) or (!in_array($xmlTag['tag'], array_keys($current)))) {
                $current[$xmlTag['tag']] = $result;
                unset($result);
                if ($attributesData) {
                    $current['@'.$xmlTag['tag']] = $attributesData;
                }
                $repeatedTagIndex[$xmlTag['tag'].'_'.$xmlTag['level']] = 1;
                $current = &$current[$xmlTag['tag']];
            } else {
                if (isset($current[$xmlTag['tag']]['0'])) {
                    $current[$xmlTag['tag']][$repeatedTagIndex[$xmlTag['tag'].'_'.$xmlTag['level']]] = $result;
                    unset($result);
                    if ($attributesData) {
                        if (isset($repeatedTagIndex['@'.$xmlTag['tag'].'_'.$xmlTag['level']])) {
                            $current[$xmlTag['tag']][$repeatedTagIndex['@'.$xmlTag['tag'].'_'.$xmlTag['level']]] = $attributesData;
                        }
                    }
                    $repeatedTagIndex[$xmlTag['tag'].'_'.$xmlTag['level']] += 1;
                } else {
                    $current[$xmlTag['tag']] = [$current[$xmlTag['tag']], $result];
                    unset($result);
                    $repeatedTagIndex[$xmlTag['tag'].'_'.$xmlTag['level']] = 2;
                    if (isset($current['@'.$xmlTag['tag']])) {
                        $current[$xmlTag['tag']]['@0'] = $current['@'.$xmlTag['tag']];
                        unset($current['@'.$xmlTag['tag']]);
                    }
                    if ($attributesData) {
                        $current[$xmlTag['tag']]['@1'] = $attributesData;
                    }
                }
                $lastItemIndex = $repeatedTagIndex[$xmlTag['tag'].'_'.$xmlTag['level']] - 1;
                $current = &$current[$xmlTag['tag']][$lastItemIndex];
            }
        } elseif ($xmlTag['type'] == 'complete') {
            if (!isset($current[$xmlTag['tag']]) and empty($current['@'.$xmlTag['tag']])) {
                $current[$xmlTag['tag']] = $result;
                unset($result);
                $repeatedTagIndex[$xmlTag['tag'].'_'.$xmlTag['level']] = 1;
                if ($tagPriority and $attributesData) {
                    $current['@'.$xmlTag['tag']] = $attributesData;
                }
            } else {
                if (isset($current[$xmlTag['tag']]['0']) and is_array($current[$xmlTag['tag']])) {
                    $current[$xmlTag['tag']][$repeatedTagIndex[$xmlTag['tag'].'_'.$xmlTag['level']]] = $result;
                    unset($result);
                    if ($tagPriority and $getAttributes and $attributesData) {
                        $current[$xmlTag['tag']]['@'.$repeatedTagIndex[$xmlTag['tag'].'_'.$xmlTag['level']]] = $attributesData;
                    }
                    $repeatedTagIndex[$xmlTag['tag'].'_'.$xmlTag['level']] += 1;
                } else {
                    $current[$xmlTag['tag']] = [
                        $current[$xmlTag['tag']],
                        $result,
                    ];
                    unset($result);
                    $repeatedTagIndex[$xmlTag['tag'].'_'.$xmlTag['level']] = 1;
                    if ($tagPriority and $getAttributes) {
                        if (isset($current['@'.$xmlTag['tag']])) {
                            $current[$xmlTag['tag']]['@0'] = $current['@'.$xmlTag['tag']];
                            unset($current['@'.$xmlTag['tag']]);
                        }
                        if ($attributesData) {
                            $current[$xmlTag['tag']]['@'.$repeatedTagIndex[$xmlTag['tag'].'_'.$xmlTag['level']]] = $attributesData;
                        }
                    }
                    $repeatedTagIndex[$xmlTag['tag'].'_'.$xmlTag['level']] += 1;
                }
            }
        } elseif ($xmlTag['type'] == 'close') {
            $current = &$parent[$xmlTag['level'] - 1];
        }
        unset($xmlValues[$num]);
    }
    return $xmlArray;
}

/**
 * Convert Array to XML.
 * 
 * @param  array $array
 * @param  object &$xml_info
 * 
 * @return array
 */
function array_to_xml($array, &$xml_info) {
    foreach($array as $key => $value) {
        if(is_array($value)) {
            if(!is_numeric($key)){
                $subnode = $xml_info->addChild("$key");
                array_to_xml($value, $subnode);
            }else{
                $subnode = $xml_info->addChild("item$key");
                array_to_xml($value, $subnode);
            }
        }else {
            $xml_info->addChild("$key",htmlspecialchars("$value"));
        }
    }
}


/* End of file convert_helper.php */
/* Location: ./application/helpers/convert_helper.php */