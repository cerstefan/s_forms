
████████████████████████████████████████████
█─▄▄▄▄███████▄─▄▄─█─▄▄─█▄─▄▄▀█▄─▀█▀─▄█─▄▄▄▄█
█▄▄▄▄─████████─▄███─██─██─▄─▄██─█▄█─██▄▄▄▄─█
▀▄▄▄▄▄▀▀▀▀▀▀▀▄▄▄▀▀▀▄▄▄▄▀▄▄▀▄▄▀▄▄▄▀▄▄▄▀▄▄▄▄▄▀


S_FORMS is a form generator.
Author: Cerlincă Ștefan
Year: 2021
Version: 1.0


To use this patch simply follow this steps:

1. Clone the git in your web page folder

2. Include this code in your web page, in head section:

    <?php include "s_forms/s_forms.php"?>

3. Configure Settings from s_forms folder of s_forms_conf.php file
4. Write your html message to send. (In Mailer folder in MailerPages)

4. Create the form as in the attached example




- label and placeholder of a field are optional.
- required are optional.(If this field are set, the form generate an error).


            {
              "type": "text",
              "name": "name",
              "value": "",
              "placeholder": "Numele tău",
              "label" : "this is a label",
              "class": "",
              "required": "Necesar"
            }

            Here the filed have a label, a placeholder and show an error if this 
            field are not complete.
            This code can also be type without label and placeholder and required

            {
              "type": "text",
              "name": "name",
              "value": "",
              "class": "",
            }

            Hare this code don't generate an error


- name from JSON must be uniqe.
- textarea doesn't have type property in JSON code, only input have type json property.

        {
            "tag": "textarea",
            "name": "descriere",
            "value": "",
            "placeholder": "Descrie proiectul tău aici.",
            "class": "",
            "required": "Necesar"
        }


- if you want to put a field into a div, or more fields you must put in json vector two matriceal
elements, fist must be "class" and the second, the name of the class as in the example:

    [
        "class",
        "name_of_the_class",
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
        }
    ]

