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

include_once(BASE_DIR."controllers/Universe.controller.php");
include_once(BASE_DIR."models/Search.model.php");

class SearchController extends UniverseController {
	
	public function SearchQuery(){
		
		if(!isset($_GET['search']['term'])){
			echo "None";
		} else {
			echo $_GET['search']['term'];
			}

	}
	
	public function RenderSearchForm(){
		?>
		<form name="scsearch" method="GET" action="<?php echo BASE_URI; ?>controllers/search.php">
		<center><input class="searchbox" type="text" name="search[term]">
		<input class="searchbutton" type="submit" value="Search"></center>
		</form>
	<?php
	}
	
	public function RenderHomeButton(){
		?>
		<div id="homebutton">
		<a href="<?php echo BASE_URI; ?>"> 
		<img src="<?php echo LOGO_LOCATION_HEADER ?>">
		</a>
		</div>
		<?php
		}
	
	public function RenderResults($word,$FindResult){
		
		$finder = new SearchModel();

		echo '<div class=wordDiv>';
		echo '<p class="wordTitle">Word: '.$word.'</p>';
		
		if($FindResult){
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

					for($j=-4;$j<5;$j++){
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
		} else { echo "<h2>No Instances Found</h2>"; }
		echo '</div>';
	} // End RenderResult Method



	}
