<?php
//$RegErroMSG = array();
if(isset($_POST['Create_user'])){
    if($_POST['Password'] == $_POST['CPassword']){
        $RegErroMSG[] += 'kodeord passede sammen';
    }
    else{
        $RegErroMSG[] += 'Kodeord & Bekræft Kodeord passed ikke sammen';
        $RegErroMSG[] +=
    }
}
?>
<!-- Register Start -->
<div class="row">
    <div class="col-lg-12 hlpf_newsborder">
        <div class="row">
            <div class="col-lg-12 hlpf_large_news_box">
                <img class="img-responsive" src="Images/image-slider-5.jpg">
                <hr/> 
                <div class="hlpf_flex">
                        <div class="table-responsive">
                            <table class="table">
                                <form action="" method="post">
                                    <tr>
                                        <td>
                                            <label for="FullName">Fulde Navn:*</label>
                                            <input type="text" class="form-control" placeholder="Santa Claus" id="FullName" 
                                                   value="<?php if(isset($_SESSION['FullName'])){ echo $_SESSION['FullName'];} ?>" required name="FullName">
                                        </td>
                                        <td><label for="Email">Email:*</label>
                                            <input type="email" class="form-control" id="Email" placeholder="Workshop@santa.chrismas" 
                                                   value="<?php if(isset($_SESSION['Email'])){ echo $_SESSION['Email'];} ?>" required name="Email">
                                        </td>
                                        <td><label for="Birthday">F&oslash;dselsdag:*</label>
                                            <input type="text" placeholder="dd.mm.YYYY" class="form-control" id="Birthday" 
                                                   value="<?php if(isset($_SESSION['Birthday'])){
                                                                    echo date("d.m.Y",strtotime($_SESSION['Birthday']));} ?>"
                                                   required name="Birthday" pattern="[0-9]{2}.[0-9]{2}.[0-9]{4}" title="dd.mm.yyyy">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <label for="Username">Brugernavn:*</label>
                                            <input type="text" placeholder="ImNotSanta" class="form-control" id="FullName"
                                                   value="<?php if(isset($_SESSION['PreffereredUsername'])){echo $_SESSION['PreffereredUsername']; } ?>" required name="Username">
                                        </td>
                                        <td>
                                            <label for="Password">Kodeord:*</label>
                                            <input type="password" class="form-control" pattern=".{4,18}" title="4 til 18 karaktere" id="Password" placeholder="Kodeord" required name="Password">
                                        </td>
                                        <td>
                                            <label for="CPassword">Bekr&aelig;ft Kodeord:*</label>
                                            <input type="password" class="form-control" pattern=".{4,18}" title="4 til 18 karaktere" id="CPassword" placeholder="Gentag Kodeord" required name="CPassword">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <label for="Phone">Telefon:*</label>
                                            <input type="text" class="form-control" id="Phone" value=""  placeholder="feks: 11223344 eller +4511223344" required name="Phone">
                                        </td>
                                        <td>
                                            <label for="Address">Adresse:*</label>
                                            <input type="text" placeholder="feks Norpolen 42, 6.sal tv" class="form-control" id="FullName" value="" required name="Address">
                                        </td>
                                        <td>
                                            <label for="Zipcode">Postnumber:*</label>
                                            <input type="text" list="DBZipcodes" placeholder="1337 Awesome city" class="form-control" id="Zipcode" value="" required name="Zipcode">
                                            <!-- List of Zipcodes in Denmark -->
                                            <datalist id="DBZipcodes">
                                                <?php
                                                    if($result = $db_conn->query("SELECT * FROM zipcodes")){
                                                        while($row = $result->fetch_assoc()){
                                                            echo '<option value=',$row["zipcode"],'>',$row["zipcode"],' ',$row["city"],'</option>';   
                                                        }   
                                                    }
                                                ?>
                                            </datalist>
                                            <!-- List of Zipcodes in Denmark End -->
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="3">
                                            <label for="Bio">Profil tekst:</label>
                                            <textarea id="Bio" class="form-control awesomplete" rows="5" name="Bio">
                                            </textarea>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="form-inline">
                                                <label for="ToS">Brugerbetinelser:*</label>
                                            <input type="checkbox" class="form-control" id="ToS" value="1" required name="ToS">
                                            </div>
                                        </td>
                                        <td>&nbsp;</td>
                                        <td class="text-center">
                                            <input type="submit" class="btn btn-default" name="Create_user">
                                        </td>
                                    </tr>
                                    <?php
                                    if(isset($RegErroMSG)){
                                        echo '<tr><td>';
                                        var_dump($RegErroMSG);
                                        /*foreach($RegErroMSG as $i){
                                            echo $i;
                                        }*/
                                        echo '</td></tr>';
                                    }
                                    ?>
                                </form>    
                            </table>
                        </div>
                </div>
            </div>
        </div>
        <hr/>
    </div>
</div>
<!-- Register end -->
