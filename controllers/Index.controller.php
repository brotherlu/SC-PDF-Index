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
include_once(BASE_DIR."models/Index.model.php");

class IndexController extends UniverseController {
	
	// Function that reads all directories defined and returns the list all PDF documents in them
	public function GetPDFFilelist($PDFSOURCES){
		
		$i=0;

		while(isset($PDFSOURCES[$i])){
		
		// Strip the last slash if it exists
		if(substr($PDFSOURCES[$i],-1)=='/')
			$PDFSOURCES[$i]=substr($PDFSOURCES[$i],0,-1);
		
		// Start developing the directory heirarchy
		if(is_dir($PDFSOURCES[$i])){
			// open the directory
			if ($dir = opendir($PDFSOURCES[$i])){
				// Get the directory listing to start processing
				while (($file = readdir($dir)) !== false) {
					// unset the identity directory pointers
					if($file=='.'||$file=='..')
						unset($file);
					
					// now check if the $file is set we can now start processing
					if(isset($file)){
						// if the entry is a directory we place it into the PDFSOURCES array
						if(is_dir($PDFSOURCES[$i].'/'.$file) && $file!='.' && $file!='..')
							$PDFSOURCES[]=$PDFSOURCES[$i].'/'.$file;
						else {
							// else if it is a file then we read it and check if it is a PDF file
							$fileLocation = $PDFSOURCES[$i].'/'.$file;
							$finfo = finfo_open(FILEINFO_MIME_TYPE);
							$fileMIMEtype = finfo_file($finfo,$fileLocation);
							if($fileMIMEtype=='application/pdf')
								$fileList[] = $PDFSOURCES[$i].'/'.$file;
						}
					}
				}
			} else
				die("This folder can not be opened! Check you have read privileges");
		} else { // If the Directory is wrong
			die($PDFSOURCES[$i].' is NOT a valid directory');
			}
		
		$i++; // increment to the next element
		
		}
		
		if(isset($fileList))
			return $fileList;
		else
			return (bool)0;
	}
	
	public function RenderReindexDiv(){
		?>
		
		<div id="ReindexBlock">
		<button id="ReindexButton" onClick=reindex(True)>
			Reindex
		</button>
		
		</div>
		
		<?php
		}
	
	public function CleanWordOfNonLettres($word){
	
		$charactersToDrop = array('(',')','/','\\',':',',','.','0','1','2','3','4','5','6','7','8','9');
		$word = str_replace($charactersToDrop,' ', $word);
		$word = trim($word);
		return $word;
	
	}

	}
