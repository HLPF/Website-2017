<?php
function TorGetUserName($TempUserID, $DBCONN){
  $Func_result = $DBCONN->query("SELECT Username from Users Where UserID = '$TempUserID'");
  $Func_row = $Func_result->fetch_assoc();
  return $Func_row['Username'];
}
?>
<a style="display:block;" href="#DoSomethingSomehow" class="btn btn-info">Opret nyhed</a>
<hr>
<table class="table table-striped table-hover hlpf_adminmenu">
  <thead>
    <tr>
      <th class="text-center">ID</th>
      <th class="text-center">Title</th>
      <th class="text-center">Lavet af</th>
      <th class="text-center">Sidst ændret af</th>
      <th class="text-center">Lavet den</th>
      <th class="text-center">Sidst ændret den</th>
      <th class="text-center">Online</th>
      <th class="text-center">Rediger</th>
    </tr>
  </thead>
  <tbody>
<?php
    $result = $db_conn->query("SELECT * FROM News");
    while ($row = $result->fetch_assoc()) 
{ ?>
    <tr>
      <td class="text-center">
        <?php echo $row['NewsID']; ?>
      </td>
      <td class="text-center">
        <?php echo $row['Title']; ?>
      </td>
      <td class="text-center">
        <?php echo TorGetUserName($row['AuthorID'], $db_conn); ?>
      </td>
      <td class="text-center">
        <?php echo TorGetUserName($row['LastEditedID'], $db_conn); ?>
      </td>
      <td class="text-center">
        <?php echo date("d M Y", $row['CreatedDate']); ?>
      </td>
      <td class="text-center">
        <?php echo date("d M Y", $row['LastEditedDate']); ?>
      </td>
      <td class="text-center">
        <?php
          if($row['PublishDate'] <= time()){
           echo '<span style="display:block;" class="btn disabled btn-success">'.date("d M Y", $row['PublishDate']).'</span>';
          }else{
            echo '<span style="display:block;" class="btn disabled btn-danger">'.date("d M Y", $row['PublishDate']).'</span>';
          }
        ?>
      </td>
      <td class="text-center">
        <a href="" style="display:block;" class="btn btn-warning">Rediger</a>
      </td>
    </tr>
<?php 
} 
?>
  </tbody>
</table>
