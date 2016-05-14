<!doctype html>
<html class="no-js" lang="en-GB">
    <head>
        <meta charset="utf-8">
        
        <link rel="dns-prefetch" href="//ajax.googleapis.com">
        <link rel="dns-prefetch" href="//player.vimeo.com">
        
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        
        <title>COMX</title>
        
        <meta name="description" content="University of Gloucestershire COMX Exhibition">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        
        <link rel="stylesheet" href="css/main.css">

        <script src="js/vendor/modernizr-2.8.3.min.js"></script>
    </head>
    <body>
		<?php include_once ("includes/cookies.php"); ?>
		
		<main id="page" class="page-wrapper">
            
            <?php include ("includes/header.php"); ?>
            
            <div id="page-content">
                <div class="inner-wrap content-block">
                    <div class="content">
                        <h1>Gallery</h1>
						
						<!--styled with flexbox-->
						<div id="gallery" data-featherlight-gallery data-featherlight-filter="div">
							<?php
								$galleryPath = "img/gallery/";
								$photos = glob("{$galleryPath}*.jpg");
								
								foreach($photos as $photos) {
									echo "<div><img data-featherlight=". $photos ." src=". $photos ." alt=\"COMX Photo\"></div>";
								}
							?>
							
							<!--format for the photos - use the paginator class if you want to paginate the photos-->
							<!--<div><img src="#" alt="COMX Photo"></div>-->
						</div>
						
                    </div>
                </div>
            </div>
			
            <?php include ("includes/footer.php"); ?>
			
		</main>
        
        <!--mobile navigation is off side-->
		<?php include ("includes/mobilenav.php"); ?>
		
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
        <script>window.jQuery || document.write('<script src="js/vendor/jquery-1.11.2.min.js"><\/script>')</script>
        
        <script src="js/plugins.js"></script>
        <script src="js/main.js"></script>
		
		<script>//$(".gallery").featherlightGallery();</script>
    
    </body>
</html>