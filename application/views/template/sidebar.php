<!-- Sidebar -->
<?php
// get session menu akses
$Menu = $this->session->userdata('menu');
$parentMenu = $this->session->userdata('parentMenu');
$arrAccessMenu = $this->session->userdata('access_menu');
/////////////////////////
?>
<div id="sidebar-wrapper">
  <ul class="sidebar-nav">
    <li class="logo">
      <a href="<?=base_url()?>" class="logo navbar-pocn">
        <?=strtoupper($title)?>
      </a>
    </li>
    <li style="margin-bottom: 5px;">
      <div class="user-panel">
        <div class="pull-left image">
            <!-- <img src="<?=base_url('assets/img/avatar5.png')?>" class="img-circle" alt="User Image" /> -->
        </div>
        <div class="pull-left info">
            <p>
              <a href="<?=base_url('users/update/'.$this->session->userdata('user_id'))?>">
                  <i class="fa fa-user fa-fw pull-right"></i>
                  <?=$this->pocnauth->full_name();?>
              </a>
            </p>

            <a href="<?= base_url('auth/logout'); ?>"><i class="glyphicon glyphicon-log-out"></i> Logout</a>
        </div>
    </div>
    </li>

    <?php
    $ParentActive = 0;
    foreach ($Menu as $val) {

      if($arrAccessMenu[$val->MenuId]['Read']){            
        if($parentMenu[$val->MenuId]){
          foreach ($parentMenu[$val->MenuId] as $value) {
            $ctrl = explode("/", $value->Controller); 
            if (strtolower($ctrl[0]) == strtolower($this->uri->segment(1)))
            {
              $ParentActive = $value->Parent;
            }            
          }
        }
      }



      if($arrAccessMenu[$val->MenuId]['Read']){
      $active = (strtolower($val->Controller) == strtolower($this->uri->segment(1))) ? "active" : "";
      $collapseActive = ($val->MenuId == $ParentActive) ? "active" : "";
      $collapse = ($val->MenuId != $ParentActive) ? "collapsed" : "";
      $isActive = ($val->MenuId != $ParentActive) ? "false" : "true";
      $parentCollapse = ($val->MenuId != $ParentActive) ? "collapse" : "collapse in";

        echo '
            <li class="'.$active.' '.$collapseActive.'">';
              if($val->Controller == '#'){
                echo '<a clas="'.$collapse.'" href="#" data-toggle="collapse" data-target="#toggle'.$val->MenuId.'" data-parent="#sidenav01" class="collapsed" style="cursor:s-resize" aria-expanded="'.$isActive.'"><i class="'.$val->MenuIcon.'"></i> &nbsp '.$val->MenuText.'</a>';
              }else{
                echo '<a href="'.base_url($val->Controller).'"><i class="'.$val->MenuIcon.'"></i> &nbsp '.$val->MenuText.'</a>';
              }
              // load parent menu
              if($parentMenu[$val->MenuId]){
                echo '<div class="'.$parentCollapse.'" id="toggle'.$val->MenuId.'">';
                echo ' <ul class="nav nav-list">';
                foreach ($parentMenu[$val->MenuId] as $value) {
                    if($arrAccessMenu[$value->MenuId]['Read']){
                    echo '<li class="small-li">
                            <a href="'.base_url($value->Controller).'"><i class="'.$value->MenuIcon.'"></i> &nbsp '.$value->MenuText.'</a>
                          </li>';
                  }
                }
                echo '</ul>';
                echo '</div>';
              }

        echo '</li>';
      }
    }

    ?>

  </ul>
</div>
<!-- /#sidebar-wrapper -->
