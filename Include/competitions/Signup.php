<?php
$CompID = mysqli_real_escape_string($db_conn,strip_tags($_GET['id']));
$comps = $db_conn->query("Select * From CompetitionGames Inner Join Competitions On Competitions.GameID = CompetitionGames.GameID
                          Inner Join Event On Competitions.EventID = Event.EventID Where ID  = $CompID LIMIT 1");
$row = $comps->fetch_assoc();
?>

<div class="row thumbnail">
  <div class="col-lg-4 LanCMSContentbox text-center">
    <img width="" class="" src="Images/games/<?= $row['Image']; ?>" />
  </div>
  <div class="col-lg-8 LanCMSContentbox">
    <h2 style="">
      <?= $row['GameName'].' '.$row['TeamSize'].' VS '.$row['TeamSize'].' '; ?>
    </h2>
      <h5 style="float:left;">Event: <?= $row['Title']; ?></h5>
    <hr style="clear:both;" />
    <div class="row">
      <div class="col-lg-3"><b>Tilmeldte: ?/<?= $row['MaxSignups']; ?></b></div>
      <div class="col-lg-4">
            <b>
              Tunering Starter: <?php echo date('d.M - H:i', $row['CompStart'] ); ?>
            </b>
      </div>
      <div class="col-lg-2"></div>
      <div class="col-lg-3">
      </div>
    </div>
    <hr style="clear:both;" />
    <?= $row['DescText']; ?>  
  </div>
  
  <div class="col-lg-12">
    <hr />
    
    <table class="table table-striped table-consensed">
      <tr>
        <td><label></label></td>
        <td></td>
      </tr>
    </table>
    
    
  </div>
  
</div>