<!DOCTYPE html >
  <head>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
    <meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
    <link rel="stylesheet" href="mdl/material.css">
    <link rel="stylesheet" href="css/estilo.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">

    <title>Sistema de Geolocalização</title>
    <style>

      #map {
        height: 100%;
      }

      html, body {
        height: 100%;
        margin: 0;
        padding: 0;
      }
    </style>
  </head>

  <body>
    <div class="mdl-layout mdl-js-layout mdl-layout--fixed-header">
       <header class="mdl-layout__header">
    <div class="mdl-layout__header-row">

      <div class="mdl-layout-spacer"></div>

      <nav class="mdl-navigation mdl-layout--large-screen-only">

   <span class="logo-lg">
<img src="logo_joinville.png" width="90px" height="40px" />
      </nav>
    </div>
  </header>
  <div class="mdl-layout__drawer">
    <span class="mdl-layout-title">Menu</span>
    <nav class="mdl-navigation">
      <a class="mdl-navigation__link" href="">Clinicas de Fisioterapia</a>
      <a class="mdl-navigation__link" href="">Hospitais</a>
      <br><br><br><br>
       <button id="show-dialog" type="button" class="mdl-button">Adicionar Endereços</button>
        
  <dialog class="mdl-dialog">
    <h4 class="mdl-dialog__title"></h4>

    <div class="mdl-dialog__content">
    <p>

     <form id="cadUsuario" method="post" action="">
     <div class="mdl-textfield mdl-js-textfield">
     <input class="mdl-textfield__input" type="text" name="name">
     <label class="mdl-textfield__label" for="name">Nome</label>
    </div>

      <div class="mdl-textfield mdl-js-textfield">
      <input class="mdl-textfield__input" type="text" name="address">
      <label class="mdl-textfield__label" for="address">Endereco</label>
    </div>

      <div class="mdl-textfield mdl-js-textfield">
      <input class="mdl-textfield__input" type="text" name="lat">
      <label class="mdl-textfield__label" for="lat">Latitude</label>
    </div>

      <div class="mdl-textfield mdl-js-textfield">
      <input class="mdl-textfield__input" type="text" name="lng">
      <label class="mdl-textfield__label" for="lng">Longitude</label>
    </div>

      <div class="mdl-textfield mdl-js-textfield">
      <input class="mdl-textfield__input" type="text" name="type">
      <label class="mdl-textfield__label" for="type">Tipo</label>
    </div>


      <div class="mdl-dialog__actions">
      <button class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored" type="button" value="salvar" id="salvar">Adicionar</button>
      <button type="button" class="mdl-button close">Sair</button>
    </div> 
  </form>
</p>
</div>

<div id="ret_certo" align="center">
<p><strong></strong></p>
</div>
</dialog>

    </nav>

  </div>
  <main class="mdl-layout__content">

    <div class="page-content"></div>
  </main>

  <div id="map">
    <div align="center">
      <br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>

<div class="mdl-spinner mdl-spinner--single-color mdl-js-spinner is-active"></div>
</div>
    </div>
  </div>
</div>

    </div>
    

  
        <script src="js/jquery-3.2.1.min.js"></script>
    <script defer src="https://code.getmdl.io/1.3.0/material.min.js"></script>
    <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCbWoLA-dQ6vX4ZuvHVyemx8Razkyg0HAA&callback=initMap">
    </script>
    <script src="mdl/material.js"></script>
    <script src="js/addendereco.js"></script>

      <script>

 /// Quando usuário clicar em salvar será feito todos os passo abaixo




    var dialog = document.querySelector('dialog');
    var showDialogButton = document.querySelector('#show-dialog');
    if (! dialog.showModal) {
      dialogPolyfill.registerDialog(dialog);
    }
    showDialogButton.addEventListener('click', function() {
      dialog.showModal();
    });
    dialog.querySelector('.close').addEventListener('click', function() {


      dialog.close();
    });




      var customLabel = {
        hospital: {
          label: 'Hospital'

        },
        clinica: {
          label: 'Clinica'
        }
      };

        function initMap() {
        var map = new google.maps.Map(document.getElementById('map'), {
          center: new google.maps.LatLng(-26.298763, -48.851040),
          zoom: 13
        });
        var infoWindow = new google.maps.InfoWindow;

          // Change this depending on the name of your PHP or XML file
          downloadUrl('dados.php', function(data) {
            var xml = data.responseXML;
            var markers = xml.documentElement.getElementsByTagName('marker');
            Array.prototype.forEach.call(markers, function(markerElem) {
              var name = markerElem.getAttribute('name');
              var address = markerElem.getAttribute('address');
              var type = markerElem.getAttribute('type');
              var point = new google.maps.LatLng(
                  parseFloat(markerElem.getAttribute('lat')),
                  parseFloat(markerElem.getAttribute('lng')));

              var infowincontent = document.createElement('div');
              var strong = document.createElement('strong');
              strong.textContent = name
              infowincontent.appendChild(strong);
              infowincontent.appendChild(document.createElement('br'));

              var text = document.createElement('text');
              text.textContent = address
              infowincontent.appendChild(text);
              var icon = customLabel[type] || {};
              var marker = new google.maps.Marker({
                map: map,
                position: point,
                label: icon.label
              });
              marker.addListener('click', function() {
                infoWindow.setContent(infowincontent);
                infoWindow.open(map, marker);
              });
            });
          });
        }



      function downloadUrl(url, callback) {
        var request = window.ActiveXObject ?
            new ActiveXObject('Microsoft.XMLHTTP') :
            new XMLHttpRequest;

        request.onreadystatechange = function() {
          if (request.readyState == 4) {
            request.onreadystatechange = doNothing;
            callback(request, request.status);
          }
        };

        request.open('GET', url, true);
        request.send(null);
      }

      function doNothing() {}



    </script>


    
    

  </body>
</html>