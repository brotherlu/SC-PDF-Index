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
	
	public function Find($wordToBeFound){
		
		$connectDB = parent::connectDB();
		
		$docIdResult = $this->GetDocList();

		// Feature to be worked on 'Smart' String Analysis 
		
		$words = $this->ProcessSearchString($wordToBeFound);

		for($i=0;$i<count($docIdResult);$i++){
			
			$tableName = 'DOC_'.$docIdResult[$i][0];
			
			$wordSearchQuery = $connectDB->query("SELECT * FROM $tableName WHERE word LIKE '$wordToBeFound'");
			
			if ($wordSearchQuery){
				
				while($wordRow = $wordSearchQuery->fetch_array()){
					$wordResult[]=$wordRow;
					}
				}
			
			if(isset($wordResult)){
				$finalResult[$docIdResult[$i][0]] = $wordResult;
				}
			
			}
		
		return $finalResult;
		
		}
	
	public function GetDocInfo($doc_id){
		
		$connectDB = parent::connectDB();
		
		$infoQuery = $connectDB->query("SELECT * FROM DOC_LIST WHERE doc_id='$doc_id'");
		
		$docResult = $infoQuery->fetch_array();
		
		return $docResult;
		
		}
	
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


	/* Regular expression split of the search String */
	protected function ProcessSearchString($String){
		
		$String = preg_split('/[\/,-\s\t]+/',$String);
		
		print_r($String);

		return $String;
		}

	};
