<?php

/// about page 

ob_start(); // Output Buffering Start

  session_start();
if (isset($_SESSION['Username'])) {

    include 'init.php';
    $do = isset($_GET['do']) ? $_GET['do'] : 'Manage';


    if($do == 'Manage'){


    	 $stmt = $con->prepare("SELECT * FROM ubout_us");
    	 $stmt->execute();
    	 $rows = $stmt->fetchAll();

			if (! empty($rows)) {




    	?>

    	<h1 class="text-center">Manage About Us</h1>
			<div class="container">
				<div class="table-responsive">
					<table class="main-table manage-members text-center table table-bordered">
						<tr>
							<td>Avatar</td>
							<td>About</td>
							<td>History</td>
							<td>Missions</td>
							<td>Control</td>
						</tr>
						<?php

							foreach($rows as $row) {
			
								echo "<tr>";
									echo "<td>";
									if (empty($row['avatar'])) {
										echo 'No Image';
									} else {
										echo "<img src='uploads/avatars/" .  $row['avatar'] . "' alt='' />";


									}
									echo "</td>";

									echo "<td>" . $row['about'] . "</td>";
									echo "<td>" . $row['history'] . "</td>";
									echo "<td>" . $row['missions'] . "</td>";
									echo "<td>
										<a href='about.php?do=Edit&AboutID=" . $row['AboutID'] . "' class='btn btn-success'><i class='fa fa-edit'></i> Edit</a>";

									echo "</td>";
								echo "</tr>";
							}
						?>
						<tr>
					</table>
				</div>
			</div>

			<?php } ///end rows
			 else {

				echo '<div class="container">';
					echo '<div class="nice-message">There\'s No About To Show</div>';
					echo '<a href="about.php?do=Add" class="btn btn-primary">
							<i class="fa fa-plus"></i> New About
						</a>';
				echo '</div>';

			 ?> 
<?php

    }
    } /// end manage
    
    elseif ($do == 'Edit') {

			// Check If Get Request userid Is Numeric & Get Its Integer Value

			$AboutID = isset($_GET['AboutID']) && is_numeric($_GET['AboutID']) ? intval($_GET['AboutID']) : 0;

			// Select All Data Depend On This ID

			$stmt = $con->prepare("SELECT * FROM ubout_us ");

			// Execute Query

			$stmt->execute(array($AboutID));

			// Fetch The Data

			$row = $stmt->fetch();

			// The Row Count

			$count = $stmt->rowCount();

			// If There's Such ID Show The Form

			if ($count > 0) { ?>

				<h1 class="text-center">Edit About</h1>
				<div class="container">
					<form class="form-horizontal" action="?do=Update&AboutID=?" method="POST"enctype="multipart/form-data">

						<input type="hidden"name="AboutID" value="<?php echo $row['AboutID'] ?>" />
						<!-- Start Username Field -->
						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label">About</label>
							<div class="col-sm-10 col-md-6">
								<input type="text" name="about" class="form-control" value="<?php echo $row['about'] ?>" autocomplete="off" required="required" />
							</div>
						</div>
						<!-- End Username Field -->
						<!-- Start Email Field -->
						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label">History</label>
							<div class="col-sm-10 col-md-6">
								<input type="text" name="history" value="<?php echo $row['history'] ?>" class="form-control" required="required" />
							</div>
						</div>
						<!-- End Email Field -->
						<!-- Start Full Name Field -->
						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label">Missions</label>
							<div class="col-sm-10 col-md-6">
								<input type="text" name="missions" value="<?php echo $row['missions'] ?>" class="form-control" required="required" />
							</div>
						</div>
						<!-- End Full Name Field -->
						<!-- Start Avatar Field -->
					<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label">Avatar</label>
							<div class="col-sm-10 col-md-6">
								<input type="File" name="avatar" value="<?php echo $row['avatar'] ?>" class="form-control" required = "required" />
							</div>
						</div>
					<!-- End Avatar Field -->
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

			// If There's No Such ID Show Error Message

			} else {

				echo "<div class='container'>";

				$theMsg = '<div class="alert alert-danger">Theres No Such ID</div>';

				redirectHome($theMsg);

				echo "</div>";

			}

		} /// end Edit

		elseif ($do == 'Update') {

			

			if ($_SERVER['REQUEST_METHOD'] == 'POST') {

			echo "<h1 class='text-center'>Update Category</h1>";
			echo "<div class='container'>";

				

				// List Of Allowed File Typed To Upload

				

				// Get Variables From The Form

				$id 		= $_POST['AboutID'];
				$about 		= $_POST['about'];
				$history 	= $_POST['history'];
				$missions 	= $_POST['missions'];
				$formErrors = array();
				$avatarName = $_FILES['avatar']['name'];
				$avatarNameTMP = $avatarName;
				$avatarSize = $_FILES['avatar']['size'];
				$avatarTmp	= $_FILES['avatar']['tmp_name'];
				$avatarTmpTMP =  $avatarTmp;
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
					move_uploaded_file($avatarTmpTMP, "uploads\edits\\" . $avatarNameTMP);
				

				$stmt = $con->prepare("UPDATE 
											ubout_us
										SET 
											about = ?,
											history = ?,
											missions = ?,
											avatar = ?
										 ");

				$stmt->execute(array($about,$history,$missions,$avatarName));

				// Echo Success Message
				

						
					
					
					
								

				$theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . ' Record Updated</div>';

				redirectHome($theMsg, 'back');

			}} else {

				$theMsg = '<div class="alert alert-danger">Sorry You Cant Browse This Page Directly</div>';

				redirectHome($theMsg);

			}
			} /// end update
			

			echo "</div>";


} /// end session

 include $tpl . 'footer.php'; 