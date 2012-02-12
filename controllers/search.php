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

if(!$_GET['search']['term']==""){

	if(isset($_GET['search']['reindex'])){

		if($_GET['search']['reindex']=='on'){
		
			include_once(BASE_DIR."models/Index.model.php");
		
			include_once(BASE_DIR."controllers/reindex.php");
		
		}

	}	

	$finder=new Search();
	
	echo '<h1>For the search Query: '.$_GET['search']['term'].'</h1>';
	
	$searchStringArray = $finder->ProcessSearchString($_GET['search']['term']);
	
	// get the word data and save the word ids
	// check if any results from the second search results are next to the the first search results
	
	foreach ($searchStringArray as $a){
	
		$blackListedResult = $finder->CheckBlacklist($a);
	
		if ($blackListedResult)
			echo $a." is blacklisted<br/>";
	
		if (!$blackListedResult){

			echo '<p class="wordTitle">Word: '.$a.'</p>';
			
			$FindResult = $finder->Find($a);
			
			if ($FindResult){
				
				foreach (array_keys($FindResult) as $b){
					
					$doc = $finder->GetDocInfo($b);
					
					echo "<h3>For this Doc $doc[doc_filename]</h3>";
					
					echo "<h3>The results are</h3>";
					
					foreach ($FindResult[$b] as $c){
						echo 'Page: '.$c['page_no'].'<br/>';
					}
				}
		} else { echo "<p>Not Found</p>"; }
		
		}
	}	
	
} else {echo "Please Input a Search String!";}

include_once(BASE_DIR."views/footer.inc.php");
