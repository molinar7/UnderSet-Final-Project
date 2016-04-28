$(document).ready(function() {



           $("#adminPanel").hide();

           $.ajax({// To check if the session exist and if the session user is an admin
            
              type: "POST",
              url: 'data/applicationLayer.php',
              dataType:'text',
              data: {'action':'CS'},// Check session

              success: function(response){

              if (response == 1)
                $("#adminPanel").show();
              if (response == 2)
                $("#adminPanel").hide();
              if( response == 0 )
                window.location.href='signIn.html'; 

               
              },
              error: function () {
                alert("error");
                }
              
             }); //End of ajax

          $.ajax({// Displays all the events in the select of the request page
                type: "POST",
                url: "data/applicationLayer.php",
                dataType: "html",
                data: {'action':'LS'},
                success: function(response)
                {
                    $("#event_input").html(response);
    
                },
                error: function(errorMsg)
                {
                    alert(errorMsg.statusText);
                }

            });
  
          $('#tab4').on("click", function(){// When the logout button is clicked   
          $.ajax({
              type: "POST",
              url: 'data/applicationLayer.php',
              type: 'POST',
              dataType:'text',
              data: {'action':'DS'},// delete session

              success: function(response){
                if (response == 0)
                  window.location.href='signIn.html'; 
              },
              error: function () {
                alert("error");
                }
              
             }); //End of ajax
           });// end pf clicking the logut button.


           
          $('#sumbit_request').on("click", function(){// When the submit button is clicked  
            var eventN =$('#event_input').val();
            var contactN = $ ('#number_input').val();
            var reason = $ ('#textArea').val();
            
            var dataToSend ={
              "eN" : eventN,
              "cN" : contactN,
              "uReason" : reason,
              "action" : "SR"// Submit Request
            }; 

            if(eventN=='' || contactN == '' || reason =='')
              {$("#wrongR").text("Fill all the fields");
              $("#goodR").text(" ");}
            else{
              $("#wrongR").text(" ");
              $("#goodR").text(" ");
              $ ('#number_input').val(""); 
              $ ('#textArea').val(""); 

              $.ajax({// Add new request to the database
 
              url: 'data/applicationLayer.php',
              type: 'POST',
              dataType:'html',
              contentType: 'application/x-www-form-urlencoded',
              data: dataToSend,
              
              success: function(response){
                if(response == 1)// request inserted in database sucefull
                  $("#goodR").text("Request sent,you will be notified by your contact number, Good luck!");
                if (response == 2)// request already exist on databse
                  $("#wrongR").text("The request has already been sent");
                if (response == 3)// Session does not exists
                  window.location.href='signIn.html';
              },
              error: function () {
                alert("error");
                }
             });//end of ajax
          }// end of else

            

            });// end of the action of clicking the submit button.



          $('#tab1').on("click", function(){// When the news button is clicked  
            window.location.href='news.html'; 
            });

          $('#createE').on("click", function(){// When the create event is clicked 
            window.location.href='createE.html'; 
            });

          $('#tab3').on("click", function(){// When the requests button is clicked  
            window.location.href='requests.html'; 
            });

          $('#acceptR').on("click", function(){// When the acccept requests button is clicked  
            window.location.href='acceptR.html'; 
            });

          $('#tab2').on("click", function(){// When the upcoming events button is clicked  
            window.location.href='upcomingE.html'; 
            });




  
});