<nav class="sidebar-nav">
    <ul class="nav"> 
    <li class="nav-title">
        Main Menu
    </li>
	<?
	$rs_menu_parrent = $comfunc->menu_list ( "0", $ses_group_id );
	while ( $arr_menu_parrent = $rs_menu_parrent->FetchRow () ) {
		
		echo "<li class=\"nav-item nav-dropdown\">";
		if($arr_menu_parrent["menu_name"] == "Dasbor"){
			echo "<a class=\"nav-link\" href=\"" . $arr_menu_parrent ['menu_link'] . "\"><i class=\"".$arr_menu_parrent ['menu_icon']."\" style=\"color: black;\"></i>".$arr_menu_parrent ['menu_name']."</a>";
		}else{
			echo "<a class=\"nav-link nav-dropdown-toggle\" href=\"#\"><i class=\"".$arr_menu_parrent ['menu_icon']."\" style=\"color: black;\"></i>".$arr_menu_parrent ['menu_name']."</a>";
		}
		echo "<ul class=\"nav-dropdown-items\">";
		$rs_menu_child = $comfunc->menu_list ( $arr_menu_parrent ['menu_id'], $ses_group_id );
		while ( $arr_menu_child = $rs_menu_child->FetchRow () ) {
			echo "<li class=\"nav-item\">";
			echo "<a class=\"nav-link\" href=\"" . $arr_menu_child ['menu_link'] . "\"><i class=\"".$arr_menu_child ['menu_icon']."\" style=\"color: white;\"></i> " . $arr_menu_child ['menu_name'] . "</a>";
			
		}
		echo "</ul>";
		echo "</li>";
	}
	?>
	</ul>
</nav>