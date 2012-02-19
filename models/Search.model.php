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

class SearchModel extends UniverseModel{
	
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
			
		if (!isset($finalResult))
			$finalResult = (bool) 0;
		
		return $finalResult;
		}
	
	/* Get the Doc information for use in the search query */
	public function GetDocInfo($doc_id){
		
		$connectDB = parent::connectDB();
		
		$infoQuery = $connectDB->query("SELECT * FROM DOC_LIST WHERE doc_id='$doc_id'");
		
		$docResult = $infoQuery->fetch_array();
		
		return $docResult;
		
		}
	
	/* Find if the word is in the blacklist */
	public function CheckBlacklist($word){
		
		$NewBanList = array_merge(parent::$PRI_BAN_LIST,$GLOBALS['EXTRA_BAN_LIST']);
		$word = strtolower($word);
		foreach ($NewBanList as $a){
			$a = strtolower($a);
			if ($word == $a){
				$val = true;
				break;
				} else { $val = false; }
			}
		return $val;
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
			
			if (isset($wordResult))
				return $wordResult;
			} else { return (bool) 0; }
		}
	
	// Get word row using the word_id
	public function GetWordFromId($tableName,$wordId){
		
		$connectDB = parent::connectDB();
		
		$tableName = 'DOC_'.$tableName;

		$wordSearchQuery = $connectDB->query("SELECT * FROM $tableName WHERE word_id ='$wordId'");
		
		if ($wordSearchQuery){
			$word = $wordSearchQuery->fetch_array();
			}
		
		if(isset($word)){
			return $word;
			} else { return (bool) 0; }
		
		}
	
	};
