<?php

//The purpose of this code is to draw the cast and crew lists from the "processors" pod and populate them automatically in the films page. 
//On the site, this code currently lives in the Film Template, accessible by navigating from Pods Admin(in the wordpress admin interface)->Pod Templates->Film Template
//Sorry it's so ugly, but it works.




//Establish constant for film title
	define("Raw_Title", get_the_title());
	$cleantitle = preg_replace("/\s\([0-9]{4}\)/", "", Raw_Title);
	

$castarray = array();


global $castarray;

// Set up the arguments for the CAST AND CREW WP_Query object
	$args = array(
		'post_type' => 'Processor',
		'name' => 'FilmDataCSV',	
	);


// Create a new WP_Query object
	$query = new WP_query($args);
		if ($query->have_posts()): 
			while ($query->have_posts()):
				$query->the_post();

				// access the post with the film data and store it all raw in the $csv variable.
				$csv = get_post_field('post_content', 528, $context = 'raw');
				if (strpos($csv, $cleantitle) !== false):
					//create an array with every chunk of film data; both cast and crew lists.			
					$stringarray = explode("###", $csv);
					foreach($stringarray as $string): 
						if (str_contains($string, $cleantitle)):
							$stringclean = nl2br($string);
							if (str_contains($stringclean, "_crew_")):
								crewwrite($stringclean);
							endif;
							if (str_contains($stringclean, "_cast")):
								castwrite($stringclean);
							endif;
						endif;
					endforeach;
				elseif (strpos($csv, $cleantitle) === false):
					echo '<p>' . 'Cast and crew information not found' . '</p>';
				endif;
			endwhile;
		endif;


//Write the crew table. 
		function crewwrite($stringclean) {
//$stringclean = raw chunk of csv lines with all the crew data for the film
		echo "<div class='crew-wrapper'><h3>Crew</h3>";		
			$separated_string = preg_split("/(<br>|[\r\n]+)/", $stringclean);
			$separated_string = array_filter($separated_string);
			foreach($separated_string as $string):
//check if string in array has a comma. If it does not, assign it to be the crew position. 	
				if (strpos($string, ',') === false):
					$crewtitle = $string;
				elseif (str_contains($string, "_crew_")):
					continue;
				else:
					$subarray = explode(",", $string);
					$truename = $subarray[0];
						foreach($subarray as $subitem):
							if (str_contains($subitem, "https://www.imdb.com")):
								$hrefcrew = $subitem;
							endif;
						endforeach;
					$crewarray = [];
				?>
				<ul class="crewsub">
					<li> <?php echo $crewtitle . "<a href=$hrefcrew$truename </a>"; ?> </li>
				</ul>
				<?php

				endif;
			endforeach;
		echo "</div>";
	echo "</div>";
		}
					

//Write the cast table		

function castwrite($stringclean){
	echo "<div class='castandcrew-wrapper'>";
	echo "<div class='cast-wrapper'><h3>Cast</h3>";
		$separated_string = preg_split("/(<br>|[\r\n]+)/", $stringclean);
		foreach($separated_string as $string):
		if (str_contains($string, "_cast,")): 
				continue;	
		else:
				$subarray = explode(",", $string);
				$truename = $subarray[0];
					foreach($subarray as $subitem):
						if (str_contains($subitem, "https://www.imdb.com")):
							$href = $subitem;
						elseif (empty($subitem)):
							continue;
						endif;
					endforeach;

				if (strlen($truename) > 6):
				?><div class="castsub"><?php
					echo "<a href=$href$truename </a>"; 
				?></div><?php
				endif;

			endif;
		endforeach;
	echo "</div>";
	}

?>		
