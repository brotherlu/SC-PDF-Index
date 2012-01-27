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

/* Primary Ban List of words to be removed from the index */

$PRI_BAN_LIST = array('I','a','be','is','are','could','would','should','the','can');
$CONJUGATION_LIST = array('for','and','nor','but','or','yet','so','after','although','as','if','much','soon','though','because','before','time','even','lest','once','only','since','that','than','till','unless','until','when','whenever','while','where','wherever','both','either','neither','whether');

/* Universe Core Class for Database connections */

class Universe{
	
	protected function connectDB(){
		
		$connectDB=new mysqli(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
		
		if ($connectDB->connect_errno){
			
			printf('Could not Connect : %s/n',$connectDB->connect_error);
			
			exit();
			
			}
		
		return $connectDB;
		}
	
	/* Sanitize Strings */
	protected function sanitizeString($string){
		
		return filter_var($string,FILTER_SANITIZE_STRING);
		
	}
	
	};
