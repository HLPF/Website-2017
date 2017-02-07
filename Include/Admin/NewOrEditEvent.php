<?php
if(isset($_GET['id'])){
  $tempID = $db_conn->real_escape_string($_GET['id']);

  if($result = $db_conn->query("Select * From Event Where EventID = '$tempID'")){
    $row = $result->fetch_assoc();
    $EventExist = true;
  }
}

if(isset($_POST['Save'])) {
  
  $StartDate = strtotime($db_conn->real_escape_string($_POST['StartDate']));
  $EndDate   = strtotime($db_conn->real_escape_string($_POST['EndDate']));
  $Location  = $db_conn->real_escape_string($_POST['Location']);
  $Rules_ID  = $db_conn->real_escape_string($_POST['Rules']);
  $Title     = $db_conn->real_escape_string($_POST['Title']);
  $Pricegroups[] = $_POST['TypeList'];
  $Pricegroups = $Pricegroups[0]; // get the inner arrays
  $SelectedSeatmap  = $db_conn->real_escape_string($_POST['seatmap']);
  $WanSpeed  = $db_conn->real_escape_string($_POST['wan']);
  $LanSpeed  = $db_conn->real_escape_string($_POST['lan']);
  $Speed = $WanSpeed.'/'.$LanSpeed;
  # Poster
  if($_FILES['Poster']['error'] != 4){
  $AllowedFileTypeArray = array('jpg','png','gif');
  $Poster = ImageUploade('Poster','Images/EventPoster',$AllowedFileTypeArray);
  }
  # ======
  $PricegroupList = array();
  $temptGroup = array();
  $tempCount = 0;
  foreach($Pricegroups as $groupItem){
    
    $group = explode('|',$groupItem);
    
    $temptGroup['Type'] = $group[0];
    $temptGroup['Price'] = $group[1];
    $temptGroup['Start'] = strtotime($group[2]);
    $temptGroup['End'] = strtotime($group[3]);
    $PricegroupList[$tempCount] = $temptGroup;
    $tempCount++;
  }
  echo "<pre>";
  print_r($PricegroupList);
  echo "</pre>";
  
  if($action == 'Edit') {
    // edit Query
    /*if( $db_conn->query( " UPDATE Event 
                           SET Title = '$Title', StartDate = '$StartDate', EndDate = '$EndDate', Location = '$Location',
                               Network = '$Network', SeatsOpen = '$SeatsOpen', Rules = '$Rules_ID'
                           WHERE PageID = '$tempID'" 
                       )){header("Location: index.php?page=Admin&subpage=Event#admin_menu");}*/
  } else {
    // Create Query
    if($db_conn->query("INSERT INTO Event (Title,StartDate,EndDate,Location,Rules, Network, Seatmap, Poster)
                        VALUES ('$Title', '$StartDate', '$EndDate', '$Location', '$Rules_ID','$Speed','$SelectedSeatmap','$Poster')")){
      
      $TempEventIDResult = $db_conn->query("Select EventID FROM Event ORDER BY EventID DESC LIMIT 1");
      $TempEventID = $TempEventIDResult->fetch_assoc();
      $TempEventID = $TempEventID['EventID'];
      $tempCount = 0;
      foreach($PricegroupList as $item){
        
        $Type   = $item['Type'];
        $Price  = $item['Price'];
        $Start  = $item['Start'];
        $End    = $item['End'];
        
        $db_conn->query("INSERT INTO TicketPrices (EventID, StartTime, Type, EndTime, Price)
                                    VALUES ('$TempEventID', '$Start', '$Type', '$End', '$Price')");
      }
      
      
      header("Location: index.php?page=Admin&subpage=Event#admin_menu");
    }
  }
}
?>
<form method="post" class="form-group" enctype="multipart/form-data" action="">
  <div class="form-group col-lg-6">
    <label class="control-label" for="Title">Title</label>
    <input required class="form-control" type="text" name="Title" id="Title" value="<?php if(isset($EventExist)){echo $row['Title'];} ?>" maxlength="50"/>
  </div>
  <div class="form-group col-lg-3">
    <label class="control-label" for="StartDate">Start Dato</label>
    <input class="form-control form_datetime" required type="datetime-local" name="StartDate" id="StartDate" value="<?php if(isset($EventExist)){echo $row['StartDate'];} ?>" />
  </div>
  <div class="form-group col-lg-3">
    <label class="control-label" for="EndDate">Slut Dato</label>
    <input class="form-control form_datetime" required type="datetime-local" name="EndDate" id="EndDate" value="<?php if(isset($EventExist)){echo $row['EndDate'];} ?>" />
  </div>
  <div class="form-group col-lg-6">
    <label class="control-label" for="Location">Lokation</label>
    <input class="form-control" required type="text" name="Location" id="Location" value="<?php if(isset($EventExist)){echo $row['Location'];} ?>" />
  </div>
  <div class="form-group col-lg-6">
     <label class="control-label" for="RuleSetSelect">Regelsæt (Vælg en)</label>
    <?php 
    $GetRuleSets = $db_conn->query(" SELECT Pages.PageID, Pages.PageTitle, Pages.LastEditedDate 
                                           FROM Pages WHERE Pages.PageTitle like 'Reg%' ORDER BY Pages.LastEditedDate DESC");
    ?>
    <select name="Rules" class="form-control" id="RuleSetSelect">
      <?php while( $RuleSets = $GetRuleSets->fetch_assoc() ) { ?>
        <option value="<?php echo $RuleSets['PageID'] ?>"><?php echo $RuleSets['PageTitle'] . " --- Sidst ændret den " . date("d M Y", $RuleSets['LastEditedDate']); ?></option>
      <?php } ?>
    </select>
  </div>
  <div class="form-group col-lg-6">
    <label class="control-label" for="">Plads Layout (Vælg en)</label>
    <select required class="form-control" name="seatmap" id="seatmap">
      <option></option>
      <?php
        $GetSeatmaps = $db_conn->query("SELECT * FROM Seatmap");
        while($Seatmap = $GetSeatmaps->fetch_assoc()){
          echo '<option value="'.$Seatmap['SeatmapID'].'">'.$Seatmap['Name'].'</option>';
        }
      ?>
    </select>
  </div>
  <div class="form-group col-lg-3">
    <label class="control-label" for="StartDate">Ineternet Hastighed</label>
    <div class="input-group">
      <input class="form-control" name="wan" id="wan" placeholder="1024" type="text">
      <div class="input-group-addon">Mb</div>
    </div>
  </div>
  <div class="form-group col-lg-3">
    <label class="control-label" for="EndDate">Lokalt Netværks Hastighed</label>
    <div class="input-group">
      <input class="form-control" name="lan" id="lan" placeholder="100" type="text">
      <div class="input-group-addon">Mb</div>
    </div>
  </div>
  <div class="form-group col-lg-6">
    <div class="form-group">
    <label class="control-label" for="Type">Tilføj billet typer</label>
        <select class="form-control" type="text" placeholder="Type" class="" name="region" id="Type">
        <option></option>
        <?php 
          $TTypeResult = $db_conn->query("SELECT * FROM TicketTypes");
          while($TypeRow = $TTypeResult->fetch_assoc()){
            echo "<option value='".$TypeRow['Type']."'>".$TypeRow['Type']."</option>";
          }
        ?>
      </select>
    </div>
    <div class="form-inline">
      <div class="input-group">
        <input class="form-control" type="text" placeholder="150" size="2" class="" name="region" id="TypePrice" />
        <div class="input-group-addon">,-&nbsp;</div>
      </div>
      <div class="input-group">
      <input class="form-control form_datetime" placeholder="dd-mm-yyyy hh:mm" data-date-format="dd-mm-yyyy hh:ii" type="datetime" size="21" name="region" id="TypeStart" />
      <div class="input-group-addon">&#x1f4c5;</div>
      </div>
      <div class="input-group">
      <input class="form-control form_datetime" placeholder="dd-mm-yyyy hh:mm" data-date-format="dd-mm-yyyy hh:ii" type="datetime" size="21" name="region" id="TypeEnd" />
      <div class="input-group-addon">&#x1f4c5;</div>
      </div>
    </div>
    &nbsp;
    
    <input type="button" name="add" id="btn_AddToList" value="Tilføj" class="btn btn-success form-control" />
    <select size="10" class="form-control" name="TypeList[]" id="TypeList" multiple="multiple"></select>
    <input type="button" name="add" id="btn_RemoveFromList" value="Fjern" class="btn btn-danger form-control" />
    
    <script type="text/javascript">
      $(function(){
        $("#btn_AddToList").click(function(){
          var type      = $('#Type').val();
          var price     = $('#TypePrice').val();
          var startdate = $('#TypeStart').val();
          var enddate   = $('#TypeEnd').val();
          $('#TypeList').append('<option value="'+type+'|'+price+'|'+startdate+'|'+enddate+'">'+type+' | '+price+',- | '+startdate+' | '+enddate+'</option>');
          
          $('#Type').val('').focus();
          $('#TypePrice').val('');
          $('#TypeStart').val('');
          $('#TypeEnd').val('');
          
        });

        $('#btn_RemoveFromList').click(function(){
          var cr = confirm('Er du sikker på du vil fjerne de valgte fra listen?');
          if(cr == true){
           $('#TypeList > option:selected').each(function(){
            $(this).remove();
          }) 
          }
        });
      });
    </script>
  </div>
  <div class=" col-lg-6">
    <label class="control-label" for="Poster">Poster</label>
    <input class="" type="file" id="Poster" name="Poster">
  </div>  
  <div class="form-group col-lg-12">
    <script type="text/javascript">
    function selectAll() 
      { 
        selectBox = document.getElementById("TypeList");
        for (var i = 0; i < selectBox.options.length; i++) 
        { selectBox.options[i].selected = true; } 
      }
    </script>
    <input class="btn btn-primary" type="submit" value="Gem" name="Save" onclick="selectAll()" />
  </div>
</form>
