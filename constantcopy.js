function getLocation() {
  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(getPoliceStaion);
  } else { 
    alert("Geolocation is not supported by this browser.");
  }
}
function getPoliceStaion(position) {
    let lat = position.coords.latitude;
    let lng = position.coords.longitude;
    $.ajax({
                url: "ajax.php",
                method: "POST",
                data: {lat:lat,lng:lng,loc:true},
                dataType: "text",
                success: function(data)

                {
                    $('#myPoliceStation').append(data);

                }
            });
}
getLocation();





var ProgressBar = {
        template: 4,
        parent: '.maincontent',
        color: "red"
};
var queryProgress = new Mprogress(ProgressBar);


function error_reset(){
    $(".fa").css("display",'none');
    $(".warning_msg").css("display","none");
    $(".input_box").css('border-color','')
}



function error_set(){
    $(".fa").css("display",'inline');
    $(".warning_msg").css("display","inline");
    $(".input_box").css("border-color","red");
}



function selectData(url,data,callback){

    $.ajax({
                url: `${url}`,
                method: "POST",
                data: { data:data },
                dataType: "json",
                beforeSend: function() {
                    queryProgress.start();
                },
                success: function(data)
                {
                    queryProgress.end();
                    callback(data); 
                }
            });

}


function selectData1(url,data,callback){

    $.ajax({
                url: `${url}`,
                method: "POST",
                data: { data:data },
                
                success: function(data)
                {
                    
                    callback(data); 
                }
            });

}


function hider(){
    $('.register_des').hide();
    $('.otp_des').hide();
    $('.detail_des1').hide();
    $('.detail_des2').hide();
    $('.loc_des').hide();
    $('.profile_des').hide();
    $('.complaint_des').hide();
    $('.query_page_des').hide();
    $('.input_des').hide();


}

function selectLanguage (self) {

    lang = self.firstElementChild.innerText.toLowerCase();
    essential.language = lang;
    self.style.backgroundColor='#7d520e';
    self.firstElementChild.style.color = 'white';
    if (self.nextElementSibling==null) {
        self.previousElementSibling.style.backgroundColor='white';
        self.previousElementSibling.firstElementChild.style.color = 'black';
    }
    else{
        self.nextElementSibling.style.backgroundColor='white';
        self.nextElementSibling.firstElementChild.style.color = 'black';
    }
   
}
    





    function speak(sentance){
                    var synth = window.speechSynthesis;
                    arr_voices = synth.getVoices();
                    speaker = new SpeechSynthesisUtterance(sentance);
                    speaker.lang='hi-IN';
                    speaker.voice = arr_voices[1];
                    synth.speak(speaker);

}

function complaintclick(){
    
    $('.profile_des').hide();
    $('.complaint_des').show();


}

function edit(self){
    
    self.previousElementSibling.disabled=false;
}

function nextinput (self) {
    self.disabled=true;

    if (self.id=='when') {
        speak("Please Enter Place Of Crime");
        complaint.when = self.value;
    } else {
        speak("Please Enter Date Of Crime");
        complaint.where = self.value;
    }
     
}

function isLoggedIn(){
    personal_data = JSON.parse(sessionStorage.getItem('victim'));
    try {
        if (personal_data['isLogged']=='Yes') {
            return true;
        }   
    } 
    catch(e){ 
       return false;
    }   
}

function LoggedIn(victim){

    sessionStorage.setItem('victim', JSON.stringify(victim));
    retrievedVictim = sessionStorage.getItem('victim');
    sessionStorage.setItem('firstTime','true');

}

function Logout (argument) {

    victim= {};
    sessionStorage.removeItem('firstTime');
    sessionStorage.removeItem('victim');
    location.reload();
    
}

function intro(){

    if(sessionStorage.getItem('firstTime')=='true')
    {
        y = $('.tooltiptext');
        sessionStorage.setItem('firstTime','false');
        setTimeout(function(){
            y[0].style.visibility = 'hidden';
            y[1].style.visibility = 'hidden';
        },4000);
       
    }
    else {
        y = $('.tooltiptext');
        y[0].style.visibility = 'hidden';
        y[1].style.visibility = 'hidden';
    }
}

function select_location (self) {

    complaint.ps = self.value;
 
}

function final_complaint() {

    var res = confirm("Are You Sure You Want To Contiue \n Next You Will Get FIR Page \n Plase Enter All Incident Detail On FIR Page"); 

    if (res) {
        $('.agile_info').hide();
    } else {
        return false;
    }

}

function list_of_complaint(){
    try {

          let victim_data = JSON.parse(sessionStorage.getItem('victim'));
    query_data = {input_data:victim_data.phone == '' ? victim_data.phone : victim_data.aadhaar,list_complaint:true};
    selectData1('data.php',query_data,function(result){
        $('#myComp').append(result); 
    });
        
    } catch(e) {
        
    }
  
}
list_of_complaint();

function loader(hideref,showref,callback){
    hideref[0].style.opacity = 0.5;
    queryProgress.start();
    setTimeout(function(){
        queryProgress.end();
        hideref.hide();
        showref.show();
        callback("End");
    } , 2000);
}

function query_page(self) {

    var hideref = $('.profile_des');
    var showref = $('.query_page_des');
    loader(hide,show,function(result){
    speak("Please Enter Query");
    speak("Kripya Apni Sawaal Puchey ");
    console.log(self);
    essential.FirNo = self.value;
    essential.ps_code = self.name;
    document.getElementById('query_page_msg').innerHTML = "Enter Query About FIR NO : " + self.value;

    });


    
}



function query_submit () {
    let query = document.getElementById('query_txt').value;
    let victim_data = JSON.parse(sessionStorage.getItem('victim'));
    query_data = {input_data:victim_data.phone == '' ? victim_data.phone : victim_data.aadhaar,query:query,query_submit:true,
    FirNo:essential.FirNo,PsCode:essential.ps_code

};
    selectData('data.php',query_data,function(result){

        if (result=='query_success') {
            document.getElementsByClassName('query_page_des')[0].innerHTML='';
            var para = document.createElement("P");
            speak("Your query successfully sent Please check your message to see query response");
            para.style.color="green";
            para.innerHTML = "Your query successfully sent !! \n Please check your message to see query response"; 
            document.getElementsByClassName('query_page_des')[0].appendChild(para);
        } else {


             document.getElementsByClassName('query_page_des')[0].innerHTML='';
            var para = document.createElement("P");
            speak(`Your have already filed a query for FIR ${essential.FirNo}`);
            para.style.color="red";
            para.innerHTML = `Your have already filed a query for F.I.R ${essential.FirNo} `; 
            document.getElementsByClassName('query_page_des')[0].appendChild(para);


        }
    });
    
 

 
}


function input_des(self) {

     var hideref = $('.lang_des');
    var showref = $('.input_des');
    loader(hideref,showref,function(result){
        console.log('Okay');
    }) 
}





































































// $( window ).resize(function() {
//     console.log($(window).width());
// });
