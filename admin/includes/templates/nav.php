
<!-- Bootstrap Menu -->
<div id="navigation">
  <div class="navbar-wrapper scroll-fixed-navbar" >
    <nav class="navbar-inverse navbar-static-top" role="navigation">
      <div class="container">
        <div class="row">
          <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="dashboard.php"><div class ='brand'>Egy-Tronix</div></a>
          </div>
          <div id="mynav" class="navbar-collapse collapse">
            <ul class="nav navbar-nav main-nav-list">
              <li><a href="dashboard.php?do=Manage">Home</a></li>
              <li><a href="about.php?do=Manage">About</a></li>
              <li><a href="categories.php?do=Manage">Categories</a></li>
              <li><a href="items.php?do=Manage">Items</a></li>
              <li><a href="news.php?do=Manage">News</a></li>
              <li><a href="messages.php?do=Manage">Messages</a></li> 
              <li><a href="location.php?do=Manage">Locations</a></li>  
              <li><a href="Events.php?do=Manage">Events</a></li>              
            </ul>
            <ul class="nav navbar-nav navbar-right">
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?php echo $_SESSION['Username'];?> <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="admin.php?do=Edit&userid=<?php echo $_SESSION['ID'] ?>">Edit Profile</a></li>
            <li><a href="logout.php">Logout</a></li>
          </ul>
        </li>
      </ul>
          </div>    
        </div>
      </div>
    </nav>
  </div>
</div>
<!-- End Bootstrap Menu -->
