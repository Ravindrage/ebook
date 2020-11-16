<?php


include 'db/dbsetup.php'; 
global $con;
$zip = new ZipArchive();



$sqlBooks = mysqli_query($con,"SELECT * FROM books");
//$rowBooks = mysqli_fetch($sqlBooks);
$i=0;

while ($rowServices = mysqli_fetch_array($sqlBooks)){
    
	$i++;
	//print_r($rowServices);
	echo '<br>';
	
if($i==7) { exit; }

echo $filename = "uploads/ebook/50000_ebooks/".$rowServices['title'].".epub";


if ($zip->open($filename, ZipArchive::CREATE)!==TRUE) {
    exit("cannot open <$filename>\n");
}else
{   $dir = "uploads/ebook/Html/".$rowServices['title'] ;
    if(!file_exists( $dir ) && !is_dir( $dir )) {
	mkdir($dir,777);
	$zip->extractTo("uploads/ebook/Html/".$rowServices['title']);
	$zip->close();
	}
	
		
}


    $dirname = "uploads/ebook/Html/".$rowServices['title']."/OEBPS/Images";
    $filenames = glob("$dirname/*cover*.jpg");

    foreach ($filenames as $filename)
    {
        
		
		$ext = pathinfo($filename, PATHINFO_EXTENSION);
		//echo move_uploaded_file($filename,"upload/ebook/coverImage/".$rowServices['id'].'.'.$ext);
		echo $filename;
		echo "upload/ebook/coverImage/".$rowServices['id'].'.'.$ext ;
		if( copy($filename,"uploads/ebook/coverImage/".$rowServices['id'].'.'.$ext ))
		{
		rename("uploads/ebook/coverImage/".$filename,"upload/ebook/coverImage/".$rowServices['title'].'.'.$ext);
		echo "Update books set image='".$rowServices['title'].$ext."' where id='".$rowServices['id']."'" ;
		mysqli_query($con,"Update books set image='".$rowServices['title'].'.'.$ext."' where id='".$rowServices['id']."' ");
		}
    }
	
	$dirname = "uploads/ebook/Html/".$rowServices['title']."/OEBPS";
    $filenames = glob("$dirname/*cover*.jpg");

    foreach ($filenames as $filename)
    {
       
		$ext = pathinfo($filename, PATHINFO_EXTENSION);
		echo '<br>';
		echo $filename; echo '------------';
		echo "upload/ebook/coverImage/".$rowServices['id'].'.'.$ext ;
		echo '<br>';
		if( copy($filename,"uploads/ebook/coverImage/".$rowServices['id'].'.'.$ext ))
		{
		rename("uploads/ebook/coverImage/".$filename,"uploads/ebook/coverImage/".$rowServices['title'].'.'.$ext);
		
		mysqli_query($con,"Update books set image='".$rowServices['title'].'.'.$ext."' where id='".$rowServices['id']."' ");
		}
    }
	
	

}
?>