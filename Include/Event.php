<?php
  # Latest event - Get the ID.
  $event = $db_conn->query("SELECT Event.Title, Event.EventID, Event.Poster, Event.StartDate, Event.EndDate, Event.Location, Event.Network, Event.Seatmap, Event.Rules FROM Event ORDER BY EventID DESC LIMIT 1");
  if( $event -> num_rows ) { $eventrows = $event->fetch_assoc(); }
  # Member price info
  $SqlPricesMemberQuery = "SELECT * FROM TicketPrices WHERE TicketPrices.EventID = " . $eventrows["EventID"] . " AND TicketPrices.Type = 'Member' ORDER BY TicketPrices.Price ASC";
  //if( $SqlPricesMember -> num_rows ) { $pricesMember = $SqlPricesMember->fetch_assoc(); }
  # Nonmamber price info
  $SqlPricesNonMemberQuery = "SELECT * FROM TicketPrices WHERE TicketPrices.EventID = " . $eventrows["EventID"] . " AND TicketPrices.Type = 'NonMember' ORDER BY TicketPrices.Price ASC";
  //if( $SqlPricesNonMember -> num_rows ) { $pricesNonMember = $SqlPricesNonMember->fetch_assoc(); }
  # Supplement price info
  # Food ticket query here.
  //$result5 = $db_conn->query("SELECT tp.StartTime, tp.EndTime, tp.Price FROM Event as e INNER JOIN TicketPrices as tp	ON e.EventID = tp.EventID WHERE e.EventID = " . $eventrows["EventID"] . " AND tp.Type = 'Supplement' ORDER BY tp.StartTime ASC LIMIT 0, 1");
  //if( $result5 -> num_rows ) { $row5 = $result5->fetch_assoc(); }
?>

<div class="col-lg-12 hlpf_contentbox"> <!-- Ret class til-->
  <div class="col-lg-8 row">
    <h2>Information</h2>
    <!-- Tid og sted -->
    <h3>Tid og sted</h3>
    <table class="table table-responsive">
      <thead>
        <tr>
          <th>Navn</th>
          <th>Start tidspunkt</th>
          <th>Slut tidspunkt</th>
          <th>Adresse</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td><?php echo $eventrows['Title'] ?></td>
          <td><?php echo date("d M Y - H:i:s", $eventrows['StartDate']) ?></td>
          <td><?php echo date("d M Y - H:i:s", $eventrows['EndDate']) ?></td>
          <td><?php echo $eventrows['Location'] ?></td>
        </tr>
      </tbody>
    </table>

    <!-- Pladser-->
    <h4>Pladser</h4>
    <table class="table table-striped">
    <tr>
      <td>
        <img class="img-responsive" src="Images/Temp/seatmaphere.png">
        <?php if ($eventrows['Seatmap'] == null || $eventrows['Seatmap'] == "") {
          echo "Ingen information tilgængelig.";
        } else {
          echo $eventrows['Seatmap'];
        } ?>
      </td>
    </tr>
    </table>
    <!-- Tilmelding og priser -->
    <h4>Tilmelding og priser</h4>
    <table class="table table-responsive table-striped table-hover">
    <thead>
      <tr>
        <th><!-- Empty field. --></th>
        <?php
          $SqlPricesMember = $db_conn->query($SqlPricesMemberQuery);
          while ($row = mysqli_fetch_array($SqlPricesMember)) {
            if ($row["StartTime"] != 0) {
              echo "<th>" . date("d M H:i:s",$row["StartTime"]) . "</th>";
            } else {
              echo "<th>Dør-pris</th>";
            }
          }
        ?>
      </tr>
    </thead>
    <tbody>
      <tr>
        <th>Medlem</th>
        <?php
          $SqlPricesMember = $db_conn->query($SqlPricesMemberQuery);
          while ($row = mysqli_fetch_array($SqlPricesMember)) {
            echo "<td>" . $row["Price"] . "DKK</td>";
          }
        ?>
      </tr>
    </tbody>
    <thead>
      <tr>
        <th><!-- Empty field. --></th>
        <?php
          $SqlPricesNonMember = $db_conn->query($SqlPricesNonMemberQuery);
          while ($row = mysqli_fetch_array($SqlPricesNonMember)) {
            if ($row["StartTime"] != 0) {
              echo "<th>" . date("d M H:i:s",$row["StartTime"]) . "</th>";
            } else {
              echo "<th>Dør-pris</th>";
            }
          }
        ?>
      </tr>
    </thead>
    <tbody>
      <tr>
        <th>Ikke medlem</th>
        <?php
          $SqlPricesNonMember = $db_conn->query($SqlPricesNonMemberQuery);
          while ($row = mysqli_fetch_array($SqlPricesNonMember)) {
            echo "<td>" . $row["Price"] . "DKK</td>";
          }
        ?>
      </tr>
    </tbody>
    </table>
    <p><a href="http://hlpf.dk">Klik her</a> for at blive medlem.</p>

    <!-- Netværk -->
    <h4>Netværk</h4>
    <table class="table table-striped">
      <tr>
        <td>Lokalnetværk</td>
        <td><?php echo $eventrows['Network'] ?></td>
      </tr>
      <tr>
        <td>Internet</td>
        <td>100 Mbit / 100 Mbit</td>
      </tr>
    </table>

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
</div>

<?php
  $event -> close();
?>