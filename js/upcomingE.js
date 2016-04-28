$(document).ready(function() {


      $("#adminPanel").hide();

      $.ajax({// Displays all the events in the upcoming events page
                type: "POST",
                url: "data/applicationLayer.php",
                dataType: "html",
                data: {'action':'DE'},
                success: function(response)
                {
                   
                   $("#uET").append(response);
    
                },
                error: function(errorMsg)
                {
                    alert(errorMsg.statusText);
                }

            });// end of ajax



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



  
          $('#tab4').on("click", function(){// When the logout button is clicked   
          $.ajax({
              type: "POST",
              url: 'data/applicationLayer.php',
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
           });

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