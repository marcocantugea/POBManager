<?php

/* 
 * Copyright (C) 2016 MarcoCantu
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.
 */

$indexpage=$config->domain."/".$config->pathServer.""

?>

<div id='cssmenu'>
<ul>
    <li><a href='<?php echo $indexpage;?>/index.php'><span>Home</span></a></li>
   <li class='active has-sub'><a href='#'><span>Management</span></a>
      <ul>
         <li class='has-sub'><a href='#'><span>Database of Peronsal</span></a>
         </li>
            
            <!--<ul>
               <li><a href='#'><span>Sub Product</span></a></li>
               <li class='last'><a href='#'><span>Sub Product</span></a></li>
            </ul>-->
      </ul>
   </li>
   <li class='active has-sub'><a href='#'><span>System</span></a>
       <ul>
           <li class='has-sub'><a href='<?php echo $indexpage;?>/modules/UserManager/UserManager.php'><span>System Users</span></a></li>
       </ul>
   </li>
   <li class='active has-sub'><a href='#'><span>Catalogs</span></a>
       <ul>
           <li class='has-sub'><a href='#'><span>Companies</span></a>
            <li class='has-sub'><a href='#'><span>Shifts</span></a>
            <li class='has-sub'><a href='#'><span>Cabins</span></a>
            <li class='has-sub'><a href='#'><span>Boats</span></a>
       </ul>
   </li>
   <li class='last'><a href='<?php echo $logoutpage;?>'><span>Exit</span></a></li>
</ul>
</div>
