<?php
  $RegErroMSG = array();
  $FormAOKAY = 0;
  if($_POST['CategoryName'] == '')        {$RegErroMSG[] .='Kategori navn'; $FormAOKAY = 1;}
  if($_POST['CategoryDesc'] == '')        {$RegErroMSG[] .='Kategori beskrivelse'; $FormAOKAY = 1;}
  $CreateTime = time();

  $CategoryName  = $_POST['CategoryName'];
  $CategoryDesc  = $_POST['CategoryDesc'];

  if($FormAOKAY == 0){
    // For successfully filled
    // injection prevention
    $CategoryName   = $db_conn->real_escape_string($_POST['CategoryName']);
    $CategoryDesc   = $db_conn->real_escape_string($_POST['CategoryDesc']);

    if($db_conn->query("INSERT INTO ForumCategory (Name, Descrition, CreationDate) VALUES ('$CategoryName', '$CategoryDesc', $CreateTime)")){}
  } // if formOKAY end
?>

<!-- Just make insert into, post has nothing to do with it -->