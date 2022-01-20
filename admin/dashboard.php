<?php


	session_start();

	if (isset($_SESSION['Username'])) {

		$pageTitle = 'Dashboard';
	    include 'init.php';

	    $numItems = 6; // Number Of Latest Items

		$latestItems = getLatest("*", 'items', 'Item_ID', $numItems); // Latest Items Array
		?>


<div class="home-stats">
			<div class="container text-center">
				<h1>Home</h1>
				<div class="row">
					<div class="col-md-3">
						<div class="stat st-members">
							<i class="fa fa-list-alt" aria-hidden="true"></i>
							<div class="info">
								Total Categories
								<span>
									<a href="categories.php"><?php echo countItems('ID', 'categories') ?></a>
								</span>
							</div>
						</div>
					</div>

<div class="col-md-3">
						<div class="stat st-items">
							<i class="fa fa-tag"></i>
							<div class="info">
								Total Items
								<span>
									<a href="items.php"><?php echo countItems('Item_ID', 'items') ?></a>
								</span>
							</div>
						</div>
					</div>
					<div class="col-md-3">
						<div class="stat st-comments">
							<i class="fa fa-comments"></i>
							<div class="info">
								Total Messages
								<span>
									<a href="messages.php"><?php echo countItems('MsgID', 'messages') ?></a>
								</span>
							</div>
						</div>
					</div>
					<div class="col-md-3">
						<div class="stat st-commentss">
							<i class="fa fa-database" aria-hidden="true"></i>
							<div class="info">
								Database
								<span>
									<a href="s.php">Save</a>
								</span>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>




<?php




		include $tpl . 'footer.php'; }









		 else {

		header('Location: index.php');

		exit();
	}



?>