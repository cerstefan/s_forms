<!-- //🗻 CAND FACI UN FORMULAR SI ADUCI ELEMENTE NOI SCRIPTULUI
            /*
              - CREEZI JSON
              - ADAUGI ELEMENTE NOI IN SCRIPT DACA E NEVOIE
              - ADAUGI GESTIONARE ERORI DACA E CAZUL
              - FACI VALIDAREA INTRARILOR */

            // 🔨 DE TERMINAT
            /* INPUT[FILES] - conflicte intre variabilele care definesc id-ul */
 -->




<?php include "s_forms_conf.php";?>

<?php

    // // ASCUNDE TOATE ERORILE
    // error_reporting(0);
    // ini_set('display_errors', 0);


// CLASA GENERATOARE DE FORMULARE
// CUM GENEREZI UN FORMULAR:
// OOO
//
//
//

?>

<!--Stilurile Formularelor-->
<link rel="stylesheet" type="text/css" href="<?php echo $GLOBALS['S_FORMS_PATH'];?>/s_forms.css"> 

<?php
class former_class {
    public $json;
    public $jsonLength;
    public $EROAREGLOBALA = FALSE;
    public $values;
    public $form_name;
    public $fisiere = []; // fisiere de incarcat, daca are (MATRICE)


    function generate_form($form_name, $form_class, $form_json, $method = 'post') {
        $this->form_name = $form_name;
        $json = json_decode($form_json);
        $jsonLength = count($json);
        $this->json = $json;
        $this->jsonLength = $jsonLength;

        

        $err = "";

        //Buld Form
        // print_r($json);
        // print_r($jsonLength);
        echo "\n<form id='$form_name' class='$form_class' name='$form_name' method='$method' 
        enctype='multipart/form-data' action=".htmlspecialchars($_SERVER["PHP_SELF"]).">";

        // Save input daca s-a introdus
        date_default_timezone_set("Europe/Bucharest");
        $this->save_input(); 

            // Continue Build with elements
            for ($i=0; $i<$jsonLength; $i++) {  
                // ////////
                // ////////
                $this->building_divs_and_elements($json[$i]); // parguge viecare element al JSON-ULUI
                // ////////
                // ////////
            }

        echo "</form>";


    }

    function building_divs_and_elements($json_element) { // FUNCTIE CARE PARCURGE O MATRICE, SI O MATRICE IN MATRICE
        if (is_array($json_element)) {
            $arrayLength = count($json_element);
            $divclass = "";



            //Build divs daca sunt
            for ($i=0; $i<$arrayLength; $i++) {  

                // Verifica daca la inceputul elemntului exista clase sau etichete(label)
                if ($i == 0) {
                    if ($json_element[$i] == "class") {
                        $divclass = $json_element[$i+1];
                        $i += 2;
                    } 
                    echo "\n\t<div class='flex row top nowrap relative w100 $divclass'>";
                }

                    if ($json_element[$i] == "label") {
                        $labeltext = $json_element[$i+1];
                        $i += 2;

                        echo "\n\t\t<label>$labeltext</label>";
                        echo "\n\t</div>"; // completare pentru a scapa de erori
                        echo "\n\t<div class='flex row top nowrap relative w100'>"; // completare pentru a scapa de erori

                    }
                

 
                
                // Verifica daca, din nou, un element este matrice, daca nu construeste ce are de construit
                $this->building_divs_and_elements($json_element[$i]);
                
                
                if ($i == $arrayLength-1) {
                    echo "\n\t</div>";
                }
            }
        } else {
            /*label*/(property_exists($json_element, 'label') ? $label=$json_element->label : $label = "");
            /*tag*/(property_exists($json_element, 'tag') ? $tag=$json_element->tag : $tag = "input");
            /*type*/(property_exists($json_element, 'type') ? $type=$json_element->type : $type = "text" && $json_element->type = "");
            /*attributes*/(property_exists($json_element, 'attributes') ? $attributes=$json_element->attributes : $attributes = "");
            /*class*/(property_exists($json_element, 'class') ? $class=$json_element->class : $class = "");
            $name = $json_element->name;
            /*files*/ if ($type == "file") {$name .= "[]";} // pt files, ca sa poti incarca mai multe
                if (is_array($this->values)) { // verifica daca exista Intrari (user inputs)
                    if (isset($this->values[$json_element->name])) { // verifica daca o anumita intrare este
                                                            // definita (ex pt checkbox)
                        $value = $this->values["$name"];
                    } else { // intrarea nu este definita (pt checkbox), poate o fi si altele dar nu stiu momentan
                        $value = $json_element->value;
                    }
                } else { // nu exista Intrari (user inputs)
                    $value = $json_element->value;
                }
            /*id*/(property_exists($json_element, 'id') ? $id=$json_element->id : $id = $name);
            /*placeholder*/(property_exists($json_element, 'placeholder') ? $placeholder=$json_element->placeholder : $placeholder = "");
            /*placeholder2*/(property_exists($json_element, 'placeholder2') ? $placeholder2=$json_element->placeholder2 : $placeholder2 = "");


    
            // EROARE IN CAZUL NEVALIDARII UNUI CAMP
            $err = $this->check_input($json_element);
            /*checked*/(property_exists($json_element, 'checked') ? $checked=$json_element->checked : $checked = "");

            if ($type == "checkbox") {  // daca input type este checkbox
                echo "\n\t\t<div class='flex w100'>";
                echo "\n\t\t<label for='$id'>";
                echo "\n\t\t<$tag type='$type' class='$class' id='$id' name='$name' value='$value' placeholder='$placeholder' $checked/>";
                echo "\n\t\t<span class='$class'>$label</span>";
                echo "\n\t\t</label>";

                // Scrie Eroarea
                if ($err != "") {
                    echo "\n\t\t<span class='err'>".$err."</span>";
                    // Face chenarul input-ului respectiv, de culoare rosie
                    // echo "<script></script>";
                }
                echo "\n\t\t</div>";   
                
            } elseif ($type == "file") { 
                echo "\n\t\t<div class='flex w100'>";
                echo "\n\t\t<label for='{$id}_$name' id='$id' class='custom-file-upload input flex center button $class'><i class='fa fa-cloud-upload' aria-hidden='true'></i> 
                <span>$placeholder</span><div id='{$id}_count'>&nbsp;( 0 fișiere )</div>";
                echo "\n\t\t</label>";
                echo "\n\t\t<$tag type='$type' id='{$id}_$name' name='$name' onchange=onChangeInputFile(this,{$id}_count) $attributes />";

                // Scrie Eroarea
                if ($err != "") {
                    echo "\n\t\t<span class='err'>".$err."</span>";
                    // Face chenarul input-ului respectiv, de culoare rosie
                    // echo "<script></script>";
                }
                echo "\n\t\t</div>";

            } elseif ($type == "range") { 
                echo "\n\t\t<div class='flex w100'>";
                echo "\n\t\t<label for='$id' id='$id' class='range-label $class'> 
                <div>$placeholder <span id='{$id}_count'>&nbsp; $value</span></div>
                <div class='placeholder2'>$placeholder2</div>";
                echo "\n\t\t<$tag type='$type' id='{$id}_$name' name='$name' value='$value' oninput=onChangeInputRange(this,{$id}_count) onchange=onChangeInputRange(this,{$id}_count) 
                style='outline:0;' $attributes />";
                // Scrie Eroarea
                if ($err != "") {
                    echo "\n\t\t<div class='err'>".$err."</div>";
                    // Face chenarul input-ului respectiv, de culoare rosie
                    // echo "<script></script>";
                }
                echo "\n\t\t</label>";

                echo "\n\t\t</div>";

            } else { // daca input este altceva (decat checkbok)

                echo "\n\t\t<div class='flex w100'>";
                echo "\n\t\t<label for='$id'>$label";
                echo "\n\t\t</label>";
                echo "\n\t\t<$tag type='$type' class='$class' id='$id' name='$name' value='$value' placeholder='$placeholder' $attributes";
                if ($tag == 'textarea') {
                    echo ">$value</textarea>";
                } else {
                    echo "/>";
                }

                // Scrie Eroarea
                if ($err != "") {
                    echo "\n\t\t<span class='err'>".$err."</span>";
                    // Face chenarul input-ului respectiv, de culoare rosie
                    // echo "<script></script>";
                }
                echo "\n\t\t</div>";
            }
            
        }
    }

    function building_extra_elements() {
        
    }



    function save_input() {
        // SALVEAZA TOATE INTRARILE CARE VIN DE LA UTILIZATOR, LE SECURIZEAZA SI LE REFOLOSESTE 
        // ]N CAZUL IN CARE UTILIZATORUL A TASTAT CEVA GRESIT
        // VARIABILE 
        // trece prin toate valorile
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            foreach ($_POST as $key=>$comp) {
                $this->values["$key"] = test_data("$comp");                   
            }
            // print_r($this->values);
        }
    }

    // function save_input_files() {
    //     echo '<script>
    //     var filelist = document.getElementById("files_input").files;';

    //     for ($i=0; $i<count($this->fisiere); $i++) {
    //         echo "
    //         filelist[$i] = ".$this->fisiere[$i].";
    //         ";
    //     }
    //     echo '
    //     alert(filelist);
    //     </script>';
    // }

    function check_input($json) {
        // VERIFICA TOATE INTRARILE (CERERILE) (REQUESTURILE) DACA SUNT GOALE, SI LE VALIDEAZA DACA
        // SUNT PLINE
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $alertSimbol = "&#9888;";

            // VERIFICA DACA AU FOST INTRODUSE FISIERE
            if ($json->type == "file") {
                if ($_FILES["$json->name"]['name'][0] == NULL) { // verifica dace nu exista nici o intrare
                    if (property_exists($json, 'required')) { 
                        // echo "<script>alert('required');</script>";
                        $this->EROAREGLOBALA = TRUE; 
                        $json->required = "$alertSimbol $json->required";
                        return $json->required;                   
                    }
                } else { // daca exista macar o intrare
                    for ($i=0; $i<count($_FILES["$json->name"]['name']); $i++){ // cand preia fisierele ordinea
                                                                        // este alta: $_FILES["$json->name"][nume][nume1]
                        $f_name = $_FILES["$json->name"]['name'][$i];
                        $f_type = $_FILES["$json->name"]['type'][$i];
                        $f_tmp = $_FILES["$json->name"]['tmp_name'][$i];
                        $f_error = $_FILES["$json->name"]['error'][$i];
                        $f_size = $_FILES["$json->name"]['size'][$i];
                        $this->fisiere[$i] = (object) array("name"=>"$f_name", "type"=>"$f_type", "tmp_name"=>"$f_tmp", "error"=>"$f_error", "size"=>"$f_size"); 
                                                                        // cand salveaza fisierele in obiect, ordinea este alta
                                                                        // $this->fisiere[0]->nume etc
                        // echo '<pre>'.print_r($this->fisiere[$i], true).'</pre>';
                        echo "<script>alert('Ai incarcat fisierele: ". $this->fisiere[0]->type ."');</script>";

                        // erori 
                            // Dimensiunea fisierului
                            if ($f_size > 25000000) {
                                $this->EROAREGLOBALA = TRUE; 
                                return "$alertSimbol Ne pare rău dar unul din fișiere este mai mare de 25MB";
                            }
                    }
                    return "$alertSimbol Vă rugăm să reintroduceți fișierele, dacă sunt!";
                }
            
            // VERIFICA DACA AU FOST INTRODUSE ALTELE
            } else {
                if (empty($_POST["$json->name"])  //json name se transforma in valoarea lui Json->name
                && property_exists($json, 'required')) { // iar prop post, si ruleaza conditia daca proprietatea err exista in json
                    if ( property_exists($json, 'required') ) {
                        $this->EROAREGLOBALA = TRUE; 
                        $json->required = "$alertSimbol $json->required";
                        return $json->required;
                    } else { 
                        $this->EROAREGLOBALA = TRUE;
                        return "";
                    }
                } else {
                    if ($json->type == "") { //pt textarea si altele care nu trebie sa indeplineasca nici o conditie                      
                    } elseif ($json->type == "text") {
                        if ((!preg_match("/^[a-zA-Z-' ]*$/", $this->values["$json->name"]))) {
                            $this->EROAREGLOBALA = TRUE;                        
                            return "$alertSimbol Câmpurile trebuie să conțină doar litere. Diacriticele nu sunt acceptate.";
                        }
                    } elseif ($json->type == "email") {
                        if (!filter_var($this->values["$json->name"], FILTER_VALIDATE_EMAIL)) {
                            $this->EROAREGLOBALA = TRUE;
                            return "$alertSimbol Email invalid";
                        }            
                    } elseif ($json->type == "tel") {
                        if ((!preg_match("/^[0-9]*$/", $this->values["$json->name"]))) {
                            $this->EROAREGLOBALA = TRUE;
                            return "$alertSimbol Număr de telefon trebuie să conțină numai cifre!";
                        }            
                    } elseif ($json->type == "localitatea") {
                        if ((!preg_match("/^[a-zA-Z-'.0-9, ]*$/", $this->values["$json->name"]))) {
                            $this->EROAREGLOBALA = TRUE;
                            return "$alertSimbol Câmpurile trebuie să conțină doar litere, cifre, punct și virgulă. Diacriticele nu sunt acceptate.";
                        }
                    } elseif ($json->type == "checkbox") {
                        if (isset($this->values[$json->name])) { // verifica daca elementul este definit
                            $json->checked = $this->values[$json->name];
                        }
                    }
                    
                    
                    // OOOOOOO
                    echo "<script>window.location.href = '#$this->form_name';</script>";

                }
            }


            // $former->send_mail("incercare", "cerstefan27@gmail.com", "SitesWeavers - Proof Query")

        }   

    }

    function check_files($json) {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
        
        }
    }

    function send_mail($type, $toBussinessOwner, $subjToClient, $bodyToClient){
        if ($this->EROAREGLOBALA == FALSE && $_SERVER["REQUEST_METHOD"] == "POST") {

            // TRANSFORMA ELEMENTELE MATRICEI IN VARIABILE
            foreach ($this->values as $key=>$comp) {
                $$key = "$comp";
            }
            // astfel variabila 
            // $email va fi definita


            // **********************************************
            // **********************************************
            // **********************************************
            //  TRIMITE UN EMAIL DETINATORULUI FIRMEI
            $emailto = "$toBussinessOwner";
    
            $emailfrom = 'contact@sitesweavers.com'; $emailfromname = 'SitesWeaver Clerk';
            $emailreply = 'cerstefan27@gmail.com'; $emailreplyname = 'SitesWeaver Clerk';
            // SUBIECT
            // if ($type == "Incercare" ) {
            //     $subject = 'SitesWeavers Proof Query';
            // } else {
                $subject = "SitesWeavers $type Query";
            // }

            // MAIL BODY
            $bodyToOwner = "<img src='cid:logo' style='width: 20%; height: auto; display: block;'/><br/>
            <p>Hello, you received a <strong>$type Query</strong>!</p><h3>";
            $dateSubscrise = "";
                foreach ($this->values as $key=>$comp) {
                    $dateSubscrise .= "<br/>$key: $comp";
                }
                $bodyToOwner .= $dateSubscrise;
                $subscriptionDate = date("Y-m-d h:i:sa");
                $bodyToOwner .= "<br/>Data Subscrierii: $subscriptionDate";
                $bodyToOwner .= "<br/>Send Confirmation: ".$GLOBALS['SITE']."/".$GLOBALS['S_FORMS_PATH']."/Mailer/Unconfirmed/$type$email.php</h3>";

                




            // SEND MAIL
            try {
                $authSMTP = $GLOBALS['S_FORMS_PATH']."/Mailer/authSMTP.php";
                echo "<script>alert($authSMTP)</script>";
                include $authSMTP;
                // MAIL MESSAGE
                $mail->setFrom($emailfrom, $emailfromname);
                $mail->addAddress($emailto); // Email address where you want to receive emails (you can use any of your gmail address including the gmail address which you used as SMTP server)
                $mail->addReplyTo($emailreply, $emailreplyname);
            
                $mail->IsHTML(true);
                $mail->Subject = $subject;
                $logo = $GLOBALS['S_FORMS_PATH']."/Mailer/MailPages/logo.png";
                $mail->AddEmbeddedImage($logo,'logo');
                $mail->Body = $bodyToOwner;

                
                // ADAUGA ATASAMENTE DACA EXISTA
                if ($this->fisiere !== null) {
                    for ($i=0; $i<count($this->fisiere); $i++) {
                        $mail->AddAttachment($this->fisiere[$i]->tmp_name, $this->fisiere[$i]->name);
                    }
                }

            
            
                $mail->send();
                    // !!! DACA NU MERGE SCHIMBA PAROLA DE LA GMAIL
                    $status = "";
                    $respond = "<p class='flex nowrap left form_respond' id='form1end'>
                    <i class='fa fa-check-square-o' aria-hidden='true'></i>
                    Cererea ta ($type Query) a fost înregistrată cu succes. În curând vei primi si o confirmare pe email.</p>";
                    // echo "<script>window.location.href = '#form1end';</script>";

                    $phpforconfimation =  "<?php
        
                    include '../authSMTP.php';
        
                    \$emailto = '$email';
                    \$subject = '$subjToClient';
        
                    // MAIL MESSAGE
                    \$mail->setFrom('$emailfrom', '$emailfromname');
                    \$mail->addAddress(\$emailto); // Email address where you want to receive emails (you can use any of your gmail address including the gmail address which you used as SMTP server)
                    \$mail->addReplyTo('$emailreply', '$emailreplyname');
                
        
                    \$mail->IsHTML(true);
                    \$mail->Subject = \$subject;
                    // \$mail->AddEmbeddedImage('../MailPages/proof_confirm/images/ProfilePhoto.png','ProfilePhoto');
                    // \$mail->AddEmbeddedImage('../MailPages/proof_confirm/images/cover.jpg','cover');
                    // \$mail->AddEmbeddedImage('../MailPages/proof_confirm/images/bee.png','bee');
                    // \$mail->AddEmbeddedImage('../MailPages/proof_confirm/images/facebook2x.png','facebook2x');
                    // \$mail->AddEmbeddedImage('../MailPages/proof_confirm/images/facebook2x-1.png','facebook2x-1');
                    // \$mail->AddEmbeddedImage('../MailPages/proof_confirm/images/section-wave.png','section-wave');
                    // \$mail->AddEmbeddedImage('../MailPages/proof_confirm/images/logo.png','logo');
        
                    \$mail->Body = file_get_contents('../MailPages/$bodyToClient');
        
        
                    if(\$mail->send()) {
                        \$status = 'Success! <br>';
                        \$respond = 'Confirmarea $type Query a fost trimisă cu succes. Spor la Treabă!';
                        unlink(__FILE__);
                    } else {
                        \$status = 'Failed! <br>';
                        \$respond = 'Trimiterea mesajului a esuat: ' + \$mail->ErrorInfo;
                    }
            
                    echo \$status.\$respond;
            
        
                ?>";

                $unread = $GLOBALS['S_FORMS_PATH']."/Mailer/Unconfirmed/$type$email.php";
                $fp=fopen($unread,'w');
                fwrite($fp, $phpforconfimation);
                fclose($fp);
        

            } catch (phpmailerException $e) {
                $mailerror = $e->getMessage(); //Boring error messages from anything else!
                $respond = "<p class='form_respond'>Trimiterea mesajului a esuat. Vă rugăm să ne contactați pentru remediere problemei. Dorim din tot dinadinsul să aveți o experientă plăcută pe site-ul nostru. Vă mulțumim! Eroare: $mailerror </p>";
                echo $e->errorMessage(); //Pretty error messages from PHPMailer
            } catch (Exception $e) {
                $mailerror = $e->getMessage(); //Boring error messages from anything else!
                $respond = "<p class='form_respond'>Trimiterea mesajului a esuat. Vă rugăm să ne contactați pentru remediere problemei. Dorim din tot dinadinsul să aveți o experientă plăcută pe site-ul nostru. Vă mulțumim! Eroare: $mailerror  </p>";
            }
    
                // echo "<script>document.getElementById('$this->form_name').style.display = 'none';</script>";
                echo $respond;
                echo "<script>window.location.href = '#form1end';</script>";
            
        }
        
    }

    
}

$former = new former_class();

// Variabile
// - formular

// $nume = $_POST['nume'];
// $prenume = $_POST['prenume'];
// $companie = $_POST['companie'];
// $incercare = $_POST['incercare'];
// $email = $_POST['email'];
// $gdpr = $_POST['gdpr'];

// Functia care coloreaza prima litera a fiecarui cuvant din cadrul unui text
function highlight_text($text,$color1,$color2,$class="Fl") {
    $text_array = explode(" ",$text);
    $html = "";
    for ($i=0;$i<count($text_array);$i++) {
        if ($i==0) {
            $html = "<div class='$class' style='color: $color1;'>";
        }
        $firstletter = substr($text_array[$i],0,1);
        $otherletters = substr($text_array[$i],1,strlen($text_array[$i]));
        $html .= "<span style='color: $color2;'>$firstletter</span>$otherletters ";
        if ($i == count($text_array)-1) {
            $html .= "</div>";
        }
    }
    echo $html;
}

// FUNCTII
// validarea intrarilor (input)
function test_data($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}


?>