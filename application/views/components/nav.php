<?php

    $menu_list = "<ul>";
    foreach($menu_arr as $controller_id => $controller_data){
        
        $cn_class = "";
        if($controller_name == $controller_data['controller_uri']){
            $cn_class = "active";
        }
        
        $menu_list .= "<li class='has-sub ".$cn_class."'>
				<a href='javascript:;' class=''>
				<i class='fa ".$controller_data['controller_icon']." fa-fw'></i> <span class='menu-text'>".$controller_data['controller_title']."</span>
				<span class='arrow'></span>
				</a>";
        
        //create sub menu
        $menu_list .= "<ul class='sub'>";
        //check of we have any action for this controller
        if(isset($controller_data['actions']) and is_array($controller_data['actions'])){
            
            foreach($controller_data['actions'] as $action){
                    
                $class = "";
                if($current_action_id == $action['action_id']){
                    $class = "current";
                }
                $menu_list .= "<li class='".$class."'><a class='' href='".site_url($controller_data['controller_uri']."/".$action['action_uri'])."'><span class='sub-menu-text'>".$action['action_title']."</span></a></li>";
                
            }
        }
            
        $menu_list .= "</ul>";
        //end of sub menu
                
        $menu_list .= "</li>";
    }
    $menu_list .= "</ul>";
    

?>
<!-- SIDEBAR -->
<div id="sidebar" class="sidebar">
	<div class="sidebar-menu nav-collapse">
		<div class="divide-20"></div>
		<!-- SEARCH BAR -->
		<div id="search-bar">
			<input class="search" type="text" placeholder="Search"><i class="fa fa-search search-icon"></i>
		</div>
		<!-- /SEARCH BAR -->
		
		<!-- SIDEBAR QUICK-LAUNCH -->
		<!-- <div id="quicklaunch">
		<!-- /SIDEBAR QUICK-LAUNCH -->
		
		<!-- SIDEBAR MENU -->
		<?php echo $menu_list; ?>
		<!-- /SIDEBAR MENU -->
	</div>
</div>
<!-- /SIDEBAR -->