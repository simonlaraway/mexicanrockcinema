Question for browne: this code was a test to see if I could get the text in the Processor
field to show up in the film page (it was in the film page template.) When I try to run it, 
the page won't load when I try to open the film.

Note: get_the_title() in php gets the title of the actual movie you are on.

//The code below works

<h3>Director</h3>
[if related_cast]
<ul class="director">
	[each related_cast]
	<li>
		{@related_cast.post_tag}
		<a href="{@related_cast.permalink}">{@related_cast.post_title}</a>
	</li>
	[/each]
</ul>
[/if]

[if blurb]
<div class="blurb" style="background-color:#d8dde3">
	<h3>About "{@post_title}"</h3>
	<p>{@film_blurb}</p>
</div>

[if screening_location]
<div class="screening_location" style="background-color:#e8dde3">
	<h3>Screening Locations</h3>
	<a href="{@screening_location.permalink}">{@screening_location}</a> <p>{@screening_dates}</p>
</div>
[/if]




	
	
	
<?php

// Set up the arguments for the WP_Query object
$args = array(
    'post_type' => 'Processor',
    'name' => 'FilmDataCSV',	
);


//Establish constant for title
define("Raw_Title", get_the_title());
$cleantitle = preg_replace("/\([0-9]{4}\)/", "", Raw_Title);


// Create a new WP_Query object
$query = new WP_query($args);
	if ($query->have_posts()): 
		while ($query->have_posts()):
			$query->the_post();
			
			// access the post with the film data and store it all raw in the $csv variable.
			$csv = get_post_field('post_content', 528, $context = 'raw');
			
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
	    endwhile;
    endif;
?>



<?php
//write the crew
	function crewwrite($stringclean) {
		//Write the crew table
		echo "<h3>Crew</h3>";		
		$separated_string = preg_split("/(<br>|[\r\n]+)/", $stringclean);
		$separated_string = array_filter($separated_string);
		foreach($separated_string as $string):
			//check if string in array has a comma. If it does not, assign it to be the credit header. 	
			if (strpos($string, ',') === false):
				$crewtitle = $string;
			elseif (str_contains($string, "_crew_")):
				continue;
			else:
				$subarray = explode(",", $string);
				$truename = $subarray[0];
					foreach($subarray as $subitem):
						if (str_contains($subitem, "https://www.imdb.com")):
							$href = $subitem;
						endif;
					endforeach;
			?>

			<div class="crew">
			<?php echo '<div class="crew">' . $crewtitle . "<a href=$href$truename </a>" . "<br>" . '</div>'; ?>
			</div>
			<?php

			endif;
		endforeach;
	}
?>
	
	
<?php
function castwrite($stringclean) {
	echo "<br>";
	//Write the cast table	
	echo "<h3>Cast</h3>";
	$separated_string = preg_split("/(<br>|[\r\n]+)/", $stringclean);
	$separated_string = array_filter($separated_string);
	foreach($separated_string as $string):
		if (str_contains($string, "_cast,")):
			continue;
		else:
			$subarray = explode(",", $string);
			$truename = $subarray[0];
				foreach($subarray as $subitem):
					//$subitem = array_filter($subitem);
					if (str_contains($subitem, "https://www.imdb.com")):
						$href = $subitem;
					endif;
				endforeach;
			?>

			<div class="crew">
			<?php echo '<div class="cast">' . "<a href=$href$truename </a>" . "<br>" . '</div>'; ?>
			</div>
			<?php

		endif;
	endforeach;
}



	?>
	<br>
	<?php


//I'm going to have to close the loop here fyi 
//Fix the data not found thing. I think it will need to call a function?



?>

	
	
	
	<?php 

///////////////////////////////////////////////DETRITUS//////////////////////////////////////////////////////////



//get and write the screening info
// function getscreeninginfo() {

// 	$screeningargs = array(
// 		'post_type' => 'Processor',
// 		'name' => 'ScreeningData',	
// 	);

// 	$newquery = new WP_query($screeningargs);
// 		if ($newquery->have_posts()):
// 			while ($newquery->have_posts()):
// 				$newquery->the_post();
// 				$newcsv = get_post_field('post_content', 862, $context = 'raw');
// 				if (str_contains($newcsv, $cleantitle)):
// 					$screeningstringarray = explode("###", $newcsv);
// 					foreach($screeningstringarray as $string): 
// 						if (str_contains($string, $cleantitle)):
// 							$stringclean = nl2br($string);
// 							//echo $stringclean;
// 							$date_pattern = "/Date:(.*)\n/";
// 							$length_pattern = "/Screening Length:\s+(.+)/";
// 								if (preg_match($date_pattern, $stringclean, $date_matches)):
// 									$screendate = $date_matches[1];
// 									Echo "Premier Date: " . ucfirst($screendate) . "</p>";
// 								endif;
// 								if (preg_match($length_pattern, $stringclean, $length_matches)):
// 									$screenlength = $length_matches[1];
// 										echo '<p>' . 'Screening Length: ' .  $screenlength . '</p>';
// 								endif;
// 						endif;
// 					endforeach;
// 				elseif (strpos($newcsv, $cleantitle) === false):
// 					echo '<p>' . 'Screening Dates Not Found' . '</p>';
// 				endif;
// 			endwhile;
// 		endif;
// }



// </div>
	
	