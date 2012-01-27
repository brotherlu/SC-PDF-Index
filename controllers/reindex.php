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

// Function to make sure we dont count any blank pages
	
function GetNumberOfPages($xml){
	$i = 0;
	while ($xml->body->doc->page[$i]->word[0] != ""){
		$i++;
		}
	return $i;
	}

function CleanWordOfNonLettres($word){
	
	$charactersToDrop=array('(',')','/','\\',':',',','.','0','1','2','3','4','5','6','7','8','9');
	$word=str_replace($charactersToDrop, '', $word);
	return $word;
	
	}

// Primary reindex function

function reindex(){

	// Open the Folder

	if(is_dir(PDF_SOURCE)){
		if($dh=opendir(PDF_SOURCE)){
			while (($file = readdir($dh)) !== false) {
				$fileList[] = $file;
			}
			closedir($dh);
			} else {die("Can not Open Directory, maybe Permissions");};
		} else {die("The Folder does not Exist");}
	
	//	Create the Index Object

	$index=new Index();
			
	$index->ClearAllTables();
			
	$index->GenerateInitialDatabaseTables();
			
	// Check if there are files to be indexed
		
	if($fileList && $fileList[2]){
	
	for($i=2;$i<count($fileList);$i++){ 
		
		// Capture XML data from PDF using poppler and cat, stdout did not work
		// outputs to a /tmp/ file
		
		$content = shell_exec('pdftotext -bbox '.PDF_SOURCE.$fileList[$i].' /tmp/pdftotext.tmp');
			
		$content = shell_exec('cat /tmp/pdftotext.tmp');
			
		$xml = simplexml_load_string($content);
	
		$docTitle = $xml->head->title;
		$docAuthour = $xml->head->meta[0]->attributes()->content;
		$totalPageCount = GetNumberOfPages($xml);
			
		// Start Generating new Data
			
		$docId=$index->AddDocList($fileList[$i],$docTitle,$docAuthour,$totalPageCount);
		
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
					
					$pattern = '([a-zA-Z]+)';
					
					if(preg_match($pattern,$word)){
					
						$word = CleanWordOfNonLettres($word);
					
						$xMin = $xml->body->doc->page[$j]->word[$k]->attributes()->xMin;
						$xMax = $xml->body->doc->page[$j]->word[$k]->attributes()->xMax;
						$yMin = $xml->body->doc->page[$j]->word[$k]->attributes()->yMin;
						$yMax = $xml->body->doc->page[$j]->word[$k]->attributes()->yMax;
					
						$index->AddWord($docId,$word,$j+1,$xMin,$xMax,$yMin,$yMax);
					}
				}	
			}
		} else {die("DOC_LIST Table Creation failed!");}
		} 
	} else {echo "There are no files to be indexed in this folder! Please Try Again!";}


};

reindex();
