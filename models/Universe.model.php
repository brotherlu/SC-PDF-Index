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

class Universe{
	
	protected function connectDB(){
		
		$connectDB=new mysqli(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
		
		if ($connectDB->connect_errno){
			
			printf('Could not Connect : %s/n',$connectDB->connect_error);
			
			exit();
			
			}
		
		return $connectDB;
		}
	};
