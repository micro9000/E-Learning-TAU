<?php if( ! defined('BASEPATH')) exit('No direct script access allowed');
	
	if (! function_exists('get_content_summary_helper')){

		function get_content_summary_helper($content){

			$contentsArr = getTextBetweenTags("p", $content);

			$arrLen = sizeof($contentsArr);

			$numCharsArr = array(300, 280, 270, 250, 290, 310, 320);
			$numChar = $numCharsArr[rand(0, 6)];

			$tmpStr = "";

			for($i=0; $i<$arrLen; $i++){
				$tmpStr .= $contentsArr[$i];
			}

			$summary = substr($tmpStr, 0, $numChar);

			return $summary;
		}


		function getTextBetweenTags($tag, $html, $strict=0){
		    /*** a new dom object ***/
		    $dom = new domDocument;

		    /*** load the html into the object ***/
		    if($strict==1){
		        $dom->loadXML($html);
		    }
		    else{
		        $dom->loadHTML($html);
		    }

		    /*** discard white space ***/
		    $dom->preserveWhiteSpace = false;

		    /*** the tag by its tag name ***/
		    $content = $dom->getElementsByTagname($tag);

		    $out = array();
		    foreach ($content as $item){
		        /*** add node value to the out array ***/
		        $out[] = $item->nodeValue;
		    }
		    return $out;
		}

	}

?>	