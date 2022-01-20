<?php


/*



Locations


*/

ob_start(); // Output Buffering Start

  session_start();
if (isset($_SESSION['Username'])) {

    include 'init.php';
    $do = isset($_GET['do']) ? $_GET['do'] : 'Manage';


    if($do == 'Manage'){


    	 $stmt = $con->prepare("SELECT * FROM branches");
    	 $stmt->execute();
    	 $rows = $stmt->fetchAll();

			if (! empty($rows)) {




    	?>

    	<h1 class="text-center">Manage Branches</h1>
			<div class="container">
				<div class="table-responsive">
					<table class="main-table manage-members text-center table table-bordered">
						<tr>
							<td>Name</td>
							<td>Address</td>
							<td>Phone</td>
							<td>Control</td>
						</tr>
						<?php

							foreach($rows as $row) {
			
								echo "<tr>";
									
									echo "<td>" . $row['Branch_Name'] . "</td>";
									echo "<td>" ;
									?>
									<a href="<?php  echo $row['Address'];  ?>"target="_blank">Map</a>
									<?php
									echo "</td>";
									echo "<td>" . $row['Telephone'] . "</td>";
									echo "<td>
									<a href='location.php?do=Edit&locid=" . $row['Loc_ID'] . "' class='btn btn-danger'><i class='fa fa-edit'></i>Edit</a>
										<a href='location.php?do=Delete&locid=" . $row['Loc_ID'] . "' class='btn btn-danger'><i class='fa fa-edit'></i>Delete</a>";

									echo "</td>";
								echo "</tr>";
							}
						?>
						<tr>
					</table>
				</div>
				<a href="Location.php?do=Add" class="btn btn-primary">
							<i class="fa fa-plus"></i>New Location
						</a>
			</div>

			<?php } ///end rows
			 else {

				echo '<br><br><div class="container">';
					echo '<div class="nice-message">There\'s No Locations To Show</div>';
					echo '<a href="Location.php?do=Add" class="btn btn-primary">
							<i class="fa fa-plus"></i> New Location
						</a>';
				echo '</div>';

			 ?> 
<?php

    }
}/// end manage
elseif($do == 'Add'){?>


	<h1 class="text-center">Add Location</h1>
      <div class="container">
        <form class="form-horizontal" action="?do=Insert" method="POST"enctype="multipart/form-data">
          <!-- Start Name Field -->
          <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label">Location Name</label>
            <div class="col-sm-10 col-md-6">
              <input type="text" name="Branch_Name" class="form-control" autocomplete="off" required="required" placeholder="Name Of The Category" />
            </div>
          </div>
          <!-- End Name Field -->
          <!-- Start Name Field -->
          <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label">Address</label>
            <div class="col-sm-10 col-md-6">
              <input type="link" name="Address" class="form-control" autocomplete="off" required="required" placeholder="Name Of The Category" />
            </div>
          </div>
          <!-- End Name Field -->
          <!-- Start Name Field -->
          <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label">Telephone</label>
            <div class="col-sm-10 col-md-6">
              <input type="Numeric" name="Telephone" class="form-control" autocomplete="off" required="required" placeholder="Name Of The Category" />
            </div>
          </div>
          <!-- End Name Field -->
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

		elseif($do == 'Insert'){

			// Insert  Page

			if ($_SERVER['REQUEST_METHOD'] == 'POST') {

				echo "<h1 class='text-center'>Insert Location</h1>";
				echo "<div class='container'>";

				// Upload Variables
				$name 	 = $_POST['Branch_Name'];
				$address = $_POST['Address'];
				$telephone = $_POST['Telephone'];

				$stmt = $con->prepare("INSERT INTO branches(Branch_Name,Address,Telephone) VALUES(:zname,:zaddress,:ztelephone)");
				$stmt->execute(array(

					':zname' => $name,
					':zaddress' =>$address,
					':ztelephone'=>$telephone
				));

				$count = $stmt->rowCount();
				if($count > 0){

						$theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . ' Record Inserted</div>';

						redirectHome($theMsg, 'back');

					}else{
						echo "<div class='container'>";

				$theMsg = '<div class="alert alert-danger">Theres No Such ID</div>';

				redirectHome($theMsg);

				echo "</div>";
					}
		}
	}

elseif ($do == 'Edit') {

	$locid = isset($_GET['locid']) && is_numeric($_GET['locid']) ? intval($_GET['locid']) : 0;

			// Select All Data Depend On This ID

			$stmt = $con->prepare("SELECT * FROM branches WHERE Loc_ID = ? ");

			// Execute Query

			$stmt->execute(array($locid));

			// Fetch The Data

			$row = $stmt->fetch();

			// The Row Count
			
			$count = $stmt->rowCount();
			
			// If There's Such ID Show The Form

			if ($count > 0) { ?>
				
				<h1 class="text-center">Edit Location</h1>
				<div class="container">
					<form class="form-horizontal" action="?do=Update
					&locid=?" method="POST"enctype="multipart/form-data">
						<input type="hidden" name="locid" value="<?php echo $locid ?>" />
						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label">Location Name</label>
							<div class="col-sm-10 col-md-6">
								<input type="text" name="name" value="<?php echo $row['Branch_Name'] ?>" class="form-control" required="required" />
							</div>
						</div>
						<!-- End Full Name Field -->
						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label">Address</label>
							<div class="col-sm-10 col-md-6">
								<input type="link" name="address" value="<?php echo $row['Address'] ?>" class="form-control" required="required" />
							</div>
						</div>
						<!-- End Full Name Field -->
						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label">Telephone</label>
							<div class="col-sm-10 col-md-6">
								<input type="Numeric" name="telephone" value="<?php echo $row['Telephone'] ?>" class="form-control" required="required" />
							</div>
						</div>
						<!-- End Full Name Field -->
						
		          <!-- Start Submit Field -->
								<div class="form-group form-group-lg">
									<div class="col-sm-offset-2 col-sm-10">
										<input type="submit" value="Save" class="btn btn-primary btn-lg" />
									</div>
								</div>
								<!-- End Submit Field -->
						
					</form>
				</div>
			</tr>
		</table>
	</div>
</div>

<?php


			}

}
elseif($do == 'Update'){

echo "<h1 class='text-center'>Update Item</h1>";
			echo "<div class='container'>";

			if ($_SERVER['REQUEST_METHOD'] == 'POST') {

				$locid  = $_POST['locid'];
				$name   = $_POST['name'];
				$address = $_POST['address'];
				$tele   = $_POST['telephone'];

				$stmt = $con->prepare("UPDATE 
											branches
										SET 
										Branch_Name = ?,
										Address     = ?,
										Telephone   = ?
										WHERE Loc_ID =?
										 ");

				$stmt->execute(array($name,$address,$tele,$locid));

				// Echo Success Message
				

						
					
					
					
								

				$theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . ' Record Updated</div>';

				redirectHome($theMsg, 'back');
}

			 else {

				$theMsg = '<div class="alert alert-danger">Sorry You Cant Browse This Page Directly</div>';

				redirectHome($theMsg);

			} 

			}// end post

elseif ($do == 'Delete') {

      echo "<h1 class='text-center'>Delete Location</h1>";
      echo "<div class='container'>";

        // Check If Get Request Catid Is Numeric & Get The Integer Value Of It

        $locid = isset($_GET['locid']) && is_numeric($_GET['locid']) ? intval($_GET['locid']) : 0;

        // Select All Data Depend On This ID

        $check = checkItem('Loc_ID', 'branches', $locid);

        // If There's Such ID Show The Form
        
        if ($check > 0) {

          $stmt = $con->prepare("DELETE FROM branches WHERE Loc_ID = :zid");

          $stmt->bindParam(":zid", $locid);

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

				//redirectHome($theMsg);

				echo "</div>";

			}


			echo "</div>";

		
 include $tpl . 'footer.php';

    } 