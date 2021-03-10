<?php

$session = Yii::$app->session;
$session['user_logintype'];
$menu_data_array = array();
use backend\models\Shortcut;
  use yii\helpers\Url;

 if($session['user_logintype']=='T1')
 {
$menu_data_array[0] = array('one', 'Dashboard', Yii::$app -> homeUrl, '<i class="fa fa-dashboard"></i>', 'index');
/*$menu_data_array[4] = array('one', 'Home Management', Yii::$app->homeUrl.'?r=home-management/index', '<i class="fa fa-fw fa-building"></i>', 'index');
*/$menu_data_array[5] = array('one', 'Service Type', Yii::$app->homeUrl.'?r=category-management/index', '<i class="fa fa-sign-in"></i>', 'index');
  $menu_data_array[10]=array('more','Dropdown Management','#','<i class="fa fa-fw fa-building"></i>','brand-mapping','service-module');
  $menu_data_array[10]['sub'][0]=array('Brand Mapping',Yii::$app->homeUrl.'?r=brand-mapping/index','<i class="fa fa-fw fa-plus"></i>','brand-mapping','brand-mapping');
  $menu_data_array[10]['sub'][1]=array('Service Module',Yii::$app->homeUrl.'?r=service-module/index','<i class="fa fa-fw fa-plus"></i>','service-module','service-module');

$menu_data_array[11] = array('one', 'Service Api List', Yii::$app->homeUrl.'?r=status-module/index', '<i class="fa fa-plus-square"></i>', 'index');
$menu_data_array[12] = array('one', 'Technician Master', Yii::$app->homeUrl.'?r=technician-master/index', '<i class="fa fa-plus-square"></i>', 'index');

$menu_data_array[6] = array('one', 'Executive Master', Yii::$app->homeUrl.'?r=executive-master/index', '<i class="fa fa-plus-square" aria-hidden="true"></i>', 'index');
$menu_data_array[7] = array('one', 'Customer master', Yii::$app->homeUrl.'?r=customer-master/index', '<i class="fa fa-plus-square" aria-hidden="true"></i>', 'index');
$menu_data_array[8] = array('one', 'Task Management', Yii::$app->homeUrl.'?r=task-management/index', '<i class="fa fa-tasks" aria-hidden="true"></i>', 'index');
$menu_data_array[9] = array('one', 'Color System', Yii::$app->homeUrl.'?r=colorsystem/index', '<i class="fa fa-th-large"></i>', 'index');

/*$menu_data_array[10] = array('one', 'APP Background Screen', Yii::$app->homeUrl.'?r=flash-screen/index', '<i class="fa fa-picture-o" aria-hidden="true"></i>', 'index');
*//*$menu_data_array[8] = array('one', 'APP Slider Screen', Yii::$app->homeUrl.'?r=flash-screen/index', '<i class="fa fa fa-bolt"></i>', 'index');*/
/*$menu_data_array[1]=array('more','Management','#','<i class="fa fa-fw fa-building"></i>','swim-service-centre');
$menu_data_array[1]['sub'][0]=array('Category Management',Yii::$app->homeUrl.'?r=category-management/index','<i class="fa fa-fw fa-plus"></i>','swim-service-centre','create');
$menu_data_array[1]['sub'][1]=array('Videos Management',Yii::$app->homeUrl.'?r=video-management/index','<i class="fa fa-fw fa-plus"></i>','swim-service-centre','swim-service-centre');*/
}
$html_menu_out = '';
$controler_url_id = Yii::$app ->controller->id;
$active_url_id = Yii::$app ->controller->action->id;
$html_menu_out_tmp = $controler_url_id . "/" . $active_url_id;
//$html_menu_out .= $html_menu_out_tmp;
foreach ($menu_data_array as $one_ig => $one_menus) {//echo "<pre>";print_r($one_menus);
	if (count($one_menus) > 0) {
		if ($one_menus[0] == 'more') {
			$isselct = '';
			if ($controler_url_id == $one_menus[4]) {$isselct = 'active';
			}//echo $isselct;
			$html_menu_out2 = '<ul class="treeview-menu">';
			foreach ($one_menus['sub'] as $one_submenus) {
				$isactive = '';
				if ($active_url_id == "index") {
					if ($active_url_id == $one_submenus[4] || $controler_url_id == $one_submenus[4]) {
						$isactive = 'class="active"';
						if ($isselct == '') {
							$isselct = 'active';
						}
					}
				} else {
					if ($active_url_id == $one_submenus[4]) {$isactive = 'class="active"';
					}
				}
				$html_menu_out2 .= '<li ' . $isactive . '><a href="' . $one_submenus[1] . '">' . $one_submenus[2] . '' . $one_submenus[0] . '</a></li>';
			}
			$html_menu_out1 = '<li class="treeview ' . $isselct . '"><a href="#">' . $one_menus[3] . ' <span>' . $one_menus[1] . '</span><i class="fa fa-angle-left pull-right"></i></a>';
			$html_menu_out2 .= '</ul></li>';
			$isselct = '';
			$html_menu_out .= $html_menu_out1 . $html_menu_out2;
		} elseif ($one_menus[0] == 'one') {
			$isselct = '';
			if ($active_url_id == "index") {
				if ($controler_url_id == $one_menus[4] || $active_url_id == $one_menus[4]) {$isselct = 'active';
				}
			} else {
				if ($html_menu_out_tmp == $one_menus[4]) {$isselct = 'active';
				}
				//if($controler_url_id==$one_menus[4]){$isselct='active';}
			}
			$html_menu_out .= '<li class="treeview ' . $isselct . '"> 
		              <a href="' . $one_menus[2] . '">' . $one_menus[3] . ' <span>' . $one_menus[1] . '</span></a></li>';
		}
	}
}
?>
<aside class="main-sidebar">
<!-- sidebar: style can be found in sidebar.less -->
<section class="sidebar">
<!-- Sidebar user panel
<div class="user-panel">
<div class="pull-left image">
<img src="../dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
</div>
<div class="pull-left info">
<p>Alexander Pierce</p>
<a href="#"><i class="fa fa-circle text-success"></i> Online</a>
</div>
</div>-->
<!-- search form
<form action="#" method="get" class="sidebar-form">
<div class="input-group">
<input type="text" name="q" class="form-control" placeholder="Search...">
<span class="input-group-btn">
<button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i></button>
</span>
</div>
</form>
<!-- /.search form -->
<!-- sidebar menu: : style can be found in sidebar.less -->
<ul class="sidebar-menu">
<?php echo $html_menu_out; ?>

</ul>
</section>
<input type="text"  placeholder="Search Here" name="Search" id="shortcode" style="    width: 96%;
    border-radius: 5px;
    text-align: center;
    margin-left: 6px;
    	">
    
    <br>
    <br>

<?php
$shortcut=Shortcut::find()->where(['status'=>'1'])->asArray()->all();	
								if(!empty($shortcut))
								{
									foreach ($shortcut as $key => $value)
									{
										$productlist_col_val[] = array('value' => $value['name'],'value1' => $value['link']);
									}
									$productlist_col_json = json_encode($productlist_col_val);
								}
								else
								{
									$productlist_col_json="";
								}
?>
<script type="text/javascript" src="<?php echo Url::base(); ?>/boot/bootstrap3-typeahead.js"></script>
<script type="text/javascript" src="<?php echo Url::base(); ?>/boot/bootstrap3-typeahead.min.js"></script>
<div class="quickinof">
<span style="width: 100%;
    float: left;
    border: 1px solid;
    text-align: center;
    background:<?php  echo $_SESSION['color_code'];?>;
    color: white;"
>Quick Info</span>
</div>
 <br>
 <div class="quickinof2">
 <h5 style="text-align: center;"><i class="fa fa-fw fa-user"></i>User  Name : <span ><?php echo ucfirst($_SESSION['user_name']); ?></span></h5>
 <h5 style="text-align: center;"><i class="fa fa-info-circle" aria-hidden="true"></i> Server IP: <span ><?php echo $_SERVER['REMOTE_ADDR']; ?></span></h5>
 <h5 style="text-align: center;"><i class="fa fa-info-circle" aria-hidden="true"></i> Version: <span >1.0</span></h5>
</div>

 <script>
	
	var subjects = <?= $productlist_col_json; ?>;
    $("#shortcode").typeahead({
      minLength: 1,
      delay: 100,
	  	source: subjects,
  		autoSelect: true,
 		displayText: function(item)
 		{
 	 		return item.value;	
 		},
  		afterSelect: function(item) {
			var base_url="<?php echo Url::base();?>"+"/index.php?r="+item.value1;
  			window.location.href = base_url;	
  		}
	});


</script>
<!-- /.sidebar -->
</aside>