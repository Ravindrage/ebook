<?php

	include 'db/dbsetup.php'; 

	$dir = "uploads/ebook/50000_ebooks/";


	if ($handle = opendir($dir)) {
	    while (($ebookName = readdir($handle)) !== false) {
	        if ($ebookName != "." && $ebookName != "..") {
	            echo "BookName: $ebookName<br><br>";
	            // foreach (glob($dir.$ebookName."/*.epub") as $filename) {
			    // 	//echo "$filename <br>";
			    // 	$filename = ltrim($filename, $dir.$ebookName);
			    // 	echo "Ebook File name: ".$filename."<br><br>";
                // }
                
                echo $filename = $ebookName;  echo '--';
                echo $ebookName = preg_replace('/\\.[^.\\s]{3,4}$/', '', $ebookName);

	           echo  $saveEbooks = "INSERT INTO books (`title`,`name`, `file_name`)
				 VALUES ('".addslashes($ebookName)."','".addslashes($ebookName)."', '".addslashes($filename)."')";
      			
               // exit;
	  			mysqli_query($con,$saveEbooks);
	        }
	    }
	    closedir($handle);
	}

?>