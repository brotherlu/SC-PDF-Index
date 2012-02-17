<!--
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

-->

<head>
<title>SpaceConcordia Docs Search: <?php SearchController::SearchQuery(); ?></title>
<script type="text/javascript" src="<?php echo BASE_URI;?>libs/jquery.js"></script> <!-- JQuery v 1.7.1-->
<script type="text/javascript" src="<?php echo BASE_URI;?>libs/script.js"></script>
<link REL="stylesheet" type="text/css" href="<?php echo BASE_URI;?>libs/style.css" />
</head>
<body>
<div id="wrapper">

<div id="header">
<?php SearchController::RenderSearchForm(); ?>
</div>
<div id="main">
