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
 
include_once("CFG.ini");
?>

<html>
<head>
<title>SpaceConcordia Docs Search</title>
<script type="text/javascript" src="libs/script.js"></script>
<link REL="stylesheet" type="text/css" href="libs/style.css" />
</head>
<body>
	<center><h1>SC Search</h1></center>
	<form name="scsearch" method="GET" action="controllers/search.php">
	<center><input type="text" name="search[term]">
	<input type="submit" value="Search"></center>
	<center><input type="checkbox" name="search[reindex]">Reindex</center>
	</form>
</body>
</html>
