<?php
if(!defined('MyConst')) {
   die('Direct access not permitted');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
    <?php
        include 'db/dbsetup.php'; //contains DB connection string and global variables
        include 'core/functions.php'; //contains functions used on every template
    ?>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="<?php echo $setupDescription;?>">
    <meta name="keywords" content="<?php echo $setupKeywords;?>">
    <meta name="author" content="<?php echo $setupAuthor;?>">

    <title><?php echo $theTitle;?></title>

    <!-- jQuery CDN -->
    <script type="text/javascript" language="javascript" src="//code.jquery.com/jquery-1.10.2.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script type="text/javascript" language="javascript" src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

    <!-- Bootstrap Core CSS -->
    <link rel="stylesheet" type="text/css" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">

    <!-- Template CSS -->
    <link rel="stylesheet" type="text/css" href="css/modern-business.css">
    
    <link rel="stylesheet" type="text/css" href="css/style.css">

    <!-- Custom Fonts -->
    <link rel="stylesheet" type="text/css" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
	
    <?php
        echo $customCss;
    ?>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    
    <?php
    echo $setupHeadercode;

    if (!empty($setupGoogleanalytics)) {
    ?>
        <script type="text/javascript">
            
            var _gaq = _gaq || [];
            _gaq.push(['_setAccount', '<?php echo $setupGoogleanalytics;?>']);
            _gaq.push(['_trackPageview']);
            
            (function() {
              var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
              ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
              var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
            })();
            
        </script>
    <?php 
    }
    ?>

</head>

<body>

<!-- Navigation -->
<nav class="navbar navbar-inverse navbar-fixed-top" id='top' role="navigation">
    <div class="mainContent">
        <div class="row">
            <div class="col-md-7">
                <!-- Start Contact Info -->
                <ul class="contact-details">
                    <li><a href="#"><i class="fa fa-map-marker"></i> <?php echo "Street-2, Los-angel";?></a>
                    </li>
                    <li><a href="#"><i class="fa fa-envelope-o"></i> <?php echo "info@ebook.com";?></a>
                    </li>
                    <li><a href="#"><i class="fa fa-phone"></i><?php echo "+51-56-9865-3252"; ?></a>
                    </li>
                </ul>
                <!-- End Contact Info -->
            </div><!-- .col-md-6 -->
            <div class="col-md-5">
                <!-- Start Social Links -->
                <ul class="social-list">
                    <li>
                        <a class="facebook itl-tooltip" data-placement="bottom" title="Facebook" href="#"><i class="fa fa-facebook"></i></a>
                    </li>
                    
                    <li>
                        <a class="twitter itl-tooltip" data-placement="bottom" title="Twitter" href="#"><i class="fa fa-twitter"></i></a>
                    </li>
                    
                    <li>
                        <a class="google itl-tooltip" data-placement="bottom" title="Google Plus" href="#"><i class="fa fa-google-plus"></i></a>
                    </li>
                                                
                    <li>
                        <a class="instgram itl-tooltip" data-placement="bottom" title="Instagram" href="#"><i class="fa fa-instagram"></i></a>
                    </li>
                                                
                    <li>
                        <a class="skype itl-tooltip" data-placement="bottom" title="Skype" href="#"><i class="fa fa-skype"></i></a>
                    </li>
                </ul>
                <!-- End Social Links -->
            </div><!-- .col-md-6 -->
        </div><!-- .row -->
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <a class="navbar-brand" href="index.php"><?php echo $setupTitle;?></a>
            <input type="text" style="margin-top: 12px; width: 300px; margin-left: 65px;" "name="search_text" id="search_text" placeholder="Search by Book Name"/>
        </div>
        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="topMenu" id="bs-example-navbar-collapse-1">
            
            <?php 
                getNav('Top','true','right');
            ?>
        </div>
        <!-- /.navbar-collapse -->
    </div>
    <!-- /.container -->
</nav>
<?php 
//include 'slider_inc.php'; 
?>