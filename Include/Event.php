<?php
  # Latest event - Get the ID.
  $event = $db_conn->query("SELECT e.Title, e.EventID, e.Poster, e.StartDate, e.EndDate, e.Location, e.Network, e.Seatmap, e.Rules FROM Event as e ORDER BY e.EventID DESC LIMIT 1");
  if( $event -> num_rows ) { $eventrows = $event->fetch_assoc(); }
  //var_dump($eventrows);
  # Query
  $SqlPricesQuery = "SELECT * FROM TicketPrices as tp WHERE tp.EventID = " . $eventrows["EventID"] . " ORDER BY tp.Type, tp.StartTime ASC";

  $SqlPricesPeriods = "SELECT * FROM TicketPrices as tp WHERE tp.EventID = " . $eventrows["EventID"] . " AND tp.Type = " . $DistinctEventPriceTypes["Type"] . " ORDER BY tp.Type, tp.StartTime ASC";
  var_dump($SqlPricesPeriods);
   // May need to remove this + db_conn->query

/*
  $PeriodsInEventPerType =
  SELECT tp.StartTime, tp.EndTime FROM TicketPrices as tp WHERE tp.EventID = $eventrows["EventID"] AND tp.Type = $type["Type"] ORDER BY tp.StartTime ASC
  # Member price info
  /*$SqlPricesMemberQuery = "SELECT * FROM TicketPrices WHERE TicketPrices.EventID = " . $eventrows["EventID"] . " AND TicketPrices.Type = 'Member' ORDER BY TicketPrices.StartTime ASC";
  # none member
  $SqlPricesNonMemberQuery = "SELECT * FROM TicketPrices WHERE TicketPrices.EventID = " . $eventrows["EventID"] . " AND TicketPrices.Type = 'NonMember' ORDER BY TicketPrices.StartTime ASC";
  # supplement
  $SqlPricesSupplementQuery = "SELECT * FROM TicketPrices WHERE TicketPrices.EventID = " . $eventrows["EventID"] . " AND TicketPrices.Type = 'Supplement' ORDER BY TicketPrices.StartTime ASC";*/
?>

<div class="col-lg-12 hlpf_contentbox"> <!-- Ret class til-->
  <div class="row">
    <!-- Basic info -->
    <div class="col-lg-12">
      <div class="col-lg-9">
        <h1><?php echo $eventrows['Title']; ?></h1>
        <hr>
        <!-- ============== -->
        <div>
          <p><b>Start tidspunkt:</b> <?php echo date("d/m/y - H:i:s",$eventrows['StartDate']); ?>. <b>Slut tidspunkt:</b> <?php echo date("d/m/y - H:i:s",$eventrows['EndDate']); ?></p>
          <p><b>Adresse:</b> <?php echo $eventrows['Location']; ?> <a href="#">Se Map</a></p>
          <p><b>Internet/LAN: </b> <?php echo $eventrows['Network']; ?></p>
          <p><b>Regler: </b> <a href="?page=<?php echo $eventrows['Rules']; ?>">Læs dem her</a></p>
          <hr>
          <!-- Tickets prices -->
          <div>
            <h2>Billet Priser:</h2>
            <div class="row">
              <?php foreach ($type as &$value) {
                echo "<div class='col-lg-3'><p><b>" . $value . "</b></p></div>";
                $counter = 1;
                $SqlPricesMember = $db_conn->query($SqlPricesQuery);
                while ($row = mysqli_fetch_array($SqlPricesMember)) {
                  #foreach (periods as x) {
                    #echo "<div style='border-top:solid 1px black; border-left:solid 1px black; border-right:solid 1px black; background-color: lightgreen;' class='col-lg-2 text-center'>" . date("d/m",$row["StartTime"]) . " - " . date("d/m",$row["EndTime"]) . "<br>" . $row["Price"] . ",-" . "</div>";
                   # $counter++;
                  #}
                  /*
                  if ($row["StartTime"] != null && $counter == 1) {
                    echo "<div style='border-top:solid 1px black; border-left:solid 1px black; border-right:solid 1px black; background-color: lightgreen;' class='col-lg-2 text-center'>" . date("d/m",$row["StartTime"]) . " - " . date("d/m",$row["EndTime"]) . "<br>" . $row["Price"] . ",-" . "</div>";
                    $counter++;
                  } elseif ($row["StartTime"] != null && $counter == 2) {
                    echo "<div style='border-top:solid 1px black; border-left:solid 1px black; border-right:solid 1px black; background-color: yellow;' class='col-lg-2 text-center'>" . date("d/m",$row["StartTime"]) . " - " . date("d/m",$row["EndTime"]) . "<br>" . $row["Price"] . ",-" . "</div>";
                    $counter++;
                  } elseif ($row["StartTime"] != null && $counter == 3) {
                    echo "<div style='border-top:solid 1px black; border-left:solid 1px black; border-right:solid 1px black; background-color: red;' class='col-lg-2 text-center'>" . date("d/m",$row["StartTime"]) . " - " . date("d/m",$row["EndTime"]) . "<br>" . $row["Price"] . ",-" . "</div>";
                    $counter++;
                  } elseif ($row["StartTime"] != null && $counter == 4) {
                    echo "<div style='border-top:solid 1px black; border-left:solid 1px black; border-right:solid 1px black; background-color: red;' class='col-lg-2 text-center'>" . date("d/m",$row["StartTime"]) . " - " . date("d/m",$row["EndTime"]) . "<br>" . $row["Price"] . ",-" . "</div>";
                    $counter++;
                  } else {
                    $counter++;
                  }*/
              $DistinctEventPriceTypes = $db_conn->query("
                          SELECT DISTINCT tp.Type
                          FROM TicketPrices as tp
                          WHERE tp.EventID = " . $eventrows["EventID"] . "
                          ORDER BY tp.Type ASC");
              if( $DistinctEventPriceTypes -> num_rows ) {
                while ($type = $DistinctEventPriceTypes->fetch_assoc()) {
                  foreach ($type as $key => $value) {
                    echo $value;
                  }
                }
              }
              ?>

              <!--
              <div class="col-lg-3"><p><b>Medlemmer</b></p></div>
              <?php /*
                $counter = 1; // Counter to limit amount of TicketPrices shown per div
                $SqlPricesMember = $db_conn->query($SqlPricesQuery);
                while ($row = mysqli_fetch_array($SqlPricesMember)) {
                  if ($row["StartTime"] != null && $counter == 1) {
                    echo "<div style='border-top:solid 1px black; border-left:solid 1px black; border-right:solid 1px black; background-color: lightgreen;' class='col-lg-2 text-center'>" . date("d/m",$row["StartTime"]) . " - " . date("d/m",$row["EndTime"]) . "<br>" . $row["Price"] . ",-" . "</div>";
                    $counter++;
                  } elseif ($row["StartTime"] != null && $counter == 2) {
                    echo "<div style='border-top:solid 1px black; border-left:solid 1px black; border-right:solid 1px black; background-color: yellow;' class='col-lg-2 text-center'>" . date("d/m",$row["StartTime"]) . " - " . date("d/m",$row["EndTime"]) . "<br>" . $row["Price"] . ",-" . "</div>";
                    $counter++;
                  } elseif ($row["StartTime"] != null && $counter == 3) {
                    echo "<div style='border-top:solid 1px black; border-left:solid 1px black; border-right:solid 1px black; background-color: red;' class='col-lg-2 text-center'>" . date("d/m",$row["StartTime"]) . " - " . date("d/m",$row["EndTime"]) . "<br>" . $row["Price"] . ",-" . "</div>";
                    $counter++;
                  } elseif ($row["StartTime"] != null && $counter == 4) {
                    echo "<div style='border-top:solid 1px black; border-left:solid 1px black; border-right:solid 1px black; background-color: red;' class='col-lg-2 text-center'>" . date("d/m",$row["StartTime"]) . " - " . date("d/m",$row["EndTime"]) . "<br>" . $row["Price"] . ",-" . "</div>";
                    $counter++;
                  } else {
                    $counter++;
                  }
                } */
              ?>-->
            </div>
            <div class="row">
              <div class="col-lg-3"><p><b>Ikke-Medlemmer</b></p></div>
              <div style="border-top:solid 1px black; background-color: lightgreen;" class="col-lg-2 text-center">12/25 - 12/25 450,-</div>
              <div style="border-top:solid 1px black; background-color: yellow;" class="col-lg-2 text-center">12/25 - 12/25 450,-</div>
              <div style="border-top:solid 1px black; background-color: red;" class="col-lg-2 text-center">12/25 - 12/25 450,-</div>
              <div style="border-top:solid 1px black; background-color: red;" class="col-lg-2 text-center">12/25 - 12/25 450,-</div>
              <!-- <div class="col-lg-1">Flere</div>-->
            </div>
            <div class="row">
              <div class="col-lg-3"><p><b>Morgenmad</b></p></div>
              <div style="border-top:solid 1px black; background-color: lightgreen;" class="col-lg-8 text-center">12/25 - 12/25 <br> 60,-</div>
              <!-- <div class="col-lg-1">Flere</div>-->
            </div>
            <div class="row">
              <div class="col-lg-3"><p><b>Aftensmad</b></p></div>
              <div style="border-top:solid 1px black; background-color: lightgreen;" class="col-lg-8 text-center">12/25 - 12/25 <br> 60,-</div>
              <!-- <div class="col-lg-1">Flere</div>-->
            </div>
          </div><!-- Tickets prices end -->
          <br>
          <hr>
          <!-- Seat map -->
          <div>
            <img src="Images/2017-02-23%2013_58_43-HLParty%20-%20Admin%20-_%20Seatmap.png">
          </div><!-- Seat Map end -->
        </div>
      </div><!-- Basic info end -->
      <!-- Poster -->
      <div class="col-lg-3">
        <?php
        echo '<img class="img-responsive" src="Images/EventPoster/'.$eventrows['Poster'].'">';
        ?>
      </div><!-- Poster -->
    </div><!-- end of first div row -->
  </div>

  <?php /*
  <div class="col-lg-8 row">
    <h2>Information</h2>
    <!-- Tid og sted -->
    <h3>Tid og sted</h3>
    <div class="col-lg-12">
      <div class="col-lg-3">
        <div>Navn:</div>
        <div>Start tidspunkt:</div>
        <div>Slut tidspunkt:</div>
        <div>Adresse:</div>
      </div>
      <div class="col-lg-9">
        <div><?php echo $eventrows['Title'] ?></div>
        <div><?php echo date("d M Y - H:i:s", $eventrows['StartDate']) ?></div>
        <div><?php echo date("d M Y - H:i:s", $eventrows['EndDate']) ?></div>
        <div><?php echo $eventrows['Location'] ?></div>
      </div>
      &nbsp;
    </div>

    <!-- Pladser-->
    <h4>Pladser</h4>
      <div>
        <img class="img-responsive" src="Images/Temp/seatmaphere.png">
        <?php if ($eventrows['Seatmap'] == null || $eventrows['Seatmap'] == "") {
          //echo "Ingen information tilgængelig.";
        } else {
          //echo $eventrows['Seatmap'];
        } ?>
    </div>

    <!-- Tilmelding og priser -->
    <h4>Tilmelding og priser</h4>
    <div class="col-lg-12">
      <div class="col-lg-2">Medlem pris:</div>
      <div class="col-lg-10">
        <?php
          $counter = 1; // Counter to limit amount of TicketPrices shown
          $SqlPricesMember = $db_conn->query($SqlPricesMemberQuery);
          while (($row = mysqli_fetch_array($SqlPricesMember)) && $counter < 4) {
            if ($row["StartTime"] < TIME() && $row["EndTime"] > TIME()) { // If TicketPrice exists today
              echo "<div class='col-lg-4'>" . date("d/m",$row["StartTime"]) . "-" . date("d/m",$row["EndTime"]) . ", " . $row["Price"] . ",-" . "</div>";
              $counter++;
            } elseif ($row["StartTime"] > TIME()){ // If TicketPrice exists in future
              echo "<div class='col-lg-4'>" . date("d M",$row["StartTime"]) . "-" . date("d M",$row["EndTime"]) . ", " . $row["Price"] . ",-" . "</div>";
              $counter++;
            } else { //If TicketPrice in past
            }
          }
        ?>
      </div>
      <div class="col-lg-3">Ikke medlem pris:</div>
      <div class="col-lg-9">
        <?php
          $counter = 1; // Counter to limit amount of TicketPrices shown
          $SqlPricesNonMember = $db_conn->query($SqlPricesNonMemberQuery);
          while (($row = mysqli_fetch_array($SqlPricesNonMember)) && $counter < 4) {
            if ($row["StartTime"] < TIME() && $row["EndTime"] > TIME()) { // If TicketPrice exists today
              echo "<div class='col-lg-4'>" . date("d M",$row["StartTime"]) . "-" . date("d M",$row["EndTime"]) . ", " . $row["Price"] . ",-" . "</div>";
              $counter++;
            } elseif ($row["StartTime"] > TIME()){ // If TicketPrice exists in future
              echo "<div class='col-lg-4'>" . date("d M",$row["StartTime"]) . "-" . date("d M",$row["EndTime"]) . ", " . $row["Price"] . ",-" . "</div>";
              $counter++;
            } else { //If TicketPrice in past
            }
          }
        ?>
      </div>
    </div>
    <p><a href="http://hlpf.dk">Klik her</a> for at blive medlem.</p>

    <!-- Netværk -->
    <h4>Netværk</h4>
    <div class="col-lg-12">
      <div class="col-lg-3">Lokalnetværk:</div>
      <div class="col-lg-9"><?php echo $eventrows['Network'] ?></div>
      <div class="col-lg-3">Internet:</div>
      <div class="col-lg-9">100 Mbit / 100 Mbit</div>
      &nbsp;
    </div>

    <!-- Faciliteter -->
    <!--
    <div class="row col-lg-12">
      <p><h4>Faciliteter:</h4></p>
    </div>
    <div class="row col-lg-4">
      <p>Soverum:</p>
    </div>
    <div class="row col-lg-8">
      <p>On the way ...<?php //echo $row['Location'] ?></p>
    </div>
    <div class="row col-lg-4">
      <p>Bad:</p>
    </div>
    <div class="row col-lg-8">
      <p>On the way ...<?php //echo $row['Location'] ?></p>
    </div>
    <div class="row col-lg-4">
      <p>Kiosk:</p>
    </div>
    <div class="row col-lg-8">
      <p>On the way ...<?php //echo $row['Location'] ?></p>
    </div>
    -->

    <!-- Regler -->
    <h4>Regler for arrangementet kan ses <a href="?page=<?php echo $eventrows['Rules'] ?>"><i>her</i></a></h4>
    <hr>
    <!--
		<div class="row col-lg-4">
			<p>Rygning tilladt:</p>
		</div>
		<div class="row col-lg-8">
			<p>On the way ...<?php //echo $row['Location'] ?></p>
		</div>
		<div class="row col-lg-4">
			<p>Alkohol tilladt:</p>
		</div>
		<div class="row col-lg-8">
			<p>On the way ...<?php //echo $row['Location'] ?></p>
		</div>
		-->

    <!-- Arrangør -->
    <h4>Arrangør</h4>
    <p>
      HLParty arrangeres af foreningen Hovedstadens LanParty Forening. Foreningen er en folkeoplysende forening, godkendt i Hillerød kommune. Foreningens formål er (uddrag af vedtægter):
      <blockquote class="hlpf_smallerquote">
        <i>Foreningens formål er at samle unge mennesker, primært i hovedstadsområdet, med interesse for computere og IT, for derved at medvirke til at styrke medlemmernes sociale kompetencer, skabe kontakt på tværs af kommunegrænser, etnicitet, køn og alder og styrke medlemmernes almennyttige IT kundskaber til glæde for den enkelte, såvel som for samfundet.</i>
        <small>Hovedstadens LANParty Forening</small>
      </blockquote>
      Overskud fra et arrangement går til drift af foreningen (f.eks. webhotel, vedligeholdelse og nyinkøb af servere, switche, netværkskabler mv.), samt til at sikre fremtidige arrangementer.
    </p>
    <p>Læs mere om foreningen bag HLParty på adressen <a href="https://hlpf.dk" target="_blank">https://hlpf.dk</a>.</p>
  </div>

  <div class="col-lg-4">
    <div class="col-lg-12">
    <?php if ($eventrows['Poster'] == null || $eventrows['Poster'] == "") {
      echo '<img class="img-responsive" src="Images/EventPoster/noposter.png">';
    }else{
      echo '<img class="img-responsive" src="Images/EventPoster/'.$eventrows['Poster'] . '">';
    } ?>
    </div>
  </div>
  */ ?>
</div>

<?php
  $event -> close();
?>
