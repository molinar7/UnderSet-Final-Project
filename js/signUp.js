// On ready function to let the HTML load all its elements and files before loading this script! 
        $(document).on("ready", function(){

          
           $("#submit_button").on("click",function(){


            var fname = $("#firstname_input").val();
            var lname = $("#lastname_input").val();
            var userN = $("#username2_input").val();
            var eMail = $("#email_input").val();
            var passw = $("#password2_input").val();
            var passw2 = $("#passwordC_input").val();

            if($('#gender_masculine').is(':checked')) 
               var genders =$("#gender_masculine").val();
             else
              var genders =$("#gender_femenine").val();

            var countrys = $ ("#country_input").val();


            if(fname=='' || lname == '' || userN ==''  || eMail==''|| passw == '' || passw != passw2)
            $("#mess2").html("Be careful when you type, please type again");
            else{
            

            var dataToSend ={
              "firstname" : fname,
              "lastname" : lname,
              "username" : userN,
              "email" : eMail,
              "password" : passw,
              "gender" : genders,
              "country" : countrys,
              "action" : "REG"
            }; 

          
             $.ajax({// Add new users to database
 
              url: 'data/applicationLayer.php',
              type: 'POST',
              dataType:'html',
              contentType: 'application/x-www-form-urlencoded',
              data: dataToSend,
              
              success: function(response){
                if(response ==1)// No existia el usuario anteriormente
                window.location.href='signUp.html';
                else{// El usuario ya existia en la base de datos
                $("#mess2").html("That user already exists");
                $("#username2_input").val("");
                $("#password2_input").val("");
                $("#passwordC_input").val("");
                }
              },
              error: function () {
                alert("error");
                }
             });//end of ajax  
            }// end of else
            });// end of the action of clicking the submit button
            
           
        });// end of document on ready




