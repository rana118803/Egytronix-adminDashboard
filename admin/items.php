<?php

		/*
			================================================
			== Items Page
			================================================
		*/
ob_start(); // Output Buffering Start

session_start();

if (isset($_SESSION['Username'])) {

		include 'init.php';

	$do = isset($_GET['do']) ? $_GET['do'] : 'Manage';

	/// Start Item Page :

if ($do == 'Manage') {

			$stmt = $con->prepare("SELECT 
										items.*, 
										categories.Name AS category_name
									FROM 
										items
									INNER JOIN 
										categories 
									ON 
										categories.ID = items.Cat_ID
									ORDER BY 
										Item_ID DESC");

			
			// Execute The Statement

			$stmt->execute();

			// Assign To Variable 

			$items = $stmt->fetchAll();

			if (! empty($items)) {

			?>

<h1 class="text-center">Manage Items</h1>
			<div class="container">
				<div class="table-responsive">
					<table class="main-table text-center table table-bordered">
						<tr>
							
							<td>Item Name</td>
							<td>Description</td>
							<td>Adding Date</td>
							<td>Category</td>
							<td>Image</td>
							<td>تحكم</td>

						</tr>
						<?php
							foreach($items as $item) {
								echo "<tr>";
									echo "<td>" . $item['Name'] . "</td>";
									echo "<td>" . $item['Description'] . "</td>";
									echo "<td>" . $item['Add_Date'] ."</td>";
									echo "<td>" . $item['category_name'] ."</td>";
									echo "<td>" ;

									if (empty($row['Avatar'])) {
										echo 'No Image';
									} else {
										echo "<img src='uploads/avatars/" . $row['Avatar'] . "' alt='' />";
									}
								  echo	"</td>";
									echo "<td>
										<a href='items.php?do=Edit&itemid=" . $item['Item_ID'] . "' class='btn btn-success'><i class='fa fa-edit'></i> Edit</a>
										<a href='items.php?do=Delete&itemid=" . $item['Item_ID'] . "' class='btn btn-danger confirm'><i class='fa fa-close'></i> Delete </a>";
									echo "</td>";
								echo "</tr>";
							}
						?>
						<tr>
					</table>
				</div>
				<a href="items.php?do=Add" class="btn btn-sm btn-primary">
					<i class="fa fa-plus"></i> New Item
				</a>
			</div>

			<?php } else {

				echo '<div class="container">';
					echo '<div class="nice-message">There\'s No Items To Show</div>';
					echo '<a href="items.php?do=Add" class="btn btn-sm btn-primary">
							<i class="fa fa-plus"></i> New Item
						</a>';
				echo '</div>';

			} /// end if !empty ?> 

		<?php 

		} /// end manage 


		elseif ($do == 'Add') { ?>

			<h1 class="text-center">Add New Item</h1>
			<div class="container">
				<form class="form-horizontal" action="?do=Insert&itemid=?" method="POST"enctype="multipart/form-data">
					<!-- Start Name Field -->
					<div class="form-group form-group-lg">
						<label class="col-sm-2 control-label">Name</label>
						<div class="col-sm-10 col-md-6">
							<input 
								type="text" 
								name="name" 
								class="form-control" 
								required="required"  
								placeholder="Name of The Item" />
						</div>
					</div>
					<!-- End Name Field -->
					<!-- Start Description Field -->
					<div class="form-group form-group-lg">
						<label class="col-sm-2 control-label">Description</label>
						<div class="col-sm-10 col-md-6">
							<input 
								type="text" 
								name="description" 
								class="form-control" 
								required="required"  
								placeholder="Description of The Item" />
						</div>
					</div>
					<!-- End Description Field -->
					<!-- Start Status Field -->
					<div class="form-group form-group-lg">
						<label class="col-sm-2 control-label">Status</label>
						<div class="col-sm-10 col-md-6">
							<select name="status">
								<option value="0">...</option>
								<option value="1">New</option>
								<option value="2">Old</option>
							</select>
						</div>
					</div>
					<!-- End Status Field -->
					<!-- Start Categories Field -->
					<div class="form-group form-group-lg">
						<label class="col-sm-2 control-label">Category</label>
						<div class="col-sm-10 col-md-6">
							<select name="category">
								<option value="0">...</option>
								<?php
									$allCats = getAllFrom("*", "categories","" , "", "ID");
									foreach ($allCats as $cat) {
										echo "<option value='" . $cat['ID'] . "'>" . $cat['Name'] . "</option>";
									}
								?>
							</select>
						</div>
					</div>
					<!-- End Categories Field -->
					<!-- Start Tags Field -->
					<div class="form-group form-group-lg">
						<label class="col-sm-2 control-label">Tags</label>
						<div class="col-sm-10 col-md-6">
							<input 
								type="text" 
								name="tags" 
								class="form-control" 
								placeholder="Separate Tags With Comma (,)" />
						</div>
					</div>
					<!-- End Tags Field -->
					<!-- Start Description Field -->
					<div class="form-group form-group-lg">
						<label class="col-sm-2 control-label">Description</label>
						<div class="col-sm-10 col-md-6">
							<input 
								type="text" 
								name="description" 
								class="form-control" 
								required="required"  
								placeholder="Description of The Item" />
						</div>
					</div>
					<!-- End Description Field -->
					<!-- Start Description Field -->
					<div class="form-group form-group-lg">
						<label class="col-sm-2 control-label">Image</label>
						<div class="col-sm-10 col-md-6">
							<input 
								type="FILE" 
								name="avatar" 
								class="form-control" 
								required="required"  
								placeholder="Description of The Item" />
						</div>
					</div>
					<!-- End Description Field -->
					<!-- Start Submit Field -->
					<div class="form-group form-group-lg">
						<div class="col-sm-offset-2 col-sm-10">
							<input type="submit" value="Add Item" class="btn btn-primary btn-sm" />
						</div>
					</div>
					<!-- End Submit Field -->
				</form>
			</div>

			<?php

		} /// end add 
		elseif ($do == 'Insert') {

			if ($_SERVER['REQUEST_METHOD'] == 'POST') {

				echo "<h1 class='text-center'>Insert Item</h1>";
				echo "<div class='container'>";

				// Get Variables From The Form

				$name		= $_POST['name'];
				$desc 		= $_POST['description'];
				$status 	= $_POST['status'];
				$cat 		= $_POST['category'];
				$tags 		= $_POST['tags'];
				$formErrors = array();
				$avatarName = $_FILES['avatar']['name'];
				$avatarSize = $_FILES['avatar']['size'];
				$avatarTmp	= $_FILES['avatar']['tmp_name'];
				$avatarType = $_FILES['avatar']['type'];
				$avatarAllowedExtension = array("jpeg", "jpg", "png", "gif");

				// Get Avatar Extension

				//$avatarExtension = strtolower(end(explode('.', $avatarName)));


				if (empty($name)) {
					$formErrors[] = 'Name Can\'t be <strong>Empty</strong>';
				}

				if (empty($desc)) {
					$formErrors[] = 'Description Can\'t be <strong>Empty</strong>';
				}


				if ($status == 0) {
					$formErrors[] = 'You Must Choose the <strong>Status</strong>';
				}

				if ($cat == 0) {
					$formErrors[] = 'You Must Choose the <strong>Category</strong>';
				}

				// Loop Into Errors Array And Echo It
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
					move_uploaded_file($avatarTmp, "uploads\avatars\\"  . $avatarName);
					//move_uploaded_file($avatarTmp, "uploads\edits\\" . $avatarName);
				

				// Check If There's No Error Proceed The Update Operation


					// Insert Userinfo In Database

					$stmt = $con->prepare("INSERT INTO 

						items(Name, Description, Status, Add_Date, Cat_ID, tags,Avatar)

						VALUES(:zname, :zdesc, :zstatus, now(), :zcat, :ztags,:zavatar)");

					$stmt->execute(array(

						'zname' 	=> $name,
						'zdesc' 	=> $desc,
						'zstatus' 	=> $status,
						'zcat'		=> $cat,
						'ztags'		=> $tags,
						'zavatar'   => $avatarName

					));

					// Echo Success Message

					$theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . ' Record Inserted</div>';

					redirectHome($theMsg, 'back');

				}

			} else {

				echo "<div class='container'>";

				$theMsg = '<div class="alert alert-danger">Sorry You Cant Browse This Page Directly</div>';

				redirectHome($theMsg);

				echo "</div>";

			}

			echo "</div>";

		} /// end Insert

		elseif ($do == 'Edit') {

			// Check If Get Request item Is Numeric & Get Its Integer Value

			$itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0;

			// Select All Data Depend On This ID

			$stmt = $con->prepare("SELECT * FROM items WHERE Item_ID = ?");

			// Execute Query

			$stmt->execute(array($itemid));

			// Fetch The Data

			$item = $stmt->fetch();

			// The Row Count

			$count = $stmt->rowCount();

			// If There's Such ID Show The Form

			if ($count > 0) { ?>

				<h1 class="text-center">Edit Item</h1>
				<div class="container">
					<form class="form-horizontal" action="?do=Update&itemid=?" method="POST"enctype="multipart/form-data">
						<input type="hidden" name="itemid" value="<?php echo $itemid ?>" />
						<!-- Start Name Field -->
						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label">Name</label>
							<div class="col-sm-10 col-md-6">
								<input 
									type="text" 
									name="name" 
									class="form-control" 
									required="required"  
									placeholder="Name of The Item"
									value="<?php echo $item['Name'] ?>" />
							</div>
						</div>
						<!-- End Name Field -->
						<!-- Start Description Field -->
						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label">Description</label>
							<div class="col-sm-10 col-md-6">
								<input 
									type="text" 
									name="description" 
									class="form-control" 
									required="required"  
									placeholder="Description of The Item"
									value="<?php echo $item['Description'] ?>" />
							</div>
						</div>
						<!-- End Description Field -->
						<!-- Start Status Field -->
						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label">Status</label>
							<div class="col-sm-10 col-md-6">
								<select name="status">
									<option value="1" <?php if ($item['Status'] == 1) { echo 'selected'; } ?>>New</option>
									<option value="2" <?php if ($item['Status'] == 2) { echo 'selected'; } ?>>Old</option>
								</select>
							</div>
						</div>
						<!-- End Status Field -->
						<!-- Start Categories Field -->
						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label">Category</label>
							<div class="col-sm-10 col-md-6">
								<select name="category">
									<?php
										$allCats = getAllFrom("*", "categories","", "", "ID");
										foreach ($allCats as $cat) {
											echo "<option value='" . $cat['ID'] . "'";
											if ($item['Cat_ID'] == $cat['ID']) { echo ' selected'; }
											echo ">" . $cat['Name'] . "</option>";
										}
									?>
								</select>
							</div>
						</div>
						<!-- End Categories Field -->
						<!-- Start Tags Field -->
						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label">Tags</label>
							<div class="col-sm-10 col-md-6">
								<input 
									type="text" 
									name="tags" 
									class="form-control" 
									placeholder="Separate Tags With Comma (,)" 
									value="<?php echo $item['tags'] ?>" />
							</div>
						</div>
						<!-- End Tags Field -->
						<!-- Start Name Field -->
						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label">Name</label>
							<div class="col-sm-10 col-md-6">
								<input 
									type="File" 
									name="avatar" 
									class="form-control" 
									required="required"  
									placeholder="Image Of Item"
									value="<?php echo $item['Avatar'] ?>" />
							</div>
						</div>
						<!-- End Name Field -->
						<!-- Start Submit Field -->
						<div class="form-group form-group-lg">
							<div class="col-sm-offset-2 col-sm-10">
								<input type="submit" value="Save Item" class="btn btn-primary btn-sm" />
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

elseif ($do == 'Update') {

			echo "<h1 class='text-center'>Update Item</h1>";
			echo "<div class='container'>";

			if ($_SERVER['REQUEST_METHOD'] == 'POST') {

				// Get Variables From The Form

				$id 		= $_POST['itemid'];
				$name 		= $_POST['name'];
				$desc 		= $_POST['description'];
				$status 	= $_POST['status'];
				$cat 		= $_POST['category'];
				$tags 		= $_POST['tags'];
				$formErrors = array();
				$avatarName = $_FILES['avatar']['name'];
				$avatarSize = $_FILES['avatar']['size'];
				$avatarTmp	= $_FILES['avatar']['tmp_name'];
				$avatarType = $_FILES['avatar']['type'];
				$avatarAllowedExtension = array("jpeg", "jpg", "png", "gif");

				// Get Avatar Extension

				//$avatarExtension = strtolower(end(explode('.', $avatarName)));


				

				if (empty($name)) {
					$formErrors[] = 'Name Can\'t be <strong>Empty</strong>';
				}

				if (empty($desc)) {
					$formErrors[] = 'Description Can\'t be <strong>Empty</strong>';
				}

				if ($status == 0) {
					$formErrors[] = 'You Must Choose the <strong>Status</strong>';
				}


				if ($cat == 0) {
					$formErrors[] = 'You Must Choose the <strong>Category</strong>';
				}


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



					
				// Validate The Form

				// Loop Into Errors Array And Echo It

				foreach($formErrors as $error) {
					echo '<div class="alert alert-danger">' . $error . '</div>';
				}

				// Check If There's No Error Proceed The Update Operation

				if (empty($formErrors)) {

					// Update The Database With This Info
					move_uploaded_file($avatarTmp, "uploads\avatars\\" . $avatarName);
					//move_uploaded_file($avatarTmp, "uploads\edits\\" . $avatarName);


					$stmt = $con->prepare("UPDATE 
												items 
											SET 
												Name = ?, 
												Description = ?, 
												Status = ?,
												Cat_ID = ?,
												tags = ?,
												Avatar =?
											WHERE 
												Item_ID = ?");

					$stmt->execute(array($name, $desc,  $status, $cat, $tags,$avatarName, $id));

					// Echo Success Message

					$theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . ' Record Updated</div>';

					redirectHome($theMsg, 'back');

				}

			} else {

				$theMsg = '<div class="alert alert-danger">Sorry You Cant Browse This Page Directly</div>';

				redirectHome($theMsg);

			}

			echo "</div>";

		} /// end update 

		elseif ($do == 'Delete') {

			echo "<h1 class='text-center'>Delete Item</h1>";
			echo "<div class='container'>";

				// Check If Get Request Item ID Is Numeric & Get The Integer Value Of It

				$itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0;

				// Select All Data Depend On This ID

				$check = checkItem('Item_ID', 'items', $itemid);

				// If There's Such ID Show The Form

				if ($check > 0) {

					$stmt = $con->prepare("DELETE FROM items WHERE Item_ID = :zid");

					$stmt->bindParam(":zid", $itemid);

					$stmt->execute();

					$theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . ' Record Deleted</div>';

					redirectHome($theMsg, 'back');

				} else {

					$theMsg = '<div class="alert alert-danger">This ID is Not Exist</div>';

					redirectHome($theMsg);

				}

			echo '</div>';

		} /// end delete



 include $tpl . 'footer.php';
} /// End session