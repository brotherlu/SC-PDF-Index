<?php

/*
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston,
 * MA 02110-1301, USA.
 * 
 */

include_once("../CFG.ini");

include_once(BASE_DIR."models/Search.model.php");
include_once(BASE_DIR."controllers/Search.controller.php");

include_once(BASE_DIR."views/head.inc.php");

SearchController::RenderHomeButton();

if(!$_GET['search']['term']==""){

	$finder=new SearchModel();
	
	echo '<h2>Query: '.$_GET['search']['term'].'</h2>';
	
	$searchStringArray = $finder->ProcessSearchString($_GET['search']['term']);
	
	// get the word data and save the word ids
	// check if any results from the second search results are next to the the first search results
	
	foreach ($searchStringArray as $a){
	
		$blackListedResult = $finder->CheckBlacklist($a);
	
		if ($blackListedResult) {
			echo '<div class=wordDiv>';
			echo '<p class="wordTitle">Word: \''.$a.'\' is blacklisted!</p>';
			echo '</div>';
		}
		
		if (!$blackListedResult){
			echo '<div class=wordDiv>';
			echo '<p class="wordTitle">Word: '.$a.'</p>';
			
			$FindResult = $finder->Find($a);
			
			if ($FindResult){
				
				foreach (array_keys($FindResult) as $b){
					
					$wordHits=count($FindResult[$b]);
					
					$doc = $finder->GetDocInfo($b);
					$docfile = preg_split('/\//', $doc['doc_filename']);
					echo '<div class=docDiv>';
					echo '<div class=docDivFilename onclick=showResults(this)><p class=docPFilename><span class=bold>[+]</span> '.end($docfile) .'
						(<span class=bold>'.$wordHits.'</span> Hits) <span class=bold>[+]</span></p></div>';
					echo '<div class=resultDiv>';
					
					for ($i=0;$i<count($FindResult[$b]);$i++){

						$word_id = (int)$FindResult[$b][$i]['word_id'];

						

						// Outputing the search term with adjacent words;

						echo '<p class="hit ';
						echo ($i%2==0) ? 'hiteven' : 'hitodd';
						echo '"><b>Page: '.$FindResult[$b][$i]['page_no'].'</b>';

						echo '<span class=wordString>... ';
						
						// Unsetting the $wordString if it was used previously

						if(isset($wordString))
							unset($wordString);

						// Starting a for loop to get all ajacent words to develop the phrase to be outputed

						for($j=-3;$j<4;$j++){
							$word_id_new = $word_id + $j;
							$word_new = $finder->GetWordFromId($b,$word_id_new);
							if($j==0)
								echo ' <b>'.$word_new['word'].'</b> ';
							else
								echo ' '.$word_new['word'].' ';
						}
							
						echo ' ...</span></p>';
					}
					echo '</div>';
					echo '</div>';
				}
			echo '</div>';
			} else { echo "<h2>No Instances Found</h2>"; }
		
		}
	}	
	
} else {echo "<center><h1>Please Input a Search String!</h1></center>";}

include_once(BASE_DIR."views/footer.inc.php");
