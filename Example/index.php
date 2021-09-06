<!DOCTYPE html>
<html>
<head>
    <?php include "s_forms/s_forms.php"?>
</head>
<body>
    
    <?php 
          $nume_form = "cere_oferta_form";
          $classa_form = "light";
          $elemente_formjson =  '[
          [
            {
              "type": "text",
              "name": "name",
              "value": "",
              "placeholder": "Numele tău",
              "class": "",
              "required": "Necesar"
            },
            {
              "type": "email",
              "name": "email",
              "value": "",
              "placeholder": "Adressa de email",
              "class": "",
              "required": "Necesar"
            }
          ],
          [
            {
              "type": "tel",
              "name": "tel",
              "value": "",
              "placeholder": "Număr de telefon",
              "class": "",
              "required": "Necesar"
            },
            {
              "type": "text",
              "name": "localitatea",
              "value": "",
              "placeholder": "Localitate",
              "class": "",
              "required": "Necesar"
            }
          ],
          [
            
              {
                "placeholder": "Încarcă fișiere",
                "type": "file",
                "name": "files",
                "value": "",
                "attributes": "multiple",
                "class": "",
                "id": "files_input"
              },
              {
                "type": "range",
                "name": "buget",
                "placeholder": "Bugetul tău este de ( Euro ): ",
                "placeholder2": "Dacă nu ai un buget estimat, poți lăsa 0",
                "value": "0",
                "attributes": "min=0 max=10000"
              }
            
          ],
          [
                "class",
                "checkboxes",
                {
                  "label": "Creare Site Web",
                  "type": "checkbox",
                  "name": "ch_creareSite",
                  "value": "checked",
                  "class": ""
                },
                {
                  "label": "Conținut / Copyright",
                  "type": "checkbox",
                  "name": "ch_copyright",
                  "value": "checked",
                  "class": ""
                },
                {
                  "label": "Branding și Campanii",
                  "type": "checkbox",
                  "name": "ch_brandingcampanii",
                  "value": "checked",
                  "class": ""
                },
                {
                  "label": "Consultanță Site",
                  "type": "checkbox",
                  "name": "ch_consultanta",
                  "value": "checked",
                  "class": ""
                },
                {
                  "label": "Realizare Site Tematic",
                  "type": "checkbox",
                  "name": "ch_siteTematic",
                  "value": "checked",
                  "class": ""
                },
                {
                  "label": "Creare Magazin Online",
                  "type": "checkbox",
                  "name": "ch_creareMagazin",
                  "value": "checked",
                  "class": ""
                },
                {
                  "label": "Redesign Site",
                  "type": "checkbox",
                  "name": "ch_redesign",
                  "value": "checked",
                  "class": ""
                },
                {
                  "label": "Integrare Facilități",
                  "type": "checkbox",
                  "name": "ch_integrareFacilitati",
                  "value": "checked",
                  "class": ""
                },
                {
                  "label": "Identitate Vizuală",
                  "type": "checkbox",
                  "name": "ch_identitateVizuala",
                  "value": "checked",
                  "class": ""
                },
                {
                  "label": "Realizare Logo/Siglă",
                  "type": "checkbox",
                  "name": "ch_logo",
                  "value": "checked",
                  "class": ""
                },
                {
                  "label": "Materiale Publicitare",
                  "type": "checkbox",
                  "name": "ch_materialePublicitare",
                  "value": "checked",
                  "class": ""
                },
                {
                  "label": "Email Marketing",
                  "type": "checkbox",
                  "name": "ch_emailMarketing",
                  "value": "checked",
                  "class": ""
                },
                {
                  "label": "Promovare SEO",
                  "type": "checkbox",
                  "name": "ch_promovareSEO",
                  "value": "checked",
                  "class": ""
                },
                {
                  "label": "Promovare AdWords",
                  "type": "checkbox",
                  "name": "ch_promovareAdWords",
                  "value": "checked",
                  "class": ""
                },
                {
                  "label": "Social Media Marketing",
                  "type": "checkbox",
                  "name": "ch_socialMediaMarketing",
                  "value": "checked",
                  "class": ""
                },
                {
                  "label": "Securitate Site Web",
                  "type": "checkbox",
                  "name": "ch_securitateSiteWeb",
                  "value": "checked",
                  "class": ""
                },
                {
                  "label": "Servicii Administrate",
                  "type": "checkbox",
                  "name": "ch_serviciiAdministrate",
                  "value": "checked",
                  "class": ""
                },
                {
                  "label": "+Altele",
                  "type": "checkbox",
                  "name": "ch_altele",
                  "value": "checked",
                  "class": ""
                }
          ],
          [
            {
              "tag": "textarea",
              "name": "descriere",
              "value": "",
              "placeholder": "Descrie proiectul tău aici.",
              "class": "",
              "required": "Necesar"
            }
          ],
          [
            {
              "name": "gdpr",
              "type": "checkbox",
              "label": "Sunt de acord ca datele introduse să fie colectate, prelucrate și stocate, în vederea primirii ofertei.",
              "value": "checked",
              "required": "Pentru a putea să vă trimitem oferta, trebuie să fiți de acord ca datele introduse să fie prelucrate de către noi. Vă rugăm să bifați această căsuță!"
            }
          ],
          [
            {
              "type": "submit",
              "name": "submit",
              "value": "Trimite Cererea",
              "placeholder": "",
              "class": "submit_button"
            }
          ]
        ]';

          
        
        $former->generate_form($nume_form, $classa_form, $elemente_formjson);
        // trimite emailul daca primeste o cerere post
        // $former->send_mail(Type, ToOwnerMail, SubjectToClient, BodyToClient_path)
        $former->send_mail("Offer", "cerstefan27@gmail.com", "SitesWeavers - Am primit cererea dumneavoastră", "offer/index.html"); 

    ?>


</body>
</html>