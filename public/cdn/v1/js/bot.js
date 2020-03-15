<script  >
var xhr = new XMLHttpRequest();

var body = 'myua=' + encodeURIComponent(navigator.userAgent) +'&myurl='+encodeURIComponent(window.location.href);



xhr.open("POST", 'https://cloud.neiros.ru/api/widget_site/get_bot_metrika/1', true);
xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

//    xhr.onreadystatechange = ...;

xhr.send(body);
xhr.onreadystatechange = function() { // (3)
    if (xhr.readyState != 4) return;



    if (xhr.status != 200) {

    } else {


        otvet=xhr.responseText;
        jsonotvet=JSON.parse(otvet);



        if(jsonotvet['res']==1) {
            idelementemail = jsonotvet['id_replace'].split('#')[1];
            classelementemail = jsonotvet['id_replace'].split('.')[1];

            a = document.getElementsByClassName(classelementemail);
            for (var i = 0; i < a.length; i++) {

                a[i].innerHTML = jsonotvet['new_url'];


            }

            bn = document.getElementById(idelementemail);
            if (bn != null) {


                bn.innerHTML = jsonotvet['new_url'];

            }

        }
















    }

}</script>