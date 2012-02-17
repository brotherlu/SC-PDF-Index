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
include_once(BASE_DIR."models/Search.model.php");

class SearchController extends UniverseController {
	
	public function SearchQuery(){
		
		if(!isset($_GET['search']['term'])){
			echo "None";
		} else {
			echo $_GET['search']['term'];
			}

	}
	
	public function RenderSearchForm(){
		?>
		<form name="scsearch" method="GET" action="<?php echo BASE_URI; ?>controllers/search.php">
		<center><input class="searchbox" type="text" name="search[term]">
		<input class="searchbutton" type="submit" value="Search"></center>
		</form>
	<?php
	}
	
	public function RenderHomeButton(){
		?>
		<div id="homebutton">
		<a href="<?php echo BASE_URI; ?>"> 
		<img src="<?php echo LOGO_LOCATION_HEADER ?>">
		</a>
		</div>
		<?php
		}
	}
