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

include_once(BASE_DIR."models/Universe.model.php");

class Search extends Universe{
	
	
	// Primary Search Function
	public function Find($wordToBeFound){
		
		$connectDB = parent::connectDB();
		
		$docIdResult = $this->GetDocList();

		for($i=0;$i<count($docIdResult);$i++){
			
			$tableName = 'DOC_'.$docIdResult[$i][0];
			
			$wordResult = $this->LocateWordInTable($tableName,$wordToBeFound);
			
			if(isset($wordResult)){
				$finalResult[$docIdResult[$i][0]] = $wordResult;
				}
			
			}
		
		return $finalResult;
		
		}
	
	/* Get the Doc information for use in the search query */
	public function GetDocInfo($doc_id){
		
		$connectDB = parent::connectDB();
		
		$infoQuery = $connectDB->query("SELECT * FROM DOC_LIST WHERE doc_id='$doc_id'");
		
		$docResult = $infoQuery->fetch_array();
		
		return $docResult;
		
		}
	
	/* Return the Doc list for search */
	protected function GetDocList(){
		
		$connectDB=parent::connectDB();
		
		$docIdQuery=$connectDB->query("SELECT doc_id FROM DOC_LIST");
		
		if ($docIdQuery){
			while($docRow = $docIdQuery->fetch_array()){
				$docIdResult[]=$docRow;
				}
			}
		
		return $docIdResult;
		
		}


	/* Regular expression split of the search String more analysis */
	public function ProcessSearchString($String){
		
		$String = trim($String);
		
		$String = preg_split('/[\/,-\s\t]+/',$String);

		foreach ($String as $a){
			
			$a = parent::sanitizeString(strtolower(trim($a)));
			
			}
			
		return $String;
		}

	// Find all instances of a word in the table 
	private function LocateWordInTable($tableName,$wordToBeFound){
		
		$connectDB = parent::connectDB();
		
		$wordSearchQuery = $connectDB->query("SELECT * FROM $tableName WHERE word LIKE '$wordToBeFound'");

		if ($wordSearchQuery){
				
			while($wordRow = $wordSearchQuery->fetch_array()){
				$wordResult[] = $wordRow;
				}
			}
				
		return $wordResult;
		}
	
	// Get word row using the word_id
	private function GetWordFromId($tableName,$wordId){
		
		$connectDB = parent::connectDB();
		
		$wordSearchQuery = $connectDB->query("SELECT * FROM $tableName WHERE word_id ='$wordId'");
		
		if ($wordSearchQuery){
			$word = $wordSearchQuery->fetch_array();
			}
		
		if(isset($word)){
			return $word;
			} else { return 0; }
		
		}
	
	};
