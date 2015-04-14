<!DOCTYPE html>
<html>
<head>
<meta charset='utf-8' />
	<link rel="stylesheet" href="css/bootstrap.css" type="text/css" >
	<?php
		include('HeaderBar.html');
	?>

		<title>jQuery UI Datepicker - Default functionality</title>
  		 <link rel="stylesheet" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">
  		<script src="//code.jquery.com/jquery-1.10.2.js"></script>
  		<script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
  		<link rel="stylesheet" href="/resources/demos/style.css">

<style>

    label, input 
    { 
        display:block; 
    }
    input.text 
    { 
        margin-bottom:12px; 
        width:95%; 
        padding: .4em; 
    }
    fieldset 
    { 
        padding:0; 
        border:0; 
        margin-top:25px; 
    }
    h1 
    { 
        font-size: 1.2em;
         margin: .6em 0; 
    }
    div#users-contain 
    { 
        position: relative;
        left: 10%;
        top:22%;
        margin: 20px 0; 
    }
    div#users-contain table 
    { 
        margin: 2em 0; 
        border-collapse: collapse; 
        width: 81.1%;
        /*position: fixed;*/

    }
    div#users-contain table td, div#users-contain table th 
    { 
        border: 1px solid #eee; 
        padding: .4em 10px; 
        text-align: center; 
    }
    .ui-dialog .ui-state-error 
    { 
        padding: .3em; 
    }
    .validateTips 
    { 
        border: 1px solid transparent; padding: 0.3em; 
    }
    #create-user{
        position: fixed;
        left: 10%;
        top: 28.5%;
    }
  </style> 

</head>


<body>

	<script src="js/bootstrap.js"></script>

	<div id='content'>
  		<h1 class="text-center">Events</h1>
  		<br class="text-center">
 	<p class="text-center">Use this section to link your events to Google Calendar</p>
 	<br>
  		<ul id='events'></ul>
 	</div>
 	



	<button class="btn" id="authorize-button" style="visibility: hidden">Sign-in  </button>
 
 
		 <script type="text/javascript">
		      var clientId = '468920552864-l1s08fc3dd9sb563ktbecsha4mqn3eno.apps.googleusercontent.com';
		      var apiKey = 'AIzaSyBujiF5tLPSTDxw1njHlEtqYUYFXHAmgNQ';
		      var scopes = 'https://www.googleapis.com/auth/calendar';
		    
		      function handleClientLoad() {
		        gapi.client.setApiKey(apiKey);
		        window.setTimeout(checkAuth,1);
		      		}
		
		      function checkAuth() {
		        gapi.auth.authorize({client_id: clientId, scope: scopes, immediate: true}, handleAuthResult);
		      }
		
		
		      function handleAuthResult(authResult) {
		        var authorizeButton = document.getElementById('authorize-button');
		        var insertButton = document.getElementById('insert-button');
		        if (authResult && !authResult.error) {
		          authorizeButton.style.visibility = 'hidden';
		          makeApiCall();
		          insertButton.style.visibility = '';
		          insertButton.onclick = handleInsertClick;
		        } else {
		          authorizeButton.style.visibility = '';
		        
		          insertButton.style.visibility = 'hidden';
		        
		          authorizeButton.onclick = handleAuthClick;
		        }
		      }
		
		      function handleAuthClick(event) {
		        gapi.auth.authorize({client_id: clientId, scope: scopes, immediate: false}, handleAuthResult);
		        return false;
		      }
		    
		      function handleInsertClick(event) {
		       makeInsertApiCall();
			   iframe();
		      }
		
		    
		
		      function makeInsertApiCall() {
				  	var inicio =  document.getElementById("datepicker").value +'T'+ document.getElementById("start_time").value+":00-06:00";
					var fin = document.getElementById("datepickerend").value +'T'+ document.getElementById("end_time").value +":00-06:00";

					var datepicker = document.getElementById("datepicker").value;
   			 		var start_time = document.getElementById("start_time").value;
   					var end_time = document.getElementById("end_time").value;
   			 		var datepickerend = document.getElementById("datepickerend").value;
   			 		var evento = document.getElementById("evento").value;
   			 		var correo = document.getElementById("correo").value;
   			 		var dat = [];

   			 if (datepicker =="") {
   				 dat.push("Ingresa correctamente la fecha de inicio");	 
   			 }

   			 if (start_time == "") {
   				 dat.push("Ingresa correctamente la hora de inicio");
   			 }

   			 if (end_time == "") {
   				 dat.push("Ingresa correctamente la hora de fin");
   			 }

   			 if (datepickerend == "") {
   				 dat.push("Ingresa correctamente la fecha de termino");
   			 }

   			 if (evento == "") {
   				 dat.push("Ingresa el nombre del evento");
   			 }

   			 if (correo == "") {
   				 dat.push("Ingresa el nombre del correo");
   			 }
 
   			 if (dat.length > 0) {
   				 for (var i = dat.length - 1; i >= 0; i--) {
   					 alert(dat[i]);
   				 };
   				 return;
   			 }

				   gapi.client.load('calendar', 'v3', function() {
		            var request = gapi.client.calendar.events.insert({
		           "calendarId": "primary",
				    
		           resource:{
		               "summary": ""+document.getElementById("evento").value+"",
		               "location": "Somewhere",
					   "hangoutLink": "",
					   "htmlLink": "",
					   "visibility": "public",
		               "start": {
						 "timeZone": "America/Monterrey",
		                 "dateTime": ""+inicio+""
		               		},
		               	"end": {
						 "timeZone": "America/Monterrey",
		                 "dateTime": ""+fin+""
		               }	
		             }
		         });
		              
		         request.execute(function(resp) {
		                
					 var imprimir_fecha = document.getElementById("inicio").value;	  
					 var imprimir_hora = document.getElementById("hora").value;
		             var li = document.createElement('li');
		             li.appendChild(document.createTextNode(resp.summary));
		             document.getElementById('events').appendChild(li);		  
		         });
		       });
		     }
			
			//extra 
			var x = false;
			 function makeApiCall() {
		       gapi.client.load('calendar', 'v3', function() {
		         var request = gapi.client.calendar.events.list({
		           'calendarId': 'primary'
		         });
		              
		         request.execute(function(resp) {
		           for (var i = 0; i < resp.items.length; i++) {
		             /*
					 var li = document.createElement('li');
		             li.appendChild(document.createTextNode(resp.items[i].summary));
		             document.getElementById('events').appendChild(li);
					 */
					 if(!x){
						//alert("I am in!");
						x = true;
					 }

					 var tr2 = document.createElement('p');
		             var tr = document.createElement('tr');
		             tr.appendChild(document.createTextNode(resp.items[i].summary));
		             document.getElementById('eventos').appendChild(tr);
		             document.getElementById('eventos').appendChild(tr2);
		      		
		          	var hh2 = document.createElement('p');
		          	var hh = document.createElement('tr');
		            var hg = document.createElement('a');
		            hg.href = resp.items[i].hangoutLink;
		            var as = document.createElement('img');

		             as.src = 'hang.png';
		             hg.appendChild(as);			           			         	
		             document.getElementById('hg').appendChild(hg);
		             document.getElementById('hg').appendChild(hh);
		             document.getElementById('hg').appendChild(hh2);

		             
		             var p1 = document.createElement('p');
		             var f1 = document.createElement('form');
		        	 f1.setAttribute("style", "height: 25px; padding-top: 4px");		        
		             f1.action = "https://www.paypal.com/cgi-bin/webscr";
		             f1.method = "POST";
		             
		             var i1 = document.createElement("input");
		             i1.type = "hidden";
		             i1.value = "_xclick";
		             i1.name = "cmd";
		             
		             var i2 = document.createElement("input");
		             i2.type = "hidden";
		             i2.value = "alverto_94@hotmail.com";
		             i2.name = "business";

		             var i3 = document.createElement("input");
		             i3.type = "hidden";
		             i3.value = "MX";
		             i3.name = "lc";

		             var i4 = document.createElement("input");
		             i4.type = "hidden";
		             i4.value = "Asesoria";
		             i4.name = "item_name";

		             var i5 = document.createElement("input");
		             i5.type = "hidden";
		             i5.value = "1";
		             i5.name = "item_number";

		             var i6 = document.createElement("input");
		             i6.type = "hidden";
		             i6.value = "200.00";
		             i6.name = "amount";

		             var i7 = document.createElement("input");
		             i7.type = "hidden";
		             i7.value = "MXN";
		             i7.name = "currency_code";

		             var i8 = document.createElement("input");
		             i8.type = "hidden";
		             i8.value = "services";
		             i8.name = "button_subtype";

		             var i9 = document.createElement("input");
		             i9.type = "hidden";
		             i9.value = "0";
		             i9.name = "no_note";

		             var i10 = document.createElement("input");
		             i10.type = "hidden";
		             i10.value = "16.000";
		             i10.name = "tax_rate";

		             var i11 = document.createElement("input");
		             i11.type = "hidden";
		             i11.value = "PP-BuyNowBF:btn_buynowCC_LG.gif:NonHostedGuest";
		             i11.name = "bn";

		             var i12 = document.createElement("input");
		             i12.type = "image";
		             i12.name = "submit";
		             i12.src = "https://www.paypalobjects.com/es_XC/i/btn/btn_buynow_SM.gif";
		             i12.border = "0";
		             i12.alt = "PayPal, la forma más segura y rápida de pagar en línea.";

		             var i13 = document.createElement("img");
		             i13.alt = "";
		             i13.border = "0";
		             i13.src = "https://www.paypalobjects.com/es_XC/i/scr/pixel.gif";
		             i13.width = "1";
		             i13.height = "1";

		             f1.appendChild(i1);
		             f1.appendChild(i2);
		             f1.appendChild(i3);
		             f1.appendChild(i4);
		             f1.appendChild(i5);
		             f1.appendChild(i6);
		             f1.appendChild(i7);
		             f1.appendChild(i8);
		             f1.appendChild(i9);
		             f1.appendChild(i10);
		             f1.appendChild(i11);
		             f1.appendChild(i12);
		             f1.appendChild(i13);

		             document.getElementById("pay").appendChild(f1);
		             document.getElementById("pay").appendChild(p1);
					 
		           }
		         });
		       });
		     }
		    //extra
		    
		  </script>   
   
<script src="https://apis.google.com/js/client.js?onload=handleClientLoad"></script>

<script>
 $(function() {

   			 $( "#datepicker" ).datepicker({ dateFormat: "yy-mm-dd" });
   			 $( "#datepickerend" ).datepicker({ dateFormat: "yy-mm-dd" });
   			 
   		 });
  </script>


 <form method="post" action="proc_cal.php">	 
<p class="text-info">Name: <input class="input-sm" type="text" id="evento" name="nombre" style="width: 500px; height: 32px;"/></p>
<p class="text-info">Start Date: <input class="input-sm" type="text" id="datepicker" nombre="datepicker" style="width: 500px; height: 32px;"></p>
 <p class="text-info">Time: <input class="input-sm" id="start_time" name="start_time" type="time" size="30" ></p>
 <p class="text-info">End date: <input class="input-sm" type="text" id="datepickerend" name="datepickerend"></p>
 <p class="text-info">Time: <input class="input-sm" id="end_time" nombre="end_time" type="time" size="30"></p>
 <p class="text-info">Email<input class="input-sm" type="email" id="correo" name="email" placeholder="user@example.com" style="width: 280px; height: 32px;"></p>
<p class="text-info">&nbsp;</p>
<button class="btn" id="insert-button" style="visibility: hidden">Insert to calendar</button>
</form>

<thead>
<div id="users-contain" class="ui-wid">
<table id="users" class="ui-widget ui-widget-content">
<thead>
	<tr  class="ui-widget-header">
		<td>Asesoria</td>
		<td>Hangout</td>
		<td>PayPal</td>
	</tr>
</thead>
<tbody>
	<tr>
		<td id="eventos"></td>
		<td id="hg"></td>
		<td id= "pay"></td>
	</tr>
</tbody>
</table>



</body>
</html>