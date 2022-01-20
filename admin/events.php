<?php

/*



Evetnts Page 



*/

ob_start(); // Output Buffering Start

  session_start();
if (isset($_SESSION['Username'])) {

    include 'init.php';
    $do = isset($_GET['do']) ? $_GET['do'] : 'Manage';


    if($do == 'Manage'){


    	 $stmt = $con->prepare("SELECT * FROM events");
    	 $stmt->execute();
    	 $rows = $stmt->fetchAll();

			if (! empty($rows)) {




    	?>

    	<h1 class="text-center">Manage Branches</h1>
			<div class="container">
				<div class="table-responsive">
					<table class="main-table manage-members text-center table table-bordered">
						<tr>
							<td>Event Name</td>
							<td>Date</td>
							<td>Description</td>
							<td>Main Image</td>
							<td>Control</td>
							
						</tr>
						<?php

							foreach($rows as $row) {
			
								echo "<tr>";
									
									echo "<td>" . $row['Event_Name'] . "</td>";
									echo "<td>" . $row['Event_Date'] . "</td>";
									 echo "<td>" . $row['Event_Des'] . "</td>";
									 echo "<td>";
									if (empty($row['Main_Image'])) {
										echo 'No Image';
									} else {
										echo "<img src='uploads/avatars/" . $row['Main_Image'] . "' alt='' />";
									}
									echo "</td>";
		
									echo "<td>
										<a href='events.php?do=Edit&EventID=" . $row['Event_ID'] . "' class='btn btn-success confirm'><i class='fa fa-close'></i> Edit </a>
										<a href='events.php?do=Delete&EventID=" . $row['Event_ID'] . "' class='btn btn-danger confirm'><i class='fa fa-close'></i> Delete </a>";
									echo "</td>";
								echo "</tr>";
							}
						?>
						<tr>
					</table>
				</div>
				<a href="events.php?do=Add" class="btn btn-primary">
					<i class="fa fa-plus"></i>Add Event
				</a>
			</div>

			<?php } ///end rows
			 else {

				echo '<div class="container">';
					echo '<div class="nice-message">There\'s No Events To Show</div>';
					echo '<a href="events.php?do=Add" class="btn btn-primary">
							<i class="fa fa-plus"></i> New Event
						</a>';
				echo '</div>';
			 ?> 
<?php

    }
}/// end manage

elseif($do == 'Add'){

			?>

      <h1 class="text-center">Add Event</h1>
      <div class="container">
        <form class="form-horizontal" action="?do=Insert&EventID = ?" method="POST"enctype="multipart/form-data">
          <!-- Start Name Field -->
          <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label">Event Name</label>
            <div class="col-sm-10 col-md-6">
              <input type="text" name="name" class="form-control" autocomplete="off" required="required" placeholder="Name Of The Category" />
            </div>
          </div>
          <!-- End Name Field -->
           <!-- Start Date Field -->
          <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label">Date</label>
            <div class="col-sm-10 col-md-6">
              <input type="Date" name="date" class="form-control" autocomplete="off"required="required" placeholder="Name Of The Category" />
            </div>
          </div>
          <!-- End Name Field -->
          <!-- Start Date Field -->
          <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label">Description</label>
            <div class="col-sm-10 col-md-6">
              <input type="text" name="description" class="form-control" autocomplete="off"required="required" placeholder="Name Of The Category" />
            </div>
          </div>
          <!-- End Name Field -->
            <!-- Start Date Field -->
          <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label">Main Image</label>
            <div class="col-sm-10 col-md-6">
              <input type="File" name="avatar1" class="form-control" autocomplete="off" required="required"placeholder="Name Of The Category" / max="1">
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

			// Insert Event Page

			if ($_SERVER['REQUEST_METHOD'] == 'POST') {

				echo "<h1 class='text-center'>Insert Event</h1>";
				echo "<div class='container'>";

				// Upload Variables

				$name       = $_POST['name'];
				$date 		= $_POST['date'];
				$description= $_POST['description'];
				$formErrors1 = array();
				$formErrors2 = array(); 
				$avatarName1 = $_FILES['avatar1']['name'];
				$avatarSize1 = $_FILES['avatar1']['size'];
				$avatarTmp1	= $_FILES['avatar1']['tmp_name'];
				$avatarType1 = $_FILES['avatar1']['type'];
				$avatarAllowedExtension1 = array("jpeg", "jpg", "png", "gif");
				
				// Get Avatar Extension


				if (! empty($avatarName1) && ! $avatarAllowedExtension1) {
					$formErrors1[] = 'This Extension Is Not <strong>Allowed</strong>';
				}

				if (empty($avatarName1)) {
					$formErrors1[] = 'Avatar Is <strong>Required</strong>';

				}

				if ($avatarSize1 > 4194304) {
					$formErrors1[] = 'Avatar Cant Be Larger Than <strong>4MB</strong>';
				}

				// Loop Into Errors Array And Echo It

				foreach($formErrors1 as $error1) {
					echo '<div class="alert alert-danger">' . $error1 ."In Main Image" . '</div>';
				}
				
				// Check If There's No Error Proceed The Update Operation

				

				if (empty($formErrors1 && $formErrors2)) {

					move_uploaded_file($avatarTmp1, "uploads\avatars\\" . $avatarName1);
		
				
            
						$stmt = $con->prepare("INSERT INTO 
													events(Event_Name,Event_Date,Event_Des,Main_Image)
												VALUES(:zname,:zdate,:zdes,:zmain) ");
						$stmt->execute(array(
							':zname' => $name,
						    ':zdate' => $date,
							':zdes'  => $description,
							':zmain' => $avatarName1
						));

						// Echo Success Message

						$theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . ' Record Inserted</div>';

					//	redirectHome($theMsg, 'back');

					} // End if
} // end post 
} // end Insert
elseif ($do == 'Edit') {

			// Check If Get Request userid Is Numeric & Get Its Integer Value

			$eventid = isset($_GET['EventID']) && is_numeric($_GET['EventID']) ? intval($_GET['EventID']) : 0;

			// Select All Data Depend On This ID

			$stmt = $con->prepare("SELECT * FROM events WHERE Event_ID = ? ");

			// Execute Query

			$stmt->execute(array($eventid));

			// Fetch The Data

			$row = $stmt->fetch();

			// The Row Count

			$count = $stmt->rowCount();

			// If There's Such ID Show The Form

			if ($count > 0) { ?>

				<h1 class="text-center">Edit Event</h1>
				<div class="container">
					<form class="form-horizontal" action="?do=Update&EventID=?" method="POST"enctype="multipart/form-data">
						<input type="hidden" name="EventID" value="<?php echo $eventid ?>" />
						<!-- Start Username Field -->
						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label">Event Name</label>
							<div class="col-sm-10 col-md-6">
								<input type="text" name="name" class="form-control" value="<?php echo $row['Event_Name'] ?>" autocomplete="off" required="required" />
							</div>
						</div>
						<!-- End Username Field -->
						<!-- Start Full Name Field -->
						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label">Date</label>
							<div class="col-sm-10 col-md-6">
								<input type="date" name="date" value="<?php echo $row['Event_Date'] ?>" class="form-control" required="required" />
							</div>
						</div>
						<!-- End Full Name Field -->
						<!-- Start Username Field -->
						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label">Description</label>
							<div class="col-sm-10 col-md-6">
								<input type="text" name="des" class="form-control" value="<?php echo $row['Event_Des'] ?>" autocomplete="off" required="required" />
							</div>
						</div>
						<!-- End Username Field -->

					 <!-- Start Avatar Field -->
					<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label">Main Image</label>
							<div class="col-sm-10 col-md-6">
								<input type="File" name="avatar" value="<?php echo $row['Main_Image'] ?>" class="form-control" />
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

				//redirectHome($theMsg);

				echo "</div>";

			}

		} // end edit
		elseif ($do == 'Update') {

			

			if ($_SERVER['REQUEST_METHOD'] == 'POST') {

			echo "<h1 class='text-center'>Update Category</h1>";
			echo "<div class='container'>";

				

				// List Of Allowed File Typed To Upload

				

				// Get Variables From The Form

				$id 		= $_POST['EventID'];
				$name 		= $_POST['name'];
				$date 		= $_POST['date'];
				$des 		= $_POST['des'];
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
											events
										SET 
										Event_Name = ?,
										Event_Date = ?,
										Event_Des =?,
										Main_Image =?
											
										 ");

				$stmt->execute(array($name,$date,$des,$avatarName));

				// Echo Success Message
				

						
					
					
					
								

				$theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . ' Record Updated</div>';

				redirectHome($theMsg, 'back');
}
			} else {

				$theMsg = '<div class="alert alert-danger">Sorry You Cant Browse This Page Directly</div>';

				//redirectHome($theMsg);

			}
			}
			elseif ($do == 'Delete') {

      echo "<h1 class='text-center'>Delete Category</h1>";
      echo "<div class='container'>";

        // Check If Get Request Catid Is Numeric & Get The Integer Value Of It

        $eventid = isset($_GET['EventID']) && is_numeric($_GET['EventID']) ? intval($_GET['EventID']) : 0;

        // Select All Data Depend On This ID

        $check = checkItem('Event_ID', 'events', $eventid);

        // If There's Such ID Show The Form
        
        if ($check > 0) {

          $stmt = $con->prepare("DELETE FROM events WHERE Event_ID = :zid");

          $stmt->bindParam(":zid", $eventid);

          $stmt->execute();

          $theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . ' Record Deleted</div>';

          redirectHome($theMsg, 'back');

        }
       else {

        echo "<div class='container'>";

        $theMsg = '<div class="alert alert-danger">Theres No Such ID</div>';

       // redirectHome($theMsg);

        echo "</div>";

      }
      


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




		 // end sesssion
		 include $tpl . 'footer.php';