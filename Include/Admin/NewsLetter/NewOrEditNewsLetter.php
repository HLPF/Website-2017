<?php
require_once("class/SendMail.php");
if(isset($_GET['id'])){$URLID = $db_conn->real_escape_string($_GET['id']);}
if(isset($_POST['Save'])){
  $Title = $db_conn->real_escape_string($_POST['Title']);
  if(isset($_POST['Send'])){$Send = $db_conn->real_escape_string($_POST['Send']);}else {$Send = '0';}
  $Body  = $_POST['AdminTinyMCE'];
  $Aurthor = $_SESSION['UserID'];
  if($action == 'Edit'){
    if($Send == 1){

      $NewsResult = $db_conn->query("SELECT Users.FullName, Users.Email, Users.NewsLetter FROM Users WHERE Users.NewsLetter = 1");
        while($NewsRow = $NewsResult->fetch_assoc()){
          // Send mail
          SendMail($NewsRow["Email"],$NewsRow["FullName"],$Title,$Body,$_GLOBAL);
          //echo "<hr>";
        }// End of Users that want news
      // Insert querry
    if($Send != '0'){$Send = time();}
    $db_conn->query("UPDATE NewsLetter SET Subject = '$Title', Body = '$Body', SentDate = '$Send', Author = '$Aurthor'
                     WHERE LetterID = '$URLID'");
    }// if $Send = 1
    else{
      $db_conn->query("UPDATE NewsLetter SET Subject = '$Title', Body = '$Body', SentDate = '0', Author = '$Aurthor'
                     WHERE LetterID = '$URLID'");
    }

    // update querry
    //$db_conn->query("UPDATE NewsLetter SET Subject = '$Title', Body = '$Body', SentDate = '$Send', Author = '$Aurthor'
      ///               WHERE LetterID = '$URLID'");
    header("Location: index.php?page=Admin&subpage=NewsLetter#admin_menu");
  }else{
    if($Send == 1){

      $NewsResult = $db_conn->query("SELECT Users.FullName, Users.Email, Users.NewsLetter FROM Users WHERE Users.NewsLetter = 1");
        while($NewsRow = $NewsResult->fetch_assoc()){
          // Send mail
          SendMail($NewsRow["Email"],$NewsRow["FullName"],$Title,$Body,$_GLOBAL);
          //echo "<hr>";
        }// End of Users that want news
      
      // Insert querry
    if($Send != '0'){$Send = time($Send);}
    $db_conn->query("INSERT INTO NewsLetter (Subject, Body, SentDate, Author)
                                     VALUES ('$Title','$Body','$Send','$Aurthor')");
    }// if $Send = 1
    else{
      $db_conn->query("INSERT INTO NewsLetter (Subject, Body, SentDate, Author)
                                     VALUES ('$Title','$Body','0','$Aurthor')");
    }
  }// if action is not Edit
  header("Location: index.php?page=Admin&subpage=NewsLetter#admin_menu");
}// if submmit send

// edit or template
if(isset($_GET['action']) && ( ($_GET['action'] == 'Edit') || ($_GET['action'] == 'Template') ) ){
  $URLID = $db_conn->real_escape_string($_GET['id']);
  $action = $db_conn->real_escape_string($_GET['action']);
  $result = $db_conn->query("SELECT Subject, Body, SentDate FROM NewsLetter WHERE LetterID = '$URLID'");
  $row = $result->fetch_assoc();
  if( ($action == 'Edit') && ($row['SentDate'] > 0) ){
    $LetterExist = 0;
    //echo '<b><p class="text-center"> Det valgte nyheds brev kan ikke redigers, da det er blevet udsendt</p></b>';
    header("Location: index.php?page=Admin&subpage=NewsLetter#admin_menu"); // back to newsletter list
  }else{
    $LetterExist = 1;
    $Subject  = $row['Subject'];
    $Body     = $row['Body'];
    $sent     = $row['SentDate'];
  }
}

if( (isset($LetterExist) && $LetterExist == 1) || $action == 'New')
{
?>
<form method="post" action="">
  <div class="form-group col-lg-6">
    <label class="control-label" for="Title">Emne: </label>
    <input class="form-control" type="text" maxlength="50" name="Title" id="Title" required size="50" value="<?php if($action == 'Edit'){echo $Subject;} ?>">
  </div>
  <div class="form-group form-inline col-lg-6">
    <label>Udsend:</label> 
    <input type="checkbox" value="1" name="Send">
  </div>
  <div class="form-group col-lg-12">
    <textarea rows="25" id="AdminTinyMCE" name="AdminTinyMCE"><?php if(isset($LetterExist)){echo $Body;} ?></textarea>
  </div>
  <div class="form-group text-center col-lg-12">
    <input class="btn btn-default" type="submit" value="Gem" name="Save" />
  </div>
</form>
<?php
}
?>

