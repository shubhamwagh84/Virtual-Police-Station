<script>

$(document).ready(function(){



getLocation();


})


$('.verify').click(function() {
        let otp = $('#otp').val();
            $.ajax({
                url: "otp_verify.php",
                method: "POST",
                data: { otp:otp, input_data:input_data, aadhaar_ver:aadhaar_ver, phone_ver:phone_ver, otp_ver: true},
                dataType: "text",
                beforeSend: function() {
                    queryProgress.start();
                },
                success: function(data)

                {
                  console.log(data);
                  queryProgress.end();
                  if (data[8]=='success'){
                  $('.otp_des').hide();
                    $('.detail_des').show();
                    name = data[2];
                    contact_no = data[7];
                    input_data = data[4];
                    dob = data[3];
                    document.getElementById('name').innerHTML = 'Name : ' + data[2];
                    document.getElementById('aadhaar_no').innerHTML = 'Aadhaar Number:' + data[1];
                    document.getElementById('dob').innerHTML = 'DOB : ' + data[3];
                    document.getElementById('add').innerHTML = 'Address:' + data[4];
                    document.getElementById('contact').innerHTML = 'Contact Number:' + data[7];
                  }
                  else
                  {
                    $(".fa").css("display",'inline');
                $(".warning_msg").css("display","inline");
                $(".input_box").css("border-color","red");
                return false;
                  }
                    



                }
            });
    })
	
</script>