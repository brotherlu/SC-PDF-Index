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

function reindex(){

	if(is_dir(PDF_SOURCE)){
		if($dh=opendir(PDF_SOURCE)){
			while (($file = readdir($dh)) !== false) {
				$fileList[]=$file;
			}
			closedir($dh);
			}
		}
	
	for($i=2;$i<count($fileList);$i++){
		
		$content = system("pdftotext $fileList[$i] -",$retval);
		echo "<pre>".$retval."</pre>";
		
		}
	
/*

	$index=new Index();
	
	$index->ClearAllTables();
	
	$index->GenerateNewIndex();
	
	*/

};

reindex();
