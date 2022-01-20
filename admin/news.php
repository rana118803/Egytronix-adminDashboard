<?php

/**



news page 


**/

ob_start(); // Output Buffering Start

	session_start();

	$pageTitle = 'News';

	if (isset($_SESSION['Username'])) {

		include 'init.php';

		$do = isset($_GET['do']) ? $_GET['do'] : 'Manage';


		if($do == 'Manage'){


			$stmt = $con->prepare("SELECT * FROM news ");

			// Execute The Statement

			$stmt->execute();

			// Assign To Variable 

			$rows = $stmt->fetchAll();

			if (! empty($rows)) {

			?>

			<h1 class="text-center">Manage News</h1>
			<div class="container">
				<div class="table-responsive">
					<table class="main-table manage-members text-center table table-bordered">
						<tr>
							<td>Avatar</td>
							<td>Text</td>
							<td>Control</td>
						</tr>
						<?php
							foreach($rows as $row) {
								echo "<tr>";
									echo "<td>";
									if (empty($row['Avatar'])) {
										echo 'No Image';
									} else {
										echo "<img src='uploads/avatars/" . $row['Avatar'] . "' alt='' />";
									}
									echo "</td>";

									echo "<td>" . $row['News'] . "</td>";
									echo "<td>
										<a href='news.php?do=Edit&newid=" . $row['News_ID'] . "' class='btn btn-success'><i class='fa fa-edit'></i> Edit</a>
										<a href='news.php?do=Delete&newid=" . $row['News_ID'] . "' class='btn btn-danger confirm'><i class='fa fa-close'></i> Delete </a>";
									echo "</td>";
								echo "</tr>";
							}
						?>
						<tr>
					</table>
				</div>
				<a href="news.php?do=Add" class="add-category btn btn-primary">
					<i class="fa fa-plus"></i> Add News
				</a>
			</div>

			<?php } else {

				echo '<div class="container">';
					echo '<div class="nice-message">There\'s No News To Show</div>';
					echo '<a href="news.php?do=Add" class="btn btn-primary">
							<i class="fa fa-plus"></i> Add News
						</a>';

				echo '</div>';

			} ?>

		<?php 

		

		} // end manage

		elseif($do == 'Add'){

			?>

      <h1 class="text-center">Add News</h1>
      <div class="container">
        <form class="form-horizontal" action="?do=Insert&NewsID = ?" method="POST"enctype="multipart/form-data">
          <!-- Start Name Field -->
          <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label">Text</label>
            <div class="col-sm-10 col-md-6">
              <input type="text" name="text" class="form-control" autocomplete="off" required="required" placeholder="Name Of The Category" />
            </div>
          </div>
          <!-- End Name Field -->
           <!-- Start Name Field -->
          <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label">Image</label>
            <div class="col-sm-10 col-md-6">
              <input type="File" name="avatar" class="form-control" autocomplete="off" placeholder="Name Of The Category" />
            </div>
          </div>
          <!-- End Name Field -->
          <!-- Start Submit Field -->
						<div class="form-group form-group-lg">
							<div class="col-sm-offset-2 col-sm-10">
								<input type="submit" value="Save" class="btn btn-primary btn-lg" />
							</div>
						</div>
						<!-- End Submit Field -->
					</form>
				</div>

	
<?php
		} // end add 

		elseif ($do == 'Insert') {

			// Insert Page

			if ($_SERVER['REQUEST_METHOD'] == 'POST') {

				echo "<h1 class='text-center'>Insert News</h1>";
				echo "<div class='container'>";

				// Upload Variables

				$text       = $_POST['text'];
				$formErrors = array();
				$avatarName = $_FILES['avatar']['name'];
				$avatarSize = $_FILES['avatar']['size'];
				$avatarTmp	= $_FILES['avatar']['tmp_name'];
				$avatarType = $_FILES['avatar']['type'];
				$avatarAllowedExtension = array("jpeg", "jpg", "png", "gif");

				// Get Avatar Extension

				//$avatarExtension = strtolower(end(explode('.', $avatarName)));


				if (! empty($avatarName) && ! $avatarAllowedExtension) {
					$formErrors[] = 'This Extension Is Not <strong>Allowed</strong>';
				}

				if (empty($avatarName)) {
					$formErrors[] = 'Avatar Is <strong>Required</strong>';

				}

				if ($avatarSize > 4194304) {
					$formErrors[] = 'Avatar Cant Be Larger Than <strong>4MB</strong>';
				}

				// Loop Into Errors Array And Echo It

				foreach($formErrors as $error) {
					echo '<div class="alert alert-danger">' . $error . '</div>';
				}

				// Check If There's No Error Proceed The Update Operation

				if (empty($formErrors)) {/*

					$avatar = rand(0, 10000000000) . '_' . $avatarName;

					move_uploaded_file($avatarTmp, "uploads\avatars\\" . $avatar);
				$avatar = rand(0, 10000000000) . '_' . $avatarName;
				echo $avatar;
*/
					move_uploaded_file($avatarTmp, "uploads\avatars\\" . $avatarName);
				

						$stmt = $con->prepare("INSERT INTO 
													news(News,Avatar)
												VALUES(:znews , :zavatar) ");
						$stmt->execute(array(

							':znews'     => $text,
							':zavatar'	=> $avatarName

						));

						// Echo Success Message

						$theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . ' Record Inserted</div>';

						redirectHome($theMsg, 'back');

					}

				}

				} // end insert

				elseif ($do == 'Edit') {

			// Check If Get Request item Is Numeric & Get Its Integer Value

			$newid = isset($_GET['newid']) && is_numeric($_GET['newid']) ? intval($_GET['newid']) : 0;

			// Select All Data Depend On This ID

			$stmt = $con->prepare("SELECT * FROM news WHERE News_ID = ?");

			// Execute Query

			$stmt->execute(array($newid));

			// Fetch The Data

			$item = $stmt->fetch();

			// The Row Count

			$count = $stmt->rowCount();

			// If There's Such ID Show The Form

			if ($count > 0) { ?>

				<h1 class="text-center">Edit News</h1>
				<div class="container">
					<form class="form-horizontal" action="?do=Update
					&newid=?" method="POST"enctype="multipart/form-data">
						<input type="hidden" name="newid" value="<?php echo $newid ?>" />
						<!-- Start Name Field -->
						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label">Name</label>
							<div class="col-sm-10 col-md-6">
								<input 
									type="text" 
									name="news" 
									class="form-control" 
									required="required"  
									placeholder="Name of The Item"
									value="<?php echo $item['News'] ?>" />
							</div>
						</div>
						<!-- End Name Field -->
						<!-- Start Name Field -->
		          <div class="form-group form-group-lg">
		            <label class="col-sm-2 control-label">Image</label>
		            <div class="col-sm-10 col-md-6">
		              <input type="File" name="avatar" class="form-control" autocomplete="off" placeholder="Name Of The Category" / required="required">
		            </div>
		          </div>
		          <!-- End Name Field -->
		          <!-- Start Submit Field -->
								<div class="form-group form-group-lg">
									<div class="col-sm-offset-2 col-sm-10">
										<input type="submit" value="Save" class="btn btn-primary btn-lg" />
									</div>
								</div>
								<!-- End Submit Field -->
						
					</form>

					<?php

					// Select All Users Except Admin 

					// Execute The Statement ?>
				</div>

			<?php

			// If There's No Such ID Show Error Message

			} else {

				echo "<div class='container'>";

				$theMsg = '<div class="alert alert-danger">Theres No Such ID</div>';

				redirectHome($theMsg);

				echo "</div>";

			}			

		
		} /// end edit

		elseif($do == "Update"){

			echo "<h1 class='text-center'>Update Item</h1>";
			echo "<div class='container'>";

			if ($_SERVER['REQUEST_METHOD'] == 'POST') {

				// Get Variables From The Form

				$id 		= $_POST['newid'];
				$news 		= $_POST['news'];
				$formErrors = array();
				$avatarName = $_FILES['avatar']['name'];
				$avatarSize = $_FILES['avatar']['size'];
				$avatarTmp	= $_FILES['avatar']['tmp_name'];
				$avatarType = $_FILES['avatar']['type'];
				$avatarAllowedExtension = array("jpeg", "jpg", "png", "gif");

				// Get Avatar Extension

				//$avatarExtension = strtolower(end(explode('.', $avatarName)));


				if (! empty($avatarName) && ! $avatarAllowedExtension) {
					$formErrors[] = 'This Extension Is Not <strong>Allowed</strong>';
				}

				if (empty($avatarName)) {
					$formErrors[] = 'Avatar Is <strong>Required</strong>';

				}

				if ($avatarSize > 4194304) {
					$formErrors[] = 'Avatar Cant Be Larger Than <strong>4MB</strong>';
				}

				// Loop Into Errors Array And Echo It

				foreach($formErrors as $error) {
					echo '<div class="alert alert-danger">' . $error . '</div>';
				}

				// Check If There's No Error Proceed The Update Operation

				if (empty($formErrors)) {

					move_uploaded_file($avatarTmp, "uploads\avatars\\" . $avatarName);
				

				$stmt = $con->prepare("UPDATE 
											news
										SET 
										News =?,
										Avatar =?
										WHERE News_ID = ?
											
										 ");

				$stmt->execute(array($news,$avatarName,$id));

				// Echo Success Message
				

						
					
					
					
								

				$theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . ' Record Updated</div>';

				redirectHome($theMsg, 'back');
}}
			 else {

				$theMsg = '<div class="alert alert-danger">Sorry You Cant Browse This Page Directly</div>';

				redirectHome($theMsg);

			}
			} /// end update
		

				elseif ($do == 'Delete') {

      echo "<h1 class='text-center'>Delete Category</h1>";
      echo "<div class='container'>";

        // Check If Get Request Catid Is Numeric & Get The Integer Value Of It

        $newsid = isset($_GET['NewsID']) && is_numeric($_GET['NewsID']) ? intval($_GET['NewsID']) : 0;

        // Select All Data Depend On This ID

        $check = checkItem('News_ID', 'news', $newsid);

        // If There's Such ID Show The Form
        
        if ($check > 0) {

          $stmt = $con->prepare("DELETE FROM news WHERE News_ID = :zid");

          $stmt->bindParam(":zid", $newsid);

          $stmt->execute();

          $theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . ' Record Deleted</div>';

          redirectHome($theMsg, 'back');

        }
       else {

        echo "<div class='container'>";

        $theMsg = '<div class="alert alert-danger">Theres No Such ID</div>';

        redirectHome($theMsg);

        echo "</div>";

      }
      


			} else {

				echo "<div class='container'>";

				$theMsg = '<div class="alert alert-danger">Sorry You Cant Browse This Page Directly</div>';

				redirectHome($theMsg);

				echo "</div>";

			}


			echo "</div>";

		



		include $tpl . 'footer.php';
} // end session