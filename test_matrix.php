<?php
	
	// $matrix['Priniciple 1'] = array(
	// 	"Sub topic 1" => array("Chapter 1", "Chapter 2"),
	// 	"Sub topic 2" => array("Chapter 1", "Chapter 2"),
	// 	"Sub topic 3" => array("Chapter 1", "Chapter 2"),
	// 	"Sub topic 4" => array("Chapter 1", "Chapter 2"),
	// 	"Sub topic 5" => array("Chapter 1", "Chapter 2")
	// );

	// echo '<pre>';
	// print_r($matrix);
	// echo '</pre>';


function getTextBetweenTags($tag, $html, $strict=0)
{
    /*** a new dom object ***/
    $dom = new domDocument;

    /*** load the html into the object ***/
    if($strict==1)
    {
        $dom->loadXML($html);
    }
    else
    {
        $dom->loadHTML($html);
    }

    /*** discard white space ***/
    $dom->preserveWhiteSpace = false;

    /*** the tag by its tag name ***/
    $content = $dom->getElementsByTagname($tag);

    /*** the array to return ***/
    $out = array();
    foreach ($content as $item)
    {
        /*** add node value to the out array ***/
        $out[] = $item->nodeValue;
    }
    /*** return the results ***/
    return $out;
}

$str = '<div>
 <h2>Where does it come from?</h2>
 <p>Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of "de Finibus Bonorum et Malorum" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, "Lorem ipsum dolor sit amet..", comes from a line in section 1.10.32.</p>
 <p>The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from "de Finibus Bonorum et Malorum" by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.</p>
 </div>;';

 $arr = getTextBetweenTags('p', $str);

 echo substr($arr[0], 0, 300);


// $numChar = rand(0, 5);
// echo $numChar;


?>