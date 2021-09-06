<?php
        
                    include '../authSMTP.php';
        
                    $emailto = 'cerstefan27@gmail.com';
                    $subject = 'SitesWeavers - Am primit cererea dumneavoastră';
        
                    // MAIL MESSAGE
                    $mail->setFrom('contact@sitesweavers.com', 'SitesWeaver Clerk');
                    $mail->addAddress($emailto); // Email address where you want to receive emails (you can use any of your gmail address including the gmail address which you used as SMTP server)
                    $mail->addReplyTo('cerstefan27@gmail.com', 'SitesWeaver Clerk');
                
        
                    $mail->IsHTML(true);
                    $mail->Subject = $subject;
                    // $mail->AddEmbeddedImage('../MailPages/proof_confirm/images/ProfilePhoto.png','ProfilePhoto');
                    // $mail->AddEmbeddedImage('../MailPages/proof_confirm/images/cover.jpg','cover');
                    // $mail->AddEmbeddedImage('../MailPages/proof_confirm/images/bee.png','bee');
                    // $mail->AddEmbeddedImage('../MailPages/proof_confirm/images/facebook2x.png','facebook2x');
                    // $mail->AddEmbeddedImage('../MailPages/proof_confirm/images/facebook2x-1.png','facebook2x-1');
                    // $mail->AddEmbeddedImage('../MailPages/proof_confirm/images/section-wave.png','section-wave');
                    // $mail->AddEmbeddedImage('../MailPages/proof_confirm/images/logo.png','logo');
        
                    $mail->Body = file_get_contents('../MailPages/offer/index.html');
        
        
                    if($mail->send()) {
                        $status = 'Success! <br>';
                        $respond = 'Confirmarea Offer Query a fost trimisă cu succes. Spor la Treabă!';
                        unlink(__FILE__);
                    } else {
                        $status = 'Failed! <br>';
                        $respond = 'Trimiterea mesajului a esuat: ' + $mail->ErrorInfo;
                    }
            
                    echo $status.$respond;
            
        
                ?>