<!DOCTYPE html>
<html lang="en">
    <head>
        <?php include "required.html";?>
        <script>
        $(document).ready(function() {


     $('.submit').click(function() {
         let input_data = $('#input_data').val();
         if (input_data.length == 10) {
             essential.ver_type = 'phone';
             victim.phone = input_data;
             victim.aadhaar = '';
             error_reset();
         } else if (input_data.length == 12) {
             essential.ver_type = 'aadhaar';
             victim.aadhaar = input_data;
             victim.phone = '';
             error_reset();
         } else {
             error_set();
             return false;
         }
         query_data = { input_data: input_data, ver_type: essential.ver_type };
         selectData('verification.php', query_data, function(result) {
             console.log(result);
             if (result == 'not_registered') {
                 victim.isReg = 'No';
                 loader( $('.input_des'),$('.otp_des'),function(result){
                    if(language()=="english"){
                        speak("Please Enter OTP");
                    }
                    else{
                        speak("Kripya OTP Daale");
                    }
                 });
                 
                 
             } else if (result == 'registered') {
                 victim.isReg = 'Yes';
                 loader( $('.input_des'),$('.otp_des'),function(result){
                     if(language()=="english"){
                        speak("Please Enter OTP");
                    }
                    else{
                        speak("Kripya OTP Daale");
                    }
                 });
             }
         });
     })
     $('.verify').click(function() {
         let otp = $('#otp').val();
         query_data = {
             input_data: essential.ver_type == 'phone' ? victim.phone : victim.aadhaar,
             ver_type: essential.ver_type,
             isReg: victim.isReg,
             otp: otp,
             otp_ver: true
         };
         selectData('otp_verify.php', query_data, function(result) {
             console.log(result);
             if (result == 'ver_success' /* phone_ver_success */ || result[8] == 'ver_success' && victim.isReg == 'No' /* aadhaar_ver_success */ ) {
                 if (essential.ver_type == 'phone') {
                    loader( $('.otp_des'),$('.detail_des2'),function(result){

                         if(language()=="english"){
                            speak("Please Enter Following Details");
                        }
                        else{
                            speak("Kripya NimanLikhit Jankaari Daale");
                        }
                    });
                     
                 } else if (essential.ver_type == 'aadhaar') {
                    loader($('.otp_des'),$('.detail_des1'),function(result){

                         if(language()=="english"){
                            speak("Please Check Following Details");
                        }
                        else{
                            speak("Kripya NimanLikhit Jankaari Deke");
                        }


                    });
                     victim.name = result[1];
                     victim.aadhaar = result[2];
                     victim.d_o_b = result[3];
                     victim.address = result[4];
                     victim.gender = result[5];
                     victim.phone = result[7];
                     document.getElementById('name').innerHTML = 'Name : ' + victim.name;
                     document.getElementById('aadhaar_no').innerHTML = 'Aadhaar Number:' + victim.aadhaar;
                     document.getElementById('dob').innerHTML = 'DOB : ' + victim.d_o_b;
                     document.getElementById('add').innerHTML = 'Address:' + victim.address;
                     document.getElementById('contact').innerHTML = 'Contact Number:' + victim.phone;
                     document.getElementById('gender').innerHTML = 'Gender:' + victim.gender;
                 }
             } else if (result == 'ver_success' || result[9] == 'ver_success' && victim.isReg == 'Yes') {

                 loader($('.input_des'),$('.profile_des'),function(result){

                     if(language()=="english"){
                            speak("Please Click on Plus Sign To File New FIR");
                        }
                        else{
                            speak("Nayi FIR Bharne Ke Liye Plus Sign Pe Click Kare");
                        }



                 });
                 victim.isLogged = 'Yes';
                 victim.name = result[1];
                 victim.aadhaar = result[2];
                 victim.d_o_b = result[3];
                 victim.address = result[4];
                 victim.gender = result[5];
                 victim.phone = result[7];
                 LoggedIn(victim);
                 location.reload();
                 
                 
             } else {
                 console.log(result + 'failed');
                 error_set(); //invalid otp
                 return false;
             }
         });
     })
     $('.aadhaar_next').click(function() {
         let query_data = victim;
         if (victim.isReg == 'No') {
             selectData('functions.php', query_data, function(result) {
                 console.log(result);
                 if (result == true) {
                     victim.isReg = 'Yes';
                     victim.isLogged = 'Yes';
                     sessionStorage.setItem('victim', JSON.stringify(victim));
                     retrievedVictim = sessionStorage.getItem('victim');
                     LoggedIn(victim);
                     location.reload();
                     
                     
                 }
             });
         }
     })
     $('.phone_next').click(function() {
         victim.name = $('#username').val();
         victim.d_o_b = $('#userdob').val();
         victim.address = $('#useraddress').val();
         victim.gender = $('#usergender').val();
         let query_data = victim;
         if (victim.isReg == 'No') {
             selectData('functions.php', query_data, function(result) {
                 console.log(result);
                 if (result == true) {
                     victim.isReg = 'Yes';
                     victim.isLogged = 'Yes';
                     sessionStorage.setItem('victim', JSON.stringify(victim));
                     retrievedVictim = sessionStorage.getItem('victim');
                     LoggedIn(victim);
                     location.reload();

                     
                 }
             });
         } 
     })

 })
        </script>
    </head>
    <body>
        <div class="loader"></div>
        <div class="signupform">
            <div style="border: 1px solid #f2f1ed;padding-left:25px;" class="container maincontent">
                <div class="agile_info">
                    <div class="w3l_form">
                        <div class="left_grid_info">
                            <img style="width: 150px;align-self: center;" src="vp.png" alt="" />
                            <h1 style="font-size: 25px" >Virtual Police Station</h1>
                        </div>
                    </div>

                    <div class="lang_des" style="padding: 20px;">
                        <div style="box-shadow: 1px 2px 4px rgba(0, 0, 0, .5);padding: 20px">
                             <h2 style="margin-left: 51px;font-size: 20px">Please Select Language</h2>
                        <div style="display: flex;flex-direction: row;justify-content: space-around;">
                            <div class="input-group input_box lang" onclick="selectLanguage(this)" style="display:flex;justify-content: center;
                                border-radius: 50%;align-items: center;padding: 9% 3%;
                                ">
                                <h4>ENGLISH</h4>
                            </div>
                            <div class="input-group input_box lang"  onclick="selectLanguage(this)" style="display:flex;justify-content: center;
                                border-radius: 50%;align-items: center;padding: 9% 6%;
                                ">
                                <h4>HINDI</h4>
                            </div>
                        </div>
                        <h3 style="margin-left: 51px" class="warning_msg">Please Select Langugae</h3><br>
                        <button class="btn btn-danger btn-block lang-next" onclick="input_des(this)" type="submit" style="margin-top: 10px;margin-left: 51px">NEXT</button >
                        </div>
                       
                    </div>

                    <div class="input_des" style="padding: 40px">
                        <h2>Please Verify Your Aadhar Or Phone</h2>
                        <div class="input-group input_box" style="display: flex;flex: 1;flex-direction:row;">
                            <img style="width: 30px;height: 25px;margin-top: 10px"  src="assets/image/aadhar.png" alt="" />
                            <input type="text" id="input_data" placeholder="Enter Your Aadhaar Number Or Phone" >
                            <i style="margin-top: 15px;color: red;display: none;" class="fa fa-exclamation"></i>
                        </div>
                        <h3 class="warning_msg">Invalid Credintial</h3><br>
                        <button class="btn btn-danger btn-block submit" type="submit" style="margin-top: 10px">Submit</button >
                    </div>
                    <div style="display: flex;flex-direction: column;" class="detail_des1">
                        <div style="display: flex;flex-direction: column;">
                            <img src="assets/image/icon.png" id="aadhar_img">
                            <h4 id="name"></h4><br>
                            <h4 id="aadhaar_no"></h4><br>
                            <h4 id="dob"></h4><br>
                            <h4 id="add"></h4><br>
                            <h4 id="contact"></h4><br>
                            <h4 id="gender"></h4><br>
                            
                            <button style="width: 130px" class="btn btn-danger btn-block aadhaar_next" type="submit">NEXT</button >
                        </div>
                    </div>
                    <div style="display: flex;flex-direction: column;" class="detail_des2">
                        <div style="display: flex;flex-direction: column;">
                            <h2>Please Fill Your Details</h2>
                            <div class="input-group input_box" style="display: flex;flex: 1;flex-direction:row">
                                <input type="text" id="username" placeholder="Enter Name" >
                            </div>
                            <div class="input-group input_box" style="display: flex;flex: 1;flex-direction:row">
                                <input type="text" id="useraddress" placeholder="Enter Address" >
                            </div>
                            <div class="input-group input_box" style="display: flex;flex: 1;flex-direction:row">
                                <input type="text" id="userdob" placeholder="Enter D.O.B" >
                            </div>
                            <div class="input-group input_box" style="display: flex;flex: 1;flex-direction:row">
                                <input type="text" id="usergender" placeholder="Enter Gender" >
                            </div>
                            <button style="width: 130px" class="btn btn-danger btn-block phone_next" type="submit">NEXT</button >
                        </div>
                    </div>
                    <div class="w3_info otp_des" style="padding: 40px">
                        <h2>Please Verify OTP</h2>
                        <div class="input-group input_box" style="display: flex;flex: 1;flex-direction:row">
                            <img style="width: 30px;height: 25px;margin-top: 10px"  src="assets/image/aadhar.png" alt="" />
                            <input type="text" id="otp" placeholder="Enter OTP" >
                            <i style="margin-top: 15px;color: red;display: none;" class="fa fa-exclamation"></i>
                        </div>  <h3 class="warning_msg">Invalid OTP</h3><br>
                        <button class="btn btn-danger btn-block verify" style="margin-top: 10px" type="submit">Verify</button >
                    </div>
                    <div class="loc_des">
                        <div class="input-group" style="display: flex;flex: 1;flex-direction:row">
                            <img style="width: 20px;height: 20px;margin-top: 10px"  src="assets/image/search.png" alt="" />
                            <input type="text" id="myInput" onkeyup="filter(this)" placeholder="Enter Location" >
                        </div>
                        <table>
                            <thead>
                                <tr>
                                    <th>PS Code</th>
                                    <th>Location</th>
                                    <th>Select</th>
                                </tr>
                            </thead>
                            <tbody id="myTable">
                            </tbody>
                        </table>
                    </div>
                    <div style="display: flex;flex-direction: column;padding: 4px;box-shadow: 1px 2px 4px rgba(0, 0, 0, .5);
                        " class="profile_des">
                        <div  style="display: flex;flex-direction: row;justify-content: space-between;background-color: #7d520e;padding: 10px;border-radius: 4px">
                            <img src="assets/image/icon.png" id="aadhar_img" style="width: 30px;height: 30px">
                            <h2 style="margin-top: 20px;margin-right: 100px;color:white" id="loggedinname"></h2>
                            <div class=" tooltip">
                                <i style="font-size:30px;color:white" onclick="Logout();" class="fa fa-sign-out"></i>
                                <span class="tooltiptext">Logout</span>
                            </div>
                        </div>
            
                        <div>
                            <table >
                                <thead>
                                    <tr>
                                        <th>FIR No</th>
                                        <th>Ask Query</th>
                                        <th>Complaint</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody id="myComp">
                                </tbody>
                                
                            </table>
                        </div>
                        <div  style="padding: 20px;display: flex;justify-content:  flex-end;" class="complaintdiv">
                            <div onclick="complaintclick()" class="tooltip" style="background-color:#7d520e;height: 40px;width: 40px;border-radius: 50%;display: flex;justify-content: center;align-items: center;box-shadow: 5px 5px 4px rgba(0, 0, 0, .5)">
                                <i class="fa fa-plus" style="color: white;font-size: 25px"></i>
                                <span class="tooltiptext">New Complaint</span>
                            </div>
                        </div>
                        
                    </div>
                    <div class="complaint_des">
                        <h2>Please Enter Following Details</h2>
                        <br>
                        <div class="input-group input_box" style="display: flex;flex: 1;flex-direction:row">
                            <input type="text" id="when" onchange="nextinput(this)" placeholder="Enter Time Of Crime" >
                            <i class=" fa fa-pencil" onclick="edit(this)" style="color: red;font-size: 25px;margin-top: 8px"></i>
                        </div>
                        <div class="input-group input_box" style="display: flex;flex: 1;flex-direction:row">
                            <input type="text" id="where" onchange="nextinput(this)" placeholder="Enter Place Of Crime" >
                            <i class=" fa fa-pencil" onclick="edit(this)" style="color: red;font-size: 25px;margin-top: 8px"></i>
                        </div>


                      <!--   <div style="display: flex;justify-content: center;align-items: center;">
                            <div style="height: 30px;width: 30px;border-radius: 50%;display: flex;justify-content: center;
                                align-items: center;background: #7d520e;margin-bottom: 12px;padding: 3px
                            "><h3 style="color: white;font-family: 'Raleway', sans-serif;font-size: 15px;">OR</h3></div>
                        </div> -->
                        
                        <div style="display: flex;flex: 1;flex-direction:row">
                            <select id="myPoliceStation"  style="width: 99%;padding:15px 15px;outline:none;border:1px solid #dddddd;font-family: 'Raleway', sans-serif;font-size: 15px;color: #333 ">
                                <option >Nearest Police Station</option>
                                
                            </select>
                        </div>
                        <div style="display: flex;align-items: flex-end;justify-content: flex-end;">
                            <button class="btn btn-danger btn-block" onclick="final_complaint()" type="submit" style="margin-top: 25px;">NEXT</button >
                        </div>
                    </div>


                    <div class="query_page_des">
                        <h2 id="query_page_msg"></h2>
                        <br>
                        <div class="input-group input_box" style="display: flex;flex: 1;flex-direction:row">
                            <input type="text" style="height: 100px" id="query_txt" placeholder="Enter Query" >
                        </div>
                        <div style="display: flex;align-items: flex-end;justify-content: flex-end;">
                            <button class="btn btn-danger btn-block" onclick="query_submit()" type="submit" style="margin-top: 25px;">NEXT</button >
                        </div>
                    </div>




                </div>
            </div>
        </div>
    
    </body>
</html>