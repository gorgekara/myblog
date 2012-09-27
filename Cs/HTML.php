<?php

require_once "Session.php";

class Cs_HTML
{
	
	public function htmlStart() {

		ob_start();
		$session = new Cs_Session;
		
		$get_title = mysql_query("SELECT * FROM options WHERE OptionName LIKE 'Site Title'") or die("Custom error!");
		$gt = mysql_fetch_array($get_title);

		echo "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">";
		echo "<html xmlns=\"http://www.w3.org/1999/xhtml\">";
		echo "<head>";
			echo "<title>" .$gt['Value']. "</title>";
			
			echo "<script src=\"Cs/External/nicEdit.js\" type=\"text/javascript\"></script>";
			echo "<script type=\"text/javascript\">bkLib.onDomLoaded(nicEditors.allTextAreas);</script>";
			echo "<script type=\"text/javascript\" src=\"Cs/External/jquery.js\"></script>";
			echo "<script type=\"text/javascript\" src=\"Cs/External/jquery-ui-1.8.23.custom.min.js\"></script>";
			
			echo "<link type=\"text/css\" href=\"Styles/ui-lightness/jquery-ui-1.8.23.custom.css\" rel=\"stylesheet\" />";
			echo "<link href=\"Styles/main.css\" type=\"text/css\" media=\"screen and (max-device-width: 1366px)\" rel=\"stylesheet\"/>";
			echo "<link href=\"Styles/small.css\" type=\"text/css\" media=\"screen and (max-width: 795px)\" rel=\"stylesheet\"/>"; 
			echo "<link href=\"Styles/really_small.css\" type=\"text/css\" media=\"screen and (max-width: 605px)\" rel=\"stylesheet\"/>"; 
			echo "<link href=\"Styles/ultra_small.css\" type=\"text/css\" media=\"screen and (max-width: 450px)\" rel=\"stylesheet\"/>";
			
			echo "</head>";
		echo "<body>";
		
		if($session->checkSes() != 1) {
			echo "	<div id=\"Popup\">
					<a id=\"popupClose\"><img src=\"Images/cross.png\" alt=\"close\"></a>
					<div class=\"popup_header\">Welcome to " .$gt['Value']. "</div>
					<div class=\"popup_tagline\">Please register if you want the full experience!</div>   
				</div> 
				<div id=\"bgPopup\"></div>";
			$_SESSION['visitor'] = 1;
		}		
		
	echo "</div>";
	}

	public function htmlEnd() {
		$get_footer = mysql_query("SELECT * FROM options WHERE OptionName LIKE 'Footer text'") or die("Custom error!");
		$gf = mysql_fetch_array($get_footer);
		// Script for animating Sign Up/Sing In sidebar 
		?>
		
		<script type="text/javascript">
			$(function() {
			var $sidebar   = $(".register_box"), 
				$window    = $(window),
				offset     = $sidebar.offset(),
				topPadding = 15;

			$window.scroll(function() {
				if ($window.scrollTop() > offset.top) {
					$sidebar.stop().animate({
						marginTop: $window.scrollTop() - offset.top + topPadding
					});
				} else {
					$sidebar.stop().animate({
						marginTop: 0
					});
				}
			});
			
			});
			
			function disablePopup(){
				if ($("#bgPopup").data("state")==1){
					$("#bgPopup").fadeOut("medium");
					$("#Popup").fadeOut("medium");
					$("#bgPopup").data("state",0);
				}
			}
			$(document).ready(function() {
			   $("#bgPopup").data("state",0);
				var winw = $(window).width();
				var winh = $(window).height();
				var popw = $('#Popup').width();
				var poph = $('#Popup').height();
				$("#Popup").css({
			        "position" : "absolute",
			        "top" : winh/2-poph/2,
			        "left" : winw/2-popw/2
				});
				//IE6
				$("#bgPopup").css({
					"height": winh	
				});
				if($("#bgPopup").data("state")==0){
					$("#bgPopup").css({
						"opacity": "0.7"
					});
					$("#bgPopup").fadeIn("medium");
					$("#Popup").fadeIn("medium");
					$("#bgPopup").data("state",1);
				} 
			   $("#popupClose").click(function(){
				   	disablePopup();
			   });
			   $(document).keypress(function(e){
					if(e.keyCode==27) {
						disablePopup();	
					}
				});
				$(".option_tabs").tabs();
});

//Recenter the popup on resize - Thanks @Dan Harvey [http://www.danharvey.com.au/]
$(window).resize(function() {
centerPopup();
});



			
		</script>
		
		<?php	echo "<div class=\"footer\">" .$gf['Value']. "</div>";
		echo "</body>";
		echo "</html>";
	}

	//	Menu for admin
	public function htmlAdminMenu() {
		echo "<div class=\"admin_menu\">";
			// Set menu items - on the left is the title and on the right is the link
			$admin_menu = array(
					'Home' => 'admin.php',
					'Add post' => 'post.php?s=create',
					'Edit/Remove posts' => 'post.php?s=modify',
					'Options' => 'options.php',
					'Log out' => 'logout.php'
				);		
			foreach($admin_menu as $item => $link) {
				echo "<div class=\"admin_menu_item\"><a href=\"" .$link. "\">" .$item. "</a></div>";	
			}
		echo "</div>";
	}

	public function htmlHead() {
		$get_title = mysql_query("SELECT * FROM options WHERE OptionName LIKE 'Site Title'") or die("Custom error!");
		$gt = mysql_fetch_array($get_title);

		$get_tagline = mysql_query("SELECT * FROM options WHERE OptionName LIKE 'Blog tagline'") or die("Custom error!");
		$gtg = mysql_fetch_array($get_tagline);
		
		$get_image = mysql_query("SELECT * FROM options WHERE OptionName LIKE 'Blog image'") or die("Custom error!");
		$gi = mysql_fetch_array($get_image);

		echo "<div class=\"header\">";
			echo "<div class=\"logo\"><a href=\"index.php\"><img class=\"logo\" src=\"" .$gi['Value']. "\" alt=\"logo\" /></a></div>";
			echo "<div class=\"header_title\">" .$gt['Value']. "</div>";
			echo "<div class=\"header_tagline\">" .$gtg['Value']. "</div>";
			echo "<div class=\"menu\">";
				echo "<div class=\"menu_item\"><a href=\"index.php\">Home</a></div>";
				$query = mysql_query("SELECT * FROM category") or die("Database error!");
				while($q = mysql_fetch_array($query)) {
					if($q['CategoryID'] != 1) {
						echo "<div class=\"menu_item\"><a href=\"category.php?id=" .$q['CategoryID']. "\">" .$q['Categories']. "</a></div>";
					}
				}
			echo "</div>";
		echo "</div>";
	}

	public function cleaner() {
		echo "<div class=\"cleaner\"></div>";
	}

	public function sidebar($element) {
		foreach($element as $key => $value) {

			// If search is visible
			if($value == 'search') {

				echo "<ul class=\"side_latest_posts\">";
					echo "<div class=\"side_head\">Search</div>";

					echo "<form action=\"search.php\" method=\"get\" class=\"search_box\">";
						echo "<input type=\"text\" placeholder=\"Search..\" name=\"query\" />";
					echo "</form>";
				echo "</ul>";
				echo "<div class=\"space\"></div>";
			}

			// If related posts are needed
			else if(is_numeric($value)) {
				$clean_pid = mysql_real_escape_string($value);
				$query = mysql_query("SELECT * FROM post WHERE post.PostID LIKE '" .$clean_pid. "'") or die("Custom error!");
				$q = mysql_fetch_array($query);

				$search = mysql_query("SELECT * FROM post WHERE post.CategoryID LIKE '" .$q['CategoryID']. "' LIMIT 5") or die("Custom error!");				
					echo "<ul class=\"side_latest_posts\">";
						echo "<div class=\"side_head\">Similar posts:</div>";
						echo (mysql_num_rows($search) == 0) ? '<div class=\'note_text\'>No similar post are found..</div>' : '';
						while($qs = mysql_fetch_array($search)) {
							if ($clean_pid != $qs['PostID']) { 
								$chars = 25; 
						        $text = $qs['PostTitle']." "; 
						        $text = substr($text,0,$chars); 
						        $text = substr($text,0,strrpos($text,' ')); 

						        $text = $text."...";

									echo "<a href=\"post.php?pid=" .$qs['PostID']. "\">
											<div style=\"
												background:#D1EEEE; 
												width:218px; height:40px; 
												margin:10px 0 0 0; 
												background-position:top center;
												border-radius:3px;
												-web-border-radius:3px;
												-moz-border-radius:3px;\">
												<span class=\"similar_posts\">" .$text. "</span>
											</div>
										</a>";
							}
						}
					echo "</ul>";
					echo "<div class=\"space\"></div>";
			}

			// If recent posts are shown in the sidebar
			else if($value == 'recent_posts') {
				$query = mysql_query("SELECT * FROM post ORDER BY post.PostID DESC LIMIT 5") or die("Custom error!");
				
				if(mysql_num_rows($query) == 0) {
					echo "<div class=\"note_text\">There are no posts!</div>";
				}
				else {
					echo "<ul class=\"side_latest_posts\">";
						echo "<div class=\"side_head\">Latest posts</div>";
						while($q = mysql_fetch_array($query)) {
								echo "<li><a href=\"post.php?pid=" .$q['PostID']. "\">" .$q['PostTitle']. "</a></li>";
						}
					echo "</ul>";
					echo "<div class=\"space\"></div>";
				}
			}

			// If recent comments option is enabled
			else if($value == 'recent_comments') {
				$query = mysql_query("SELECT * FROM post, commenting, comments WHERE post.PostID LIKE commenting.PostID AND commenting.CommentID LIKE comments.CommentID ORDER BY comments.CommentID DESC LIMIT 5") or die("Custom error!");
				echo "<ul class=\"side_latest_posts\">";
					if(mysql_num_rows($query) == 0) {

						echo "<div class=\"side_head\">Latest comments</div>";

							echo "<div class=\"note_text\">Sorry, no comments are posted!</div>";
					}
					else {
						
							echo "<div class=\"side_head\">Latest comments</div>";
							while($q = mysql_fetch_array($query)) {
								$chars = 27; 
						        $text = $q['Comment']." "; 
						        $text = substr($text,0,$chars); 
						        $text = substr($text,0,strrpos($text,' ')); 
						        $text = $text."...";
								echo "<li><a href=\"post.php?pid=" .$q['PostID']. "\">" .$text. "</li></a>";	
							}
					}
				echo "</ul>";
				echo "<div class=\"space\"></div>";
			}

			else if($value == 'popular') {

				echo "<ul class=\"side_latest_posts\">";
					echo "<div class=\"side_head\">Popular posts</div>";
					$query = mysql_query("SELECT COUNT(commenting.PostID) AS Count,post.PostID,post.PostTitle FROM post,commenting,comments WHERE post.PostID LIKE commenting.PostID AND commenting.CommentID LIKE comments.CommentID GROUP BY commenting.PostID ORDER BY Count DESC
") or die("Custom error!");
					
					while($q = mysql_fetch_array($query)) {
						echo "<li>";
							echo "<a href=\"post.php?pid=" .$q['PostID']. "\">" .$q['PostTitle']. "</a>";
						echo "</li>";
					}
				echo "</ul>";
				echo "<div class=\"space\"></div>";

			}
			// If tags are enabled
			else if($value == 'tag_cloud') {

				echo "<ul class=\"side_latest_posts\">";
					echo "<div class=\"side_head\">Tag cloud</div>";

					$tags = mysql_query("SELECT Tags FROM post");
					
					while($tagrow = mysql_fetch_assoc($tags)) {
						$tagarr[] = implode(' ', $tagrow);
					}
					
					foreach($tagarr as $i => $value) {
						$result2 = implode(' ', $tagarr);
					}

					$result3 = explode(' ', $result2);
					$result3 = array_unique($result3);

					foreach($result3 as $key => $value) {
							echo " <a class=\"sidetag\" href=\"search.php?query=" .$result3[$key]."\">#".$result3[$key]."</a> ";
					}
				echo "</ul>";
				echo "<div class=\"space\"></div>";
			}

			else if($value == 'register') {
				echo "<div class=\"register_box\">";
					if(!isset($_SESSION['username'])) {
						echo "<form action=\"register.php\" method=\"post\" class=\"register_form\">";
							echo "<input type=\"submit\" value=\"Sign Up Now!\" />";
						echo "</form>";

						echo "<br />";
						echo "<div class=\"side_head\">Or sign in..</div>";

						echo "<form action=\"login.php\" method=\"post\" class=\"login_form\">";
							echo "<input type=\"text\" name=\"username\" placeholder=\"username\" />";
							echo "<input type=\"password\" name=\"password\" placeholder=\"password\" />";
							echo "<input type=\"submit\" class=\"submit_button\" value=\"Sign In\" />";
							echo "<div style=\"clear:both\"></div>";
						echo "</form>";
					}
					else {
						echo "<div class=\"side_head\">Welcome, " . $_SESSION['username'] . "</div>";

						// Options button
						echo "	<div class=\"user_buttons\">
									<a href=\"view.php\">
										<img src=\"Images/view.png\" alt=\"View\" />
										View
									</a>
									<a href=\"publish.php\">
										<img src=\"Images/post.png\" alt=\"Post\" />
										Post
									</a>
									<a href=\"options.php\">
										<img src=\"Images/cog.png\" alt=\"Options\" />
										Options
									</a>
									<a href=\"profile.php?u=" .$_SESSION['username']. "\">
										<img src=\"Images/profile.png\" alt=\"Profile\" />
										Profile
									</a>
								</div>";

						$check_mod = mysql_query("SELECT * FROM usernames WHERE usernames.UserID LIKE '" .$_SESSION['userid']. "' AND usernames.Admin = 1") or die("Custom error!");
						$check_admin = mysql_query("SELECT * FROM usernames WHERE usernames.UserID LIKE '" .$_SESSION['userid']. "' AND usernames.Admin = 2") or die("Custom error!");
 
						if(mysql_num_rows($check_mod) != 0) {
							echo "	<div class=\"user_admin\">
										<div>
											&nbsp;
										</div>
										<a href=\"admin.php\">
											Manage users
										</a>
										<a href=\"admin_category.php\">
											Categories
										</a>
									</div>";	
						}
						else if(mysql_num_rows($check_admin) != 0) {
							echo "	<div class=\"user_admin\">
										<div>
											&nbsp;
										</div>
										<a href=\"admin.php\">
											Manage users
										</a>
										<a href=\"profile.php?u=" .$_SESSION['username']. "\">
											Categories
										</a>
									</div>";
						}

						// Log out button
						echo "<form action=\"login.php\" class=\"logout_box\" method=\"post\">
								<input type=\"hidden\" value=\"logout\" name=\"logout\"/>
								<input type=\"submit\" value=\"Sign Out &rarr;\" class=\"log_out\" />
							</form>";
					}
					
				echo "</div>";
			}

			else if($value == 'twitter') { ?>

				<script charset="utf-8" src="http://widgets.twimg.com/j/2/widget.js"></script>
				<script>
				new TWTR.Widget({
				  version: 2,
				  type: 'profile',
				  rpp: 5,
				  interval: 30000,
				  width: 230,
				  height: 300,
				  theme: {
				    shell: {
				      background: '#ffffff',
				      color: '#545454'
				    },
				    tweets: {
				      background: '#ffffff',
				      color: '#545454',
				      links: '#0099cc'
				    }
				  },
				  features: {
				    scrollbar: false,
				    loop: false,
				    live: false,
				    behavior: 'all'
				  }
				}).render().setUser('dark4p').start();
				</script>

			<?php }
		}
	}

	public function timeNow($time,$date) {
		 if(date('d-m-Y') == $date) {
			$justhour = explode(':',$time);
			$hour_now = date('H');
			$timetag = $hour_now - $justhour[0];

            if($timetag == 0) {
                $timetag = $time;
            }

            else if($timetag == 1) {
                $timetag = $timetag . " hour ago";
            }

            else if($timetag > 1) {
                $timetag = $timetag . " hours ago";
            }
        }

        else {
            $timetag = $date;
        }

        return $timetag;
	}
	
	public function getOptionsForm() {
		$form = new Cs_Forms;
		$options = mysql_query("SELECT * FROM options") or die("Custom error!");
		$form->addFormStart("options.php", "post", "registration_form");
		echo "<table>";
		
			while($o = mysql_fetch_array($options)) {				
				echo "<tr>";
					echo "<td>";
						echo $o['OptionName'];
					echo "</td>";
					echo "<td>";
						$form->addInputValue("text", urlencode($o['OptionName']), $o['Value']);
					echo "</td>";
				echo "</tr>";
			}
			$form->addInputValue("hidden", "option_change", "changed");	
		echo "</table>";
		echo "<br />";
		$form->addInput("submit", "Modify");
		$form->addFormEnd();
	}

}

?>
