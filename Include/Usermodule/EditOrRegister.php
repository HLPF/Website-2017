<?php

require_once("Include/Usermodule/BecomeMember.php");

if(!isset($_SESSION['UserToken']) && !isset($_SESSION['UserID'])){
    header("Location: /Website-2017/index.php");
}else{
    if(isset($_SESSION['UserToken'])){
        if(isset($_SESSION['FullName'])){ $FullName = $_SESSION['FullName'];}
        if(isset($_SESSION['Email'])){ $Email       = $_SESSION['Email'];}
        if(isset($_SESSION['PreffereredUsername'])){ $PreffereredUsername    = $_SESSION['PreffereredUsername'];}
    }
    if(isset($_SESSION['UserID'])){
        $UserID = $_SESSION['UserID'];
        if($result = $db_conn->query("SELECT * FROM Users WHERE UserID = '$UserID'")){
            if($result -> num_rows){
                $row = $result->fetch_assoc();
                $NewsLetter             = $row['NewsLetter'];
                $Birthday               = $row['Birthdate'];
                $PreffereredUsername    = $row['Username'];
                $FullName               = $row['FullName'];
                $Address                = $row['Address'];
                $Zipcode                = $row['ZipCode'];
                $Clan                   = $row['ClanID'];
                $Email                  = $row['Email'];
                $Phone                  = $row['Phone'];
                $Bio                    = $row['Bio'];
            }
        }
    }
    if(isset($_POST['Send_form'])) // Submit form start
    {
      require_once("Include/Usermodule/FormSubmit.php");
    }// Form submit end
    ?>
    <!-- Form Start -->
<div class="row hlpf_contentbox">
    <div class="col-lg-12">
      <img class="img-responsive" src="Images/image-slider-5.jpg">
    </div>
  &nbsp;
    <form action="" method="post">
      <div class="form-group col-lg-3">
        <label class="control-label" for="FullName">Fulde Navn:*</label>
        <input type="text" class="form-control" placeholder="Santa Claus" id="FullName"
               value="<?php if(isset($FullName)){ echo $FullName;} ?>"  name="FullName">
      </div>
      <div class="form-group col-lg-3">
        <label class="control-label" for="Email">Email:*</label>
        <input type="email" class="form-control" id="Email" placeholder="Workshop@santa.chrismas"
               value="<?php if(isset($Email)){ echo $Email;} ?>"  name="Email">
      </div>

      <div class="form-group col-lg-3">
        <label class="control-label" for="Birthday">F&oslash;dselsdag:*</label>
        <input type="text" class="form-control picker" id="Birthday" value="<?php if(isset($Birthday)){ echo date("d-m-Y",$Birthday);} ?>"
               name="Birthday" title="dd-mm-yyyy" data-date-format="dd-mm-yyyy">
      </div>
      <div class="form-group col-lg-3">
        <label class="control-label" for="Username">Brugernavn:*</label>
        <input type="text" placeholder="ImNotSanta" class="form-control" id="Username"
               value="<?php if(isset($PreffereredUsername)){echo $PreffereredUsername; } ?>"  name="Username">
      </div>

      <?php
      if(!isset($_SESSION['UserID'])){
      ?>
      <div class="form-group col-lg-3">
        <label class="control-label" for="Password">Kodeord:*</label>
        <input type="password" class="form-control" pattern=".{4,18}" title="4 til 18 karaktere" id="Password" placeholder="Kodeord"  name="Password">
      </div>
      <div class="form-group col-lg-3">
        <label class="control-label" for="CPassword">Bekr&aelig;ft Kodeord:*</label>
        <input type="password" class="form-control" pattern=".{4,18}" title="4 til 18 karaktere" id="CPassword" placeholder="Gentag Kodeord"  name="CPassword">
      </div>
      <?php
      }
      ?>
      <div class="form-group col-lg-3">
        <label class="control-label" for="Phone">Telefon:*</label>
        <input type="text" class="form-control" id="Phone" value="<?php if(isset($Phone)){echo $Phone;} ?>"
               placeholder="feks: 11223344 eller +4511223344"  name="Phone">
      </div>
      <div class="form-group col-lg-3">
        <label class="control-label" for="Address">Adresse:*</label>
        <input type="text" placeholder="feks Norpolen 42, 6.sal tv" class="form-control" id="Address"
               value="<?php if(isset($Address)){echo $Address;} ?>"  name="Address">
      </div>
      <div class="form-group col-lg-3">
        <label class="control-label" for="Zipcode">Postnumber:*</label>
        <input type="text" list="DBZipcodes" placeholder="1337 Awesome city" class="form-control" id="Zipcode"
        value="<?php if(isset($Zipcode)){echo $Zipcode;} ?>"  name="Zipcode">
        <!-- List of Zipcodes in Denmark -->
        <datalist id="DBZipcodes">
        <?php
        if($result = $db_conn->query("SELECT * FROM ZipCodes")){
          while($row = $result->fetch_assoc()){
          echo '<option value=',$row["Zipcode"],'>',$row["Zipcode"],' ',$row["City"],'</option>';
          }
        }
        ?>
        </datalist>
        <!-- List of Zipcodes in Denmark End -->
      </div>
      <div class="form-group col-lg-3">
        <label class="control-label" for="Clan">Klan: </label> &nbsp;<a type="button" id="ClanLink" onclick="showStuff()">Ny Klan?</a>

        <!-- if existing Clans -->
        <input type="text" name="NewClan" placeholder="Kage Banden" class="form-control" style="display: none;" id="NewClan">
        <!-- if existing Clans -->
        <!-- if existing Clans -->
        <select list="DBClans" placeholder="Hovedstadens Lanparty Forening" class="form-control" id="Clan"
        value="<?php if(isset($Clan)){echo $Clan;} ?>" name="Clan">
          <option value="0">Er ikke i nogen Clan</option>
          <?php
          if($Clanresult = $db_conn->query("SELECT * FROM Clan")){
            while($Clanrow = $Clanresult->fetch_assoc()){
          ?>
          <option <?php if($Clanrow["ClanID"] == $Clan){echo "selected";} ?>  value='<?php echo $Clanrow["ClanID"]; ?>'>
            <?php echo $Clanrow["Name"]; ?>
          </option>
          <?php
            }
          }
          ?>
        </select>
        <!-- if existing Clans end -->
        <script type="text/javascript">
        function showStuff(){
            if(document.getElementById('NewClan').style.display != 'block'){
              document.getElementById('NewClan').style.display = 'block';
            }else{
              document.getElementById('NewClan').style.display = 'none';
            }
            // hide the lorem ipsum text
            if(document.getElementById('Clan').style.display != 'none'){
              document.getElementById('Clan').style.display = 'none';
            }else{
              document.getElementById('Clan').style.display = 'block';
            }
          if(document.getElementById('ClanLink').text != 'Ny Klan?'){
            document.getElementById('ClanLink').text = 'Ny Klan?';
          }else{
            document.getElementById('ClanLink').text = 'Klan Liste?';
          }
        }
        </script>
      </div>
      <div class="form-group form-inline col-lg-3">
          <label for="NewsLetter">Nyhedbrev:</label>
          <input type="checkbox" <?php if(isset($NewsLetter) && $NewsLetter == 1){ echo 'checked';} ?> id="NewsLetter" value="1"
                 name="NewsLetter">
      </div>

      <div class="form-group form-inline col-lg-3">
          <?php if($page != 'EditMyProfile'){ ?>
            <label for="ToS">*Brugerbetinelser: </label>
            <input type="checkbox" id="ToS" value="1"  name="ToS">
          <?php } ?>
      </div>

      <div class="form-group col-lg-12">
        <label class="control-label" for="Bio">Profil tekst:</label>
        <textarea id="PublicTinyMCE" class="form-control" rows="5" name="Bio" id="Bio">
        <?php if(isset($Bio)){echo $Bio;} ?>
        </textarea>
      </div>
      <?php
      if(isset($_SESSION['UserID'])){
      ?>
        <div class="col-lg-12">
          <h4>Tilføj dine andre sociale netværker: </h4>
        </div>
        <div id="oa_social_link_container" class="form-group col-lg-10"></div>
        <script type="text/javascript">
          /* Replace #your_callback_uri# with the url to your own callback script */
          var your_callback_script = 'http://<?php echo $ROOTURL; ?>Include/oneall_hlpf/oneall_callback_handler.php';
          /* Dynamically add the user_token of the currently logged in user. */
          /* Leave the field blank in case the user has no user_token yet. */
          var user_token = '<?php echo $_SESSION['OneAllToken']; ?>';

          /* Embeds the buttons into the oa_social_link_container */
          var _oneall = _oneall || [];
          _oneall.push(['social_link', 'set_providers', ['facebook', 'Google', 'Battlenet', 'Steam', 'Twitch']]);
          _oneall.push(['social_link', 'set_callback_uri', your_callback_script]);
          _oneall.push(['social_link', 'set_user_token', user_token]);
          _oneall.push(['social_link', 'do_render_ui', 'oa_social_link_container']);

        </script>
      <?php
      }
      ?>
      <div class="form-group col-lg-2">
        <input type="submit" value="Opdater min profil" class="btn btn-default" name="Send_form">
      </div>
      <?php
      if(isset($RegErroMSG) && $RegErroMSG == ''){
      echo '<ul class="alert alert-danger" role="alert"><b>Feltkravene er ikke opfyldt:</b>';
      foreach($RegErroMSG as $i){
      echo '<li>'.$i.'</li>';
      }
      echo '</li></ul>';
      }
      unset($RegErroMSG);
      ?>
    </form><!-- Form end -->
    <div id="" class="form-group col-lg-12">
      <hr>
      <?php
        $MemberTextResult = $db_conn->query("SELECT Content From Pages WHERE PageID = '11'");
        $MemberTextRow = $MemberTextResult->fetch_assoc();
        echo $MemberTextRow['Content'];
      
      // is member?
      $year = date('Y',time());
      $ismemberresult = $db_conn->query("SELECT * FROM UserMembership WHERE UserID = '$UserID' AND Year = '$year'");
      
      if($ismemberresult->num_rows == 1){
        echo "<h4>Tak for dit medlemskab i $year!</h4>";
      }else{
      ?>
      <form method="post">
        <button name="BecomeMember" class="btn btn-info">BLiv Medlem for <?php echo $year; ?></button>
      </form>
      <?php
      }
      ?>
      </div>
</div> <!-- Row end -->

<?php
}
?>
