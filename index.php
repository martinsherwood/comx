<?php require("includes/config.php"); ?>

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
		<!--Developed by Martin Sherwood-->
		<?php include_once ("includes/cookies.php"); ?>
		
		<main id="home" class="page-wrapper">
            
            <?php include ("includes/header.php"); ?>
            
			<div id="banner" role="banner">
				<ul class="course-reel">
					<li>
                        <span>Image 01</span>
                        <div><h3>Web Technologies</h3></div>
                    </li>
                    
					<li>
                        <span>Image 02</span>
                        <div><h3>Amazing Games</h3></div>
                    </li>
                    
                    <li>
                        <span>Image 03</span>
                        <div><h3>Innovative Ideas</h3></div>
                    </li>
                    
					<li>
                        <span>Image 04</span>
                        <div><h3>Business Solutions</h3></div>
                    </li>
                    
					<li>
                        <span>Image 05</span>
                        <div><h3>Intelligent Systems</h3></div>
                    </li>
                    
					<li>
                        <span>Image 06</span>
                        <div><h3>Digital Forensics</h3></div>
                    </li>
				</ul>
                <i id="go-down" class="fa fa-angle-down"></i>
			</div>

			<div id="intro" class="inner-wrap content-block">
                <div class="content">
                    <h1>What is COMX?</h1>
                    <p>COMX is an end of year student exhibition for students of the School of Computing &amp; Technology, held at the University of Gloucestershire, the aim is to showcase the design and technical skills of the students. The exhibition has been well established for 12 years and attracts a wide audience. It is free to attend and can guarantee an insightful and fun day out for all ages.</p>
					
					<div class="video">
						<!--if you use youtube, embed using the iframe api for async loading: https://developers.google.com/youtube/iframe_api_reference. And prefetch the domain at the top-->
						<iframe src="https://player.vimeo.com/video/150803285?title=0&byline=0&portrait=0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
					</div>
                </div>
			</div>
            
            <div id="showcase" class="inner-wrap content-block grey">
                <div class="content">
                    <h1>Project showcase</h1>
                    <div class="sc-items">
						<?php
							try {
								$stmt = $db->query("SELECT projectTitle, projectSlug, projectLogo FROM projects ORDER BY RAND() LIMIT 3");
								while($row = $stmt->fetch()) {
									echo '<div class="showcase-item">';
									echo	'<div class="showcase-thumb">';
									echo		'<img src=img/projects/logos/' . $row['projectLogo'] . ' alt="' . $row['projectTitle'] . '">';
									echo		'<div class="showcase-overlay">';
									echo 			'<h4><a class="showcase-link" href="'.$row['projectSlug'].'">'.$row['projectTitle'].'</a></h4>';
									echo		'</div>';
									echo	'</div>';
									echo '</div>';
								}

							} catch(PDOException $e) {
								echo $e->getMessage();
							}
                        ?>
                    </div><!--/sc-items-->
                </div>
            </div>
            
            <div id="location-map" class="inner-wrap content-block">
                <div class="content">
                    <h1>Where and when</h1>
                    <div class="map-wrapper">
                        <div id="map-canvas">
                        </div>
                    </div>
					<span class="directions">
						<i class="fa fa-location-arrow"></i> Fullwood House, Park Campus, Cheltenham | <a href="https://maps.google.com/?daddr=The+Park+Cheltenham+Gloucestershire+GL50+2RH+United+Kingdom" target="_blank">Directions</a>
					</span>
					<span class="time">
						<i class="fa fa-calendar-o"></i> 4th June 2016, 10am - 4pm | <a href="comx.ics">Add to Calendar</a>
					</span>
                </div>
            </div>
			
			<div id="contact-form" class="inner-wrap content-block grey">
				<div class="content">
					<h1>Get in touch</h1>
					<form class="contact-form" method="post" action="#">
                        <div class="details">
							<label for="name">Name</label>
                            <input type="text" id="name" name="name" placeholder="Your name">
							<p class="no-name error">Oops, you missed your name!</p>
							
							<label for="email">Email address</label>
                            <input type="email" id="email" name="email" placeholder="Your email">
                            <p class="no-email error">We'll need your email address.</p>
                        </div>
                        
						<label for="text">Message</label>
                        <textarea id="text" name="text" class="text" placeholder="Type your message in here..." rows="4"></textarea>
                        <p class="no-text error">Whoops, you've missed your message!</p>
                        
                        <input role="button" type="submit" name="submit" class="submit" value="Send"/>
                    </form>
				</div>
			</div>
			
			<div id="partnerships" class="inner-wrap content-block">
				<div class="content">
                    <h1>Partners</h1>
					<div class="partners">
						<div><img src="img/partners/cgi.svg" alt="CGI Group" title="CGI Group"></div>
						<div><img src="img/partners/bcs.svg" alt="The Chartered Institute for IT" title="The Chartered Institute for IT"></div>
						<div><img src="img/partners/iet.svg" alt="The Institution of Engineering and Technology" title="The Institution of Engineering and Technology"></div>
						<div><img src="img/partners/uog.svg" alt="University of Gloucestershire" title="University of Gloucestershire"></div>
					</div>
                </div>
			</div>
			
            <?php include ("includes/footer.php"); ?>
			
		</main>
        
        <!--mobile navigation is off side-->
		<?php include ("includes/mobilenav.php"); ?>
		
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
        <script>window.jQuery || document.write('<script src="js/vendor/jquery-1.11.2.min.js"><\/script>')</script>
        <script src="http://maps.googleapis.com/maps/api/js?key=AIzaSyC6n-3I8KfH6ReeERae16W5M8B1QtzjPGc"></script>
        
        <script src="js/plugins.js"></script>
        <script src="js/main.js"></script>
    
        <script>
            $(function(userMap) {
                var parkCampus = new google.maps.LatLng(51.886626, -2.088908);
				
                displayMap();
				
				function displayMap() {
					var map = new google.maps.Map(document.getElementById("map-canvas"), {
						zoom: 16,
						center: parkCampus,
						disableDefaultUI: true,
                        mapTypeControl: true,
                        mapTypeControlOptions: {
                            style: google.maps.MapTypeControlStyle.HORIZONTAL_BAR
                        },
					});

					var dropPin = "img/location-marker.png";
					var marker = new google.maps.Marker({
						position: {lat: 51.886626, lng: -2.088908},
						map: map,
						icon: dropPin
					});
				}
            });
        </script>
    
    </body>
</html>
