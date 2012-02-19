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

// Time in seconds for indexing documents
// Change this if the database does not seem complete

ini_set('max_execution_time',300);

include_once('../CFG.ini');
include_once(BASE_DIR."controllers/Index.controller.php");

// Primary reindex function

function reindex(){

	// Open the Folder

	$fileList = IndexController::GetPDFFilelist($GLOBALS['PDFSOURCES']);
	
	//	Create the Index Object

	$index=new IndexModel();
			
	$index->ClearAllTables();
			
	$index->GenerateInitialDatabaseTables();
			
	// Check if there are files to be indexed
	
	if(isset($fileList)){
	
	$progress=0;
	$progressBarIncrement = 100/count($fileList);

	for($i=0;$i<count($fileList);$i++){ 
		
		// Capture XML data from PDF using poppler 
		echo "<h1>$fileList[$i]</h1>"; // for testing
		// $progress=($progress+$progressBarIncrement);
		// echo 'Progress: '.(int)$progress;
		// BUG where if '-' is used stdout won't work
		$content = shell_exec('pdftotext -bbox -q '.$fileList[$i].' /dev/stdout');
		
		// Some PDF files will generate ASCII code 24 elements that would crash the parser
		// this is fixed by regex replacing them with a blank space which will be trashed later
		// again by regex
		$content = preg_replace('/\/','',$content);
		
		$xml = simplexml_load_string($content);
		
		if ($xml!=false){
		
			$totalPageCount = count($xml->body->doc->page);
				
			// Start Generating new Data
				
			$docId=$index->AddDocList($fileList[$i],$totalPageCount);
			
			if(isset($docId)){
			
				// Create Word Table for word parsing
				
				if($index->CreateWordTable($docId)){$index->CreateWordTable($docId);} else {die("Could not create Word table!");}
			
				for($j = 0;$j < $totalPageCount;$j++){
					
					// Get Page Information
					
					$page_width = $xml->body->doc->page[$j]->attributes()->width;
					$page_height = $xml->body->doc->page[$j]->attributes()->height;
					
					$index->AddPageList($docId,$j+1,$page_width,$page_height);
					
					// Word Time
					
					$wordCount = count($xml->body->doc->page[$j]->word);
					
					for ($k = 0;$k < $wordCount;$k++){
						
						$word = $xml->body->doc->page[$j]->word[$k];
						
						// preg match pattern
						$pattern = '([a-zA-Z]+)';
						
						if(preg_match($pattern,$word)){
						
							$word = strtolower(IndexController::CleanWordOfNonLettres($word));
						
							$xMin = $xml->body->doc->page[$j]->word[$k]->attributes()->xMin;
							$xMax = $xml->body->doc->page[$j]->word[$k]->attributes()->xMax;
							$yMin = $xml->body->doc->page[$j]->word[$k]->attributes()->yMin;
							$yMax = $xml->body->doc->page[$j]->word[$k]->attributes()->yMax;
						
							$index->AddWord($docId,$word,$j+1,$xMin,$xMax,$yMin,$yMax);
						}
					}	
				}
			} else {die("DOC_LIST Table Creation failed!");}
			} else {echo ("Could not convert $fileList[$i], check if malformed or readable");}
		}
	} else {die("There are no files to be indexed in this folder! Please Try Again!");}

};

reindex();
