
<!DOCTYPE html>
<html>
  <head>
    <title></title>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>


    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>

    <script type="text/javascript">
        $("#btnPrint").live("click", function () {
            var divContents = $("#paper").html();
           var printWindow = window.open('', '', 'height=auto,width=auto');
           printWindow.document.write('<html><head><link rel="stylesheet" type="text/css" href="style.css"></head><body >');
           printWindow.document.write(divContents);
           printWindow.document.write('</body></html>');
           printWindow.document.close();
           printWindow.print();

        //    var save = '<html><head><link rel="stylesheet" type="text/css" href="style.css"></head><body >'+divContents+'</body></html>';
           
        // ;
        //    var signdata = 'success';

          //   $.ajax({
          //     method: "POST",
          //     url: "saveSign.php",
          //     data: {signdata:signdata,ver:true},
          //     dataType:'text',
          //     beforeSend:function(){
          //       console.log("hello")
          //     },
          //     success: function(finalresult){
          //      alert(finalresult);
          //     if(finalresult == 'success'){
          //       alert(finalresult);
             
          //     }
                          
          // }
        
          // });


            
        });
    </script>

</body>
   
            

  </head>
  <body onload="showDate()">
    <script >
    var finalTranscripts = '';
    
    var micStart = 0;
   
    function changeText() {
        finalTranscripts = document.getElementById('result').innerHTML;
    }

    function startCon() {
        var language = document.getElementById('language').value;
        document.getElementById('language').disabled = true;
        if (language == 'hi-IN') {
            var option = {
                weekday: 'long',
                year: 'numeric',
                month: 'long',
                day: 'numeric'
            };
            var today = new Date();
            document.getElementById('date').innerHTML = 'दिनांक - ';
            document.getElementById('date').append(today.toLocaleDateString("hi-IN", option));
            document.getElementById('to').innerHTML = 'सेवा में,';
            document.getElementById('police').innerHTML = 'श्रीमान थानाध्यक्ष,';
            document.getElementById('station').innerHTML = 'वडाला पुलिस चौकी,';
            document.getElementById('address').innerHTML = 'वडाला ट्रक टर्मिनल,';
            document.getElementById('Respected').innerHTML = 'महोदय,';
            document.getElementById('idno').innerHTML = 'आईडी नंबर  - ';
            document.getElementById('mobile').innerHTML = 'मोबाइल नंबर - ';
            document.getElementById('vname').innerHTML = 'शिकायतकर्ता';
            document.getElementById('thank').innerHTML = 'धन्यवाद';
        }
        if ('webkitSpeechRecognition' in window) {
            var speechRecognizer = new webkitSpeechRecognition();
            speechRecognizer.continuous = true;
            speechRecognizer.interimResults = true;
            speechRecognizer.lang = language;
            speechRecognizer.start();
            if (micStart == 1) {
                speechRecognizer.stop();
                document.getElementById("image").src = "mic1.png";
                micStart = 0;
                return false;
                
            } else {
                micStart = 1;
                document.getElementById("image").src = "mic.gif";
                speechRecognizer.onresult = function(event) {
                  var interimTranscripts = '';
                    for (var i = event.resultIndex; i < event.results.length; i++) {
                        var transcript = event.results[i][0].transcript;
                        if (event.results[i].isFinal) {
                            finalTranscripts += transcript;
                        } else {
                            interimTranscripts += transcript;
                        }
                    }
                   
                  document.getElementById('result').innerHTML = finalTranscripts + '<span style="color:grey">' + interimTranscripts + '</span>';
                };
                speechRecognizer.onerror = function(event) {};
            }
          }
         else {
            document.getElementById('result').innerHTML = "Your Browser does not support Speech Recognition.";
        }
    }

    function showDate() {
        var victim = JSON.parse(sessionStorage.getItem('victim'));
        var complaint = JSON.parse(sessionStorage.getItem('complaint'));

        document.getElementById('idno').innerHTML = victim.aadhaar ;
        document.getElementById('mobile').innerHTML = victim.phone ;
        document.getElementById('vname').innerHTML = victim.name;

        document.getElementById('station').innerHTML = 'Wadala Truck PS Police Station';
        document.getElementById('address').innerHTML = "Wadala Truck PS";





        console.log(victim,complaint);

        var today = new Date().toLocaleString();
        document.getElementById('date').append(today);
    }
    
    </script>


    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-8 mt-2">
            <div id="paper">
        <div id="pattern">
          <div id="content">
            <label class="txt">Ack : ACK1020125</label><br/>
            <label id="to">To,</label><br/>
            <label id="police">The Police Officer,</label><br>
            <label id="station"></label><br>
            <label id="address"></label><br>
            <label id="date">Date - </label><br>
            <label id="Respected">Respected Sir,</label><br><br>
            <p id="result" contenteditable="true" onfocusout="changeText()" style="text-indent: 50px;"></p><br><br><br>
            <br><br><img src="" id="imgsaveSignature" width="200" height="50" style="display:none; position: absolute; bottom:160px; margin-left: 500px;"/><br>
            <span style="bottom:150px; position: absolute; margin-left: 0%">----------------------</span><br>
            <label style="bottom:130px; position: absolute; margin-left: 5%">(S.H.O)</label>
           <span style="bottom:150px; position: absolute; margin-left: 60%">-----------------------</span><br>
            <label  id="idno" style="bottom:125px; position: absolute; margin-left: 60%"></label>
            <label  id="mobile"  style="bottom:100px; position: absolute; margin-left: 60%"></label>
            <label  id="vname" style="bottom:75px; position: absolute; margin-left: 60%"></label>
            <label  id="thank" style="bottom:50px; position: absolute; margin-left: 60%">Thanking You</label>
          </div>
        </div>
      </div>
      </div>
        <!-- <div class="col-sm-2 col-md-12 col-lg-1"></div> -->
       <center><div class="col-sm-12 col-md-12 col-lg-4" style="max-width: 350px;">
             <button  onclick="startCon()" id="micStart" class="mt-2"><img id="image" src="mic1.png" width="100" height="50"></button><br>
            <label style="color:red;font-weight: bold;margin-left: 15px;">Please select your language below(by Default english)</label>
            <div style="margin-left: 10px; ">
            <?php include 'sign.html'; ?>
        </div>
        </div></center>
      </div>
    </div> 

  </body>
</html>