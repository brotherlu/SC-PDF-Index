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
</div> <!-- Main Div ending tag -->
<div id="footer">
<?php

$querytime = number_format(microtime(true)-START_TIME,3);

?>
&copy;<?php echo date('Y'); ?> <b>PHPoppler</b> <?php echo REV; ?> <i>GPLv2</i> <?php echo "<span class=quetime>Query Time: $querytime s</span>"; ?>
</div>

</div><!-- Wrapper End Tag -->
</body>
</html>
