<?php

//All the php below draws cast and crew information from the aggregatedfiles.csv file 
//and outputs it as the cast and crew lists on the film page. It works by 
//1. establishing a variable for the film title respective to the film
//2. Accessing the file "aggregatedfiles.csv", which contains ALL the cast and crew information. 
//3. based on the film title, identifying the cast in filmdatacsv and writing the cast table
//4. based on the film title, writing the crew based on the same method as step 3.


//Establish variable for film title
	define("Raw_Title", get_the_title());
	$cleantitle = preg_replace("/\s\([0-9]{4}\)/", "", Raw_Title);
	//The if-else statement below is a kluge solution to a deeper problem. "Lola" is the film title,
    //but there are other instances of "Lola" in the filmdatacsv, causing a problem displaying cast and crew. 
    //If possible, nomenclature for film cast and crew lists should be cleaned up in aggregatedfiles.csv. If a new aggregatedfiles.csv is uploaded, it 
    //MUST RETAIN THE SAME NAME. Otherwise, it will not detect the file and will result in the "Cast and Crew not found" message.
	if (str_contains($cleantitle, "Lola")):
		$cleantitle = ($cleantitle . " _");
	else:
		$cleantitle = $cleantitle;
	endif;


//establish file path to place where "aggregatedfiles.csv" lives
$file_path = "/home/customer/www/mexicanrockcinema.com/public_html/wp-content/uploads/2023/04/aggregatedfiles.csv";

$file = fopen($file_path, 'r');

$csv = fread($file, filesize($file_path));
fclose($file);

				// access the post with the film data and store it all raw in the $csv variable.
				//$csv = get_post_field('post_content', 528, $context = 'raw');
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
			//endwhile;
		//endif;


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
