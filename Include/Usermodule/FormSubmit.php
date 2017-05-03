<?php
require_once("class/FileUpload.php");

########################### Feild Validations ##############################
# Standard Feils
$RegErroMSG = array();
$FormAOKAY = 0;
if($_POST['FullName'] == '')  {$RegErroMSG[] .='Fulde Navn'; $FormAOKAY = 1;}
if($_POST['Email'] == '')     {$RegErroMSG[] .='Email'; $FormAOKAY = 1;}
if($_POST['Birthday'] == '')  {$RegErroMSG[] .='Fødselsdag'; $FormAOKAY = 1;}
if($_POST['Username'] == '')  {$RegErroMSG[] .='Brugernavn'; $FormAOKAY = 1;}


if($page != 'EditMyProfile'){
  if($_POST['Password'] == '')  {$RegErroMSG[] .='Kodeord'; $FormAOKAY = 1;}
  if($_POST['CPassword'] == '') {$RegErroMSG[] .='Bekræft kodeord'; $FormAOKAY = 1;}
  if(!isset($_POST['ToS']))     {$RegErroMSG[] .='Bekræfte betingelserne'; $FormAOKAY = 1;}
}

if($_POST['Phone'] == '')     {$RegErroMSG[] .='Telefonnummer'; $FormAOKAY = 1;}
if($_POST['Address'] == '')   {$RegErroMSG[] .='Adresse'; $FormAOKAY = 1;}
if($_POST['Zipcode'] == '')   {$RegErroMSG[] .='Postnummer'; $FormAOKAY = 1;}
if($page != 'EditMyProfile')
{
  if($_POST['Password'] != $_POST['CPassword']){
    $FormAOKAY = 1;
    $RegErroMSG[] .= 'Kodeord & Bekræft Kodeord passed ikke sammen';
  }
}
if($page != 'EditMyProfile'){
  $tempUsername = $_POST['Username'];
  if($result = $db_conn ->query("SELECT Username FROM Users Where Username = '$tempUsername' AND Inactive = '0'")){
    if($result -> num_rows){
        $RegErroMSG[] .='Brugernavnet findes, beklager';
        $FormAOKAY = 1;
    }
  }
}

##################### Rember Submitted feilds content ###########################
$PreffereredUsername    = $_POST['Username'];
$FullName               = $_POST['FullName'];
$Birthday               = strtotime($_POST['Birthday']);
$Address                = $_POST['Address'];
$Zipcode                = $_POST['Zipcode'];
$NewClan                = $db_conn->real_escape_string($_POST['NewClan']);
$Email                  = $_POST['Email'];
$Phone                  = $_POST['Phone'];
$Clan                   = $db_conn->real_escape_string($_POST['Clan']);
$Bio                    = $_POST['Bio'];

######################## Clans ##################################################
if($NewClan == '' && $Clan == 0){
$finalClan = 0;
}

if($Clan != 0){
$finalClan = $Clan;
}else{
  if($NewClanExist = $db_conn->query("SELECT * FROM Clan WHERE Name = '$NewClan'")){
    if($NewClanExist->num_rows == 1){
      $NewClanExistRow = $NewClanExist->fetch_assoc();
      $finalClan = $NewClanExistRow['ClanID'];
    }else{
      if($db_conn->query("INSERT INTO Clan (Name) VALUES ('$NewClan')")){
        if($NewClanResult = $db_conn->query("SELECT * FROM Clan WHERE Name = '$NewClan'")){
          $NewClanRow = $NewClanResult->fetch_assoc();
          $finalClan = $NewClanRow['ClanID'];
        }
      }
    }
  }
}// end of clan stuff

if($FormAOKAY == 0){ // For sucessfull filled
    
  # Profile picture
  if(isset($_FILES['IMG']) && $_FILES['IMG']['error'] != 4 ){

    $AllowedFileTypeArray = array('jpg','png','gif', 'JEPG', 'JPG','jpeg');
    $PictureName = 'Images/Users/'.ImageUploade('IMG','Images/Users',$AllowedFileTypeArray);

    if(isset($_SESSION['UserID'])){
      $tempID = $_SESSION['UserID'];
      $querry = "Select Users.ProfileIMG From Users WHERE UserID = '$tempID'";
      if($result = $db_conn->query($querry)){
        $row = $result->fetch_assoc();
        if(!empty($row['ProfileIMG'])){
          unlink($row['ProfileIMG']);
        }
      }
    }
  }else{
    if(isset($_SESSION['PictureUrl'])){
      $PictureName = $_SESSION['PictureUrl'];
    }else{
      $PictureName = '';
    } 
  }
      
    // injection prevention
    $FullName   = $db_conn->real_escape_string($_POST['FullName']);
    $Email      = $db_conn->real_escape_string($_POST['Email']);
    $Birthday   = $db_conn->real_escape_string($_POST['Birthday']);
    $Username   = $db_conn->real_escape_string($_POST['Username']);
    if($page != 'EditMyProfile'){
        $Password   = $db_conn->real_escape_string($_POST['Password']);
        $CPassword  = $db_conn->real_escape_string($_POST['CPassword']);
        $ToS        = $db_conn->real_escape_string($_POST['ToS']);
        $PW = hash('sha512', $Password);
    }
    $Phone      = $db_conn->real_escape_string($_POST['Phone']);
    $Address    = $db_conn->real_escape_string($_POST['Address']);
    $Zipcode    = $db_conn->real_escape_string($_POST['Zipcode']);
    $Bio        = $db_conn->real_escape_string($_POST['Bio']);
    if(isset($_POST['NewsLetter'])){ $NewsLetter = $_POST['NewsLetter'];} else{$NewsLetter = 0;}
    $Birthday = strtotime($Birthday);

    if(isset($_SESSION['SocialNetwork'])){
        switch($_SESSION['SocialNetwork']){
            case 'steam':
                #$TokenRow      = 'SteamToken';
                $profileURLCol = 'SteamURL';
                $profileURL = $_SESSION['ProfileUrl'];
            break;
            case 'facebook':
                #$TokenRow      = 'FacebookToken';
                $profileURLCol = 'FacebookURL';
                $profileURL = $_SESSION['ProfileUrl'];
            break;
            case 'twitch':
                #$TokenRow      = 'TwitchToken';
                $profileURLCol = 'TwitchURL';
                $profileURL = $_SESSION['ProfileUrl'];
            break;
            case 'google':
                #$TokenRow      = 'GoogleToken';
                $profileURLCol = 'GoogleURL';
                $profileURL = $_SESSION['ProfileUrl'];
            break;
            case 'battlenet':
                #$TokenRow      = 'BattlenetToken';
                $profileURLCol = 'BattlenetID';
                $profileURL = $_SESSION['BattleTag'];
            break;
        }
    }
    if($page == 'EditMyProfile'){ // user edits own informations

      if($db_conn->query("UPDATE Users SET Username = '$Username', FullName = '$FullName', ZipCode = '$Zipcode',
                                          Birthdate = '$Birthday', Email = '$Email', Bio = '$Bio',
                                          Address = '$Address', Phone = '$Phone', NewsLetter = '$NewsLetter',
                                          ClanID = '$finalClan', ProfileIMG = '$PictureName'
                          WHERE UserID = '$UserID'")){}
          header("Location: index.php?page=EditMyProfile");
    }
    else // user creation
    {
        $CreateTime = time();

        $token = $_SESSION['UserToken'];
        if($db_conn->query("INSERT INTO `Users`(Username, FullName, ZipCode, Birthdate, Created, Email, Bio, Admin,
                             Address, PW, Phone, OneallUserToken, $profileURLCol, NewsLetter, ClanID, ProfileIMG)
                             VALUES
                             ('$Username','$FullName','$Zipcode', '$Birthday','$CreateTime','$Email', '$Bio','0',
                              '$Address','$PW','$Phone','$token','$profileURL', '$NewsLetter','$finalClan', '$PictureName')"))
        {

            if($result = $db_conn ->query("Select Users.UserID, Users.Admin From Users Where Users.Username = '$Username' AND Inactive = '0'")){
              $row = $result->fetch_assoc();
              $tempUserID = $row['UserID'];
              // unset SESSION there was sat by the Scocial login in Oneall_callback_handler.php since the will not be used any more after cration of the user.
              if(isset($_SESSION['SocialNetwork'])){unset($_SESSION['SocialNetwork']);}
              if(isset($_SESSION['UserToken'])){unset($_SESSION['UserToken']);}
              if(isset($_SESSION['ProfileUrl'])){unset($_SESSION['ProfileUrl']);}
              if(isset($_SESSION['FullName'])){unset($_SESSION['FullName']);}
              if(isset($_SESSION['Email'])){unset($_SESSION['Email']);}
              if(isset($_SESSION['PictureUrl'])){unset($_SESSION['PictureUrl']);}
              if(isset($_SESSION['BattleTag'])){unset($_SESSION['BattleTag']);}
              if(isset($_SESSION['PreffereredUsername'])){unset($_SESSION['PreffereredUsername']);}

              echo $_SESSION['UserID'] = $tempUserID;
              echo $_SESSION['Admin'] = $row['Admin'];
              echo $_SESSION['OneAllToken'] = $token;
              $LastLogin = time();
              if($db_conn->query("UPDATE Users SET LastLogin = '$LastLogin' WHERE UserID = '$tempUserID'")){ echo 'Senest login opdatert';}else{echo 'Senest login Ikke opdatert';}
              header("Location: index.php?page=EditMyProfile");
            }else{echo 'find ny bruger fejled';}
        }else {echo 'opret fejled';}
    }
} // if formOKAY end
?>