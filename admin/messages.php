<?php


/**


This is messages page 

**/

ob_start(); // Output Buffering Start

  session_start();
if (isset($_SESSION['Username'])) {

    include 'init.php';

$do = isset($_GET['do']) ? $_GET['do'] : 'Manage';


if ($do == 'Manage') {
?>


<div class="tab-content">
  <div class="tab-pane active" id="inbox">
      
      <div class="container">
           <div class="content-container clearfix">
               <div class="col-md-12">
                   <h1 class="content-title">Inbox</h1>
                   
                

<?php
                    $stmt  = $con->prepare("SELECT * FROM messages");
				    $stmt->execute();
				    $msgs = $stmt->fetchAll(); 
				    foreach($msgs as $msg){?>
                   <ul class="mail-list">
                       <li>
                       	 <a href="messages.php?do=show&msgId=<?php echo $msg['MsgID'];?>">
                               <span class="mail-sender"><?php echo $msg['Name']; ?>
                               </span>
                               <br>
                                <span class="mail-sender"><?php echo $msg['Email']; ?></span>
                                <br>
                                 <span class="mail-sender"><?php echo $msg['Phone']; ?></span>
                                 <br>
                                  <span class="mail-sender"><?php echo $msg['Date']; ?></span>
                                  <br>
                                  <?php

                                 echo "<a href='messages.php?do=Delete&msgid=" . $msg['MsgID'] . "' class='btn btn-danger confirm'><i class='fa fa-close'></i> Delete </a>";

                                  ?>
                    </span>

                               <br>
                       </li>
                       <li>
                       </li>
                   </ul>
 
                   <?php            
               } ?>
               </div>
           </div>
       </div>
   </div>
</div>



                      <?php 
} // end manage

elseif($do == 'show'){

	$msgId = isset($_GET['msgId']) && is_numeric($_GET['msgId']) ? intval($_GET['msgId']) : 0;

	$stmt = $con->prepare("SELECT Message , Subject FROM messages WHERE MsgID = ? ");

	 $stmt->execute(array($msgId));

      // Fetch The Data

      $msgs2 = $stmt->fetchAll();

      // The Row Count

      $count = $stmt->rowCount();
       if ($count > 0){

        foreach($msgs2 as $msg2){
        ?>


		<div class="ms panel panel-default">
		  <div class="panel-heading">
		    <h3 class="panel-title"><?php echo $msg2['Subject']; ?></h3>
		  </div>
		  <div class="panel-body">
		    <?php echo $msg2['Message']; ?>
		  </div>
		</div>

<?php
}
}
}
elseif($do == 'Delete'){
  
  echo "<h1 class='text-center'>Delete Message</h1>";
      echo "<div class='container'>";

        // Check If Get Request Catid Is Numeric & Get The Integer Value Of It

        $msgid = isset($_GET['msgid']) && is_numeric($_GET['msgid']) ? intval($_GET['msgid']) : 0;

        // Select All Data Depend On This ID

        $check = checkItem('MsgID', 'messages', $msgid);

        // If There's Such ID Show The Form
        
        if ($check > 0) {

          $stmt = $con->prepare("DELETE FROM messages WHERE MsgID = :zid");

          $stmt->bindParam(":zid", $msgid);

          $stmt->execute();

          $theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . ' Record Deleted</div>';

          redirectHome($theMsg, 'back');

        }
      }
     
      


       else {

        echo "<div class='container'>";

        $theMsg = '<div class="alert alert-danger">Sorry You Cant Browse This Page Directly</div>';

        redirectHome($theMsg);

        echo "</div>";

      }


      echo "</div>";

    





} // end session

include $tpl . 'footer.php';