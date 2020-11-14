<?php
if(!defined('MyConst')) {
   die('Direct access not permitted');
}
?>

    <section id="bottom">
            <div class="footerarea">
                <div class="row">
                <div class="col-md-3 col-sm-6">
                    <div class="widget">
                        <ul id="menu-company" class="uldecoration">
                            <h3>Company</h3>
                            <li id="menu-item-232" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-232"><a href="#">About Us</a></li>
                            <li id="menu-item-238" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-238"><a href="#">We are hiring</a></li>
                            <li id="menu-item-235" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-235"><a href="#">Meet the team</a></li>
                            <li id="menu-item-234" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-234"><a href="#">Copyright</a></li>
                            <li id="menu-item-237" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-237"><a href="#">Terms of use</a></li>
                            <li id="menu-item-236" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-236"><a href="#">Privacy policy</a></li>
                            <li id="menu-item-233" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-233"><a href="#">Contact Us</a></li>
                        </ul>                    
                    </div>    
                </div><!--/.col-md-3-->

                <div class="col-md-3 col-sm-6">
                    <div class="widget">
                        <ul id="menu-support" class="uldecoration">
                            <h3>News</h3>
                            <li id="menu-item-251" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-251"><a href="#">Faq</a></li>
                            <li id="menu-item-250" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-250"><a href="#">Documentation</a></li>
                            <li id="menu-item-252" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-252"><a href="#">Refund policy</a></li>
                        </ul>                    
                    </div>    
                </div><!--/.col-md-3-->

                <div class="col-md-3 col-sm-6">
                    <div class="widget">
                        <ul id="menu-developers" class="uldecoration">
                            <h3>Category</h3>
                            <li id="menu-item-255" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-255"><a href="#">Web Development</a></li>
                            <li id="menu-item-253" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-253"><a href="#">Email Marketing</a></li>
                            <li id="menu-item-254" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-254"><a href="#">SEO Marketing</a></li>
                        </ul>                    
                    </div>    
                </div><!--/.col-md-3-->

                <div class="col-md-3 col-sm-6">
                    <div class="widget">
                        <ul id="menu-our-partners" class="uldecoration">
                            <h3>Our Partners</h3>
                            <li id="menu-item-258" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-258"><a href="#">Adipisicing Elit</a></li>
                            <li id="menu-item-257" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-257"><a href="#">Eiusmod</a></li>
                            <li id="menu-item-256" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-256"><a href="#">Tempor</a></li>
                        </ul>                    
                    </div>    
                </div><!--/.col-md-3-->
            </div>
        </div>
    </section><!--/#bottom-->


        <!-- Footer -->
        <footer>
            <div class="footer" id='footer'>
                
				<?php 
                    getNav('Footer','false','left');
                ?>

            </div>
            <?php
            //echo "<div class='row' id='socialmedia'>";
                //echo "<div class='col-md-12'>";
    				//include 'socialmedia_inc.php';
                //echo "</div>";
            //echo "</div>";
            ?>
            <div class="row copyright">
                <div class="col-lg-6 text-left">
                    <p>Copyright &copy; <?php echo str_replace(':8080','',$_SERVER['HTTP_HOST']."&nbsp;".date("Y"));?></p>
                </div>
				<div class="col-lg-6 text-right"><a href="//sayat.me/teklynk" target="_blank"><img style="max-width:60px;" src="core/teklynk_logo.png" border="0"/></a></div>
            </div>
        </footer>

    </div>
    <!-- /.container -->

    <!-- jQuery CDN -->
    <!--<script type="text/javascript" language="javascript" src="//code.jquery.com/jquery-1.10.2.min.js"></script> -->

    <!-- Bootstrap Core JavaScript -->
    <!--<script type="text/javascript" language="javascript" src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>-->

    <!-- Script to Activate the Carousel -->
    <script type="text/javascript" language="javascript">
    $('.carousel').carousel({
        interval: 5000 //changes the speed
    })
    </script>

</body>

</html>
<?php
    //close all db connections
    mysqli_close($con);
    die();
?>