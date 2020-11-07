<?php 
if(!defined('MyConst')) {
   die('Direct access not permitted');
}

session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<?php
//DB connection string and Global variables
include '../db/dbsetup.php'; 

if ($IPrange>"") {
	if (!strstr($_SERVER['REMOTE_ADDR'], $IPrange) ){
		echo "</head>\n";
		echo "<body>\n";
		echo "<p>Permission denied</p>\n";
		echo "</body>\n";
		echo "</html>\n";
		exit(); //Do not execute any more code on the page
	}
}
?>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Bootstrap admin panel 2/2/2015">
    <meta name="author" content="Ryan Jones">

    <title>Admin Panel</title>

    <!-- Bootstrap Core 3.3.5 CSS CDN -->
    <link rel="stylesheet" type="text/css" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">

    <!-- Admin Panel CSS -->
    <link rel="stylesheet" type="text/css" href="css/sb-admin.css">

    <!-- Admin Panel Custom Fonts -->
    <link rel="stylesheet" type="text/css" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
	
	<!-- DataTables CSS -->
    <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/plug-ins/1.10.7/integration/bootstrap/3/dataTables.bootstrap.css" >
	
    <!-- jQuery CDN -->
    <script type="text/javascript" language="javascript" src="//code.jquery.com/jquery-1.10.2.min.js"></script>
	
	<!-- Admin Panel Bootstrap Core JavaScript -->
    <script type="text/javascript" language="javascript" src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

    <!-- TinyMCE CDN -->
    <script type="text/javascript" language="javascript" src="//tinymce.cachefly.net/4.1/tinymce.min.js"></script>
	
	<!-- DataTables JavaScript CDN -->
    <script type="text/javascript" language="javascript" src="//cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" language="javascript" src="//cdn.datatables.net/plug-ins/1.10.7/integration/bootstrap/3/dataTables.bootstrap.js"></script>

    <!-- Custom Functions -->
    <script type="text/javascript" language="javascript" src="js/functions.js"></script>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

  <?php
	$sqlSetup = mysqli_query($con,"SELECT tinymce, pageheading, servicesheading, sliderheading, teamheading, customersheading FROM setup");
	$rowSetup = mysqli_fetch_array($sqlSetup);
    //$sqlSetup = mysqli_query($con,"SELECT tinymce FROM setup");
    //$rowSetup = mysqli_fetch_array($sqlSetup);
	
	$sqlFeatured = mysqli_query($con,"SELECT heading FROM featured");
	$rowFeatured = mysqli_fetch_array($sqlFeatured);
	
	$sqlAbout = mysqli_query($con,"SELECT heading FROM aboutus");
	$rowAbout = mysqli_fetch_array($sqlAbout);

	$sqlContact = mysqli_query($con,"SELECT heading FROM contactus");
	$rowContact = mysqli_fetch_array($sqlContact);
	
	$sqlGeneralinfo = mysqli_query($con,"SELECT heading FROM generalinfo");
	$rowGeneralinfo = mysqli_fetch_array($sqlGeneralinfo);
	
	$sqlSocial = mysqli_query($con,"SELECT heading FROM socialmedia");
	$rowSocial = mysqli_fetch_array($sqlSocial);
	$fileListJson = '';
	$linkListJson = '';

	if (isset($_SESSION["user_id"]) AND isset($_SESSION["user_name"]) AND $rowSetup["tinymce"]==1) {
        //Build list of images in uploads folder for tinymce editor
        if ($handle = opendir($image_dir)) {
            while (false !== ($imgfile = readdir($handle))) {
                if ('.' === $imgfile) continue;
                if ('..' === $imgfile) continue;
                if ($imgfile==="Thumbs.db") continue;
                if ($imgfile===".DS_Store") continue;
                if ($imgfile==="index.html") continue;

                $fileListJson = $fileListJson . "{title: '".$imgfile."', value: '".$image_url.$imgfile."'},";
            }
            closedir($handle);
        }

        //get and build page list for TinyMCE
        $sqlGetPages= mysqli_query($con,"SELECT id, title, active FROM pages WHERE active=1 ORDER BY title");
        while ($rowGetPages = mysqli_fetch_array($sqlGetPages)) {
            $getPageId=$rowGetPages['id'];
            $getPageTitle=$rowGetPages['title'];
            $linkListJson = $linkListJson . "{title: '".$getPageTitle."', value: 'page.php?ref=".$getPageId."'},";
        }
        
	?>
    	<script type="text/javascript">
            $(document).ready(function () {
    			tinymce.init({
    			selector: 'textarea.tinymce',
    		    plugins: 'link image table code',
    		    image_dimensions: false,
    			object_resizing: false,
    		    document_base_url: '<?php echo $image_baseURL; ?>',
    		    resize: 'both',
    		    image_list: [<?php echo rtrim($fileListJson, ","); ?>],
                link_list: [<?php echo rtrim($linkListJson, ","); ?>],
        		menu: {},
     			toolbar: 'insertfile undo redo | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist | link image table | code'
    			});
    		});
    	</script>
	<?php 
	}
	?>
</head>
<body>

    <div id="wrapper">
<?php
if (isset($_SESSION["user_id"]) AND isset($_SESSION["user_name"]) AND isset($_SESSION["timeout"])) {
?>
        <!-- Navigation -->
        <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="setup.php">Admin Panel</a>
            </div>
            <!-- Top Menu Items -->
            <ul class="nav navbar-right top-nav">
				<li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i>  <?php echo $_SESSION["user_name"]?> <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="../index.php" target="_blank"><i class="fa fa-fw fa-home"></i> View My Site</a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="index.php"><i class="fa fa-sign-out fa-fw"></i> Log Out</a>
                        </li>
                    </ul>
                </li>
             </ul>
            <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
            <div class="collapse navbar-collapse navbar-ex1-collapse">
                <ul class="nav navbar-nav side-nav">
                    <li>
                        <a href="setup.php"><i class="fa fa-fw fa-gear"></i> Setup</a>
                    </li>
                    
                    <li>
                        <a href="aboutus.php"><i class="fa fa-fw fa-file-text"></i> About Us</a>
                    </li>
                    <li>
                        <a href="contactus.php"><i class="fa fa-fw fa-building"></i> Contact Us</a>
                    </li>
					<li>
                        <a href="services.php"><i class="fa fa-fw fa-list"></i> Ebooks</a>
                    </li>
                    <li>
                        <a href="team.php"><i class="fa fa-fw fa-list"></i> Featured Books</a>
                    </li>
                    <li>
                        <a href="customers.php"><i class="fa fa-fw fa-list"></i> New Arrivals</a>
                    </li>
					<li>
                        <a href="slider.php"><i class="fa fa-fw fa-photo"></i> Image Slider</a>
                    </li>
                    <li>
                        <a href="featured.php"><i class="fa fa-fw fa-rocket"></i> Featured</a>
                    </li>
                    <li>
                        <a href="page.php"><i class="fa fa-fw fa-list"></i> Pages</a>
                    </li>
                    <li>
                        <a href="navigation.php?section=<?php echo $navSections[0];?>"><i class="fa fa-fw fa-bars"></i> Navigation</a>
                    </li>
                    <li>
                        <a href="uploads.php"><i class="fa fa-fw fa-folder"></i> Uploads</a>
                    </li>
                    <li>
                        <a href="socialmedia.php"><i class="fa fa-fw fa-facebook-square"></i> Social Media</a>
                    </li>
                    <li>
                        <a href="generalinfo.php"><i class="fa fa-fw fa-file-text"></i> General Info</a>
                    </li>
                    
                    <li>
                        <a href="editor.php"><i class="fa fa-fw fa-css3"></i> Styles</a>
                    </li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </nav>
<?php
} 
?>
        <div id="page-wrapper">
            <div class="container-fluid">
<?php	
//Redirect user if session not set
if (basename($_SERVER['PHP_SELF'])!='index.php') {
    if ($_SESSION['timeout'] + $sessionTimeout * 60 < time()) { //15 minute session timeout
    	if (!$_SESSION["user_name"] AND !$_SESSION["user_id"] AND !$_SESSION['timeout']) {
    		//redirect to login page if not installing
    		if (basename($_SERVER['PHP_SELF'])!='install.php') {
    			//header("Location: index.php");
    			echo "<script>window.location.href='index.php';</script>"; //this works.
    		}
    	}
    echo "<script>window.location.href='index.php';</script>"; //this works.
    }
}
?>