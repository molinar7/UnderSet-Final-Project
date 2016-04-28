// On ready function to let the HTML load all its elements and files before loading this script! 
        $(document).on("ready", function(){


          $.ajax({
                type: "POST",
                url: "data/applicationLayer.php",
                dataType: "json",
                data: {'action':'COOKIE'},
                success: function(cookieJson)
                {
                  
                   $("#username_input").val(cookieJson.cookieValue);
                    
                },
                error: function(errorMsg)
                {
                    alert(errorMsg.statusText);
                }

            });// end of ajax of cookie service

          $('#signUPbutton').on("click", function(){// When the register button is clicked   
          window.location.href='signUp.html'; 
           });

           // Action for clicking the log in button
            $('#login_button').on("click", function(){
              
          
              var username_field=$('#username_input').val();
              var password_field=$('#password_input').val();
              var cBox = 0;

              if( $('#checkbox_input').is(":checked")) cBox=1;
              var dataToSend={
                "username" : username_field,
                "password" : password_field,
                "checkB"  : cBox,
                "action" : "LOGIN"
              };

              $.ajax({// Login ajax call

              url: 'data/applicationLayer.php',
              type: 'POST',
              dataType:'html',
              contentType: 'application/x-www-form-urlencoded',
              data: dataToSend,
              
              success: function(response){
                if(response ==1)//// La constraseña y el usuario si coincidieron con uno de la base de datos
                  window.location.href='news.html';
                
                else{// Username or password are incorrect
                  $("#mess").html("Username or password are incorrect");
                  $("#password_input").val("");
                }
              },
              error: function () {
               // alert("error");
                }

             });//end of ajax 


            });// end of action for clicking the login button
          
           
        });// end of document on ready




