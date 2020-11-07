<?php

include('simple_html_dom.php');
echo $html = file_get_html('http://www.gutenberg.org/ebooks/bookshelf/');
exit;

$table = '<table><tr><td>';
	   
	   
foreach($html->find(".bookshelf_pages") as $element)
{  
  foreach($element->find('li') as $element1)
  { 
    foreach($element1->find('a') as $element2)
     $url = 'http://www.gutenberg.org/'.$element2->href . '<br>';  
     $table = $table.$element2.'</td><td>'.$url.'</td></tr><tr><td>';  
	 
	 $htmll = file_get_html($url);
	 
	 foreach($htmll->find(".results") as $result)
     { 
	 
	    foreach($result->find('li') as $resultli)
         { 
		  echo $resultli;
		 }
	 } 
	//exit;
  }	 
  
}

echo $table = $table.'</table>';






// $url = "http://example.com/test.php";

 //Code to get the file...
 // $data = file_get_contents($url);

 //save as?
 // $filename = "test.html";

 //save the file...
 // $fh = fopen($filename,"w");
 // fwrite($fh,$data);
 // fclose($fh);



?>