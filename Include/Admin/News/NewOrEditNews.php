<?php 
if(isset($_GET['id']) && $_GET['id'] != ''){
  $ID = $db_conn->real_escape_string($_GET['id']);
}

if(isset($_POST['Save'])){ // is the form submitted
  // gather up the information
    $Title          = $db_conn->real_escape_string($_POST['title']);
    $Content        = $db_conn->real_escape_string($_POST['AdminTinyMCE']);
    $PublishDate    = $db_conn->real_escape_string($_POST['publishdate']);
    echo $PublishDate    = strtotime($PublishDate);
    if(isset($_POST['Online'])){ $Online = 1; }else{ $Online = 0;}
    $LastEidtedID   = $_SESSION['UserID'];
    $LastEditedDate = time();
  
  if($action == 'Edit'){
    // are we editing
    $db_conn->query("UPDATE News SET Title = '$Title', Content = '$Content', 
                                     LastEditedID = '$LastEidtedID', LastEditedDate = '$LastEditedDate',
                                     PublishDate = '$PublishDate', Online = '$Online'
                                 WHERE NewsID = '$ID'");
  }else{
    // this is a new news entry
    $db_conn->query("INSERT INTO News (Title, Content, AuthorID, LastEditedID, CreatedDate, LastEditedDate, PublishDate, Online)
                  Values('$Title', '$Content', '$LastEidtedID', '$LastEidtedID', '$LastEditedDate', '$LastEditedDate',  '$PublishDate', '$Online')");
  }
  header("location: index.php?page=Admin&subpage=News#admin_menu");
}

if($action == 'Edit'){
  $result = $db_conn->query("SELECT * FROM News WHERE NewsID = '$ID'");
  $row = $result->fetch_assoc();
  $OutTitle       = $row['Title'];
  $OutContent     = $row['Content'];
  $OutPuplishDate = date("d-m-Y G:i", $row['PublishDate']);
  if($row['Online'] == '1'){$OutOnline = $row['Online'];}
}
?>
<!-- Missing the form -->
<table class="table hlpf_adminmenu">
  <form method="post" class="form-group" action="">
    <div class="form-group col-lg-6">
      <label class="control-label" for="Title">Title:</label>
      <input class="form-control" required type="text" name="title" id="Title" value="<?php if(isset($OutTitle)){ echo $OutTitle;} ?>" maxlength="50"/>
    </div>
    <div class="form-group col-lg-3">
      <label class="control-label" for="publishdate">Offenligørelses dato:</label>
       <input type="datetime" data-date="12-02-2012 23:59" data-date-format="dd-mm-yyyy hh:ii" class="form-control form_datetime" id="publishdate" name="publishdate" value="<?php if(isset($OutPuplishDate)){echo $OutPuplishDate;} ?>">
        <span class="add-on"><i class="icon-remove"></i></span>
        <span class="add-on"><i class="icon-th"></i></span>
    </div>
    <div class="form-group form-inline col-lg-3">
      <label class="" for="Online">Online: </label>
      <input class="" type="checkbox" id="Online" name="Online" <?php if(isset($OutOnline)){echo 'checked';} ?> value="1">
    </div>
    <div class="form-group col-lg-12">
      <textarea class="from-control" id="AdminTinyMCE" name="AdminTinyMCE"><?php if(isset($OutContent)){echo $OutContent;} ?></textarea>
    </div>
    <div class="from-group col-lg-12 text-center">
      <input class="btn btn-default" type="submit" value="Gem" name="Save" />
    </div>
  </form>
</table>
