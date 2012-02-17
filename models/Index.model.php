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

class IndexModel extends UniverseModel{
	
	// Generate the Initial Tables
	
	public function GenerateInitialDatabaseTables(){
		
		$connectDB=parent::connectDB();
		
		$createDocListQuery=$connectDB->query("CREATE TABLE DOC_LIST (doc_id int(11) AUTO_INCREMENT, doc_filename varchar(256), doc_total_pages int(11), PRIMARY KEY (doc_id))");
		
		$createPageListQuery=$connectDB->query("CREATE TABLE PAGE_LIST (page_id int(11) AUTO_INCREMENT, doc_id int(11), page_no int(11), page_width int(11), page_height int(11), PRIMARY KEY (page_id), FOREIGN KEY (doc_id) REFERENCES DOC_LIST(doc_id))");
		
		if($createDocListQuery&&$createPageListQuery){
			
			return (bool) 1;
			
			} else { return (bool) 0; }
		}
	
	// Add document to DOC_LIST
	
	public function AddDocList($filename,$pageTotal){
		
		$connectDB=parent::connectDB();
		
		$addDocListQuery=$connectDB->query("INSERT INTO DOC_LIST SET	doc_filename='$filename',
																		doc_total_pages='$pageTotal' ");
		
		if ($addDocListQuery){
			
			$findDocListId=$connectDB->query("SELECT doc_id FROM DOC_LIST WHERE doc_filename='$filename' AND doc_total_pages='$pageTotal' ");
			
			$doc_id=$findDocListId->fetch_array();
			
			return $doc_id[0];
			
			}
		
		return $addDocListQuery;
		
		}
	
	// Create the Word Tabel for the page
	public function CreateWordTable($doc_id){
		
		$connectDB=parent::connectDB();
		
		$doc_id="DOC_".$doc_id;
		
		$createWordTableQuery=$connectDB->query("CREATE TABLE $doc_id (word_id int(11) AUTO_INCREMENT, word varchar(256), page_no int(11), xMin int(11), xMax int(11), yMin int(11), yMax int(11), PRIMARY KEY (word_id)) ");
		
		return $createWordTableQuery;
		
		}
	
	// Remove All Tables
	
	public function ClearAllTables(){
	
		$connectDB=parent::connectDB();
		
		$dropTableQuery=$connectDB->query("DROP TABLE PAGE_LIST");
		$dropTableQuery=$connectDB->query("DROP TABLE DOC_LIST");
		
		$clearAllTablesQuery=$connectDB->query("SHOW TABLES");
		
		if ($clearAllTablesQuery){
			
			while($row=$clearAllTablesQuery->fetch_array()){
				
				$dropTableQuery=$connectDB->query("DROP TABLE $row[0]");
				
				}	
			}
		
		if($dropTableQuery){
			return (bool) 1;
			} else {return (bool) 0;}
		
		}
	
	// Adds a page to the PAGE_LIST table
	
	public function AddPageList($doc_id,$page_no,$page_width,$page_height){
		
		$connectDB = parent::connectDB();
		
		$addPageListQuery = $connectDB->query("INSERT INTO PAGE_LIST SET 	doc_id='$doc_id',
																			page_no='$page_no',
																			page_width='$page_width',
																			page_height='$page_height'");
		
		return $addPageListQuery;
		
		}
	
	public function AddWord($doc_id,$word,$page_no,$xMin,$xMax,$yMin,$yMax){
		
		$connectDB=parent::connectDB();
		
		$doc_id="DOC_".$doc_id;
		
		$addWordQuery=$connectDB->query("INSERT INTO $doc_id SET 	word='$word',
													page_no='$page_no',
													xMin='$xMin',
													xMax='$xMax',
													yMin='$yMin',
													yMax='$yMax'");
		
		return $addWordQuery;
		
		}
	
	};
