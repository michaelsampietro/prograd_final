<div id="navbar-left" class="col-sm-3 col-lg-2">
  <div class="sidebar-nav">
    <div class="navbar navbar-default" role="navigation">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-navbar-collapse">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <span class="visible-xs navbar-brand">Menu</span>
      </div>
      <div class="navbar-collapse collapse sidebar-navbar-collapse">
        <ul id="navbar-left-items" class="nav navbar-nav">
          <?php foreach($pages as $url=>$title):?>
            <li <?php if($url === $activePage):?>class="active"<?php endif;?>>
              <a href="<?php echo "$url?anos=$anoSelecionadoPOST";?>">
                <?php echo $title;?>
              </a>
            </li>
          <?php endforeach;?>
        </ul>
      </div><!--/.nav-collapse -->
    </div>
  </div>
</div>
