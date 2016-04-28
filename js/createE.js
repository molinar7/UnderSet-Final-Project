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

          $('#creatEventB').on("click", function(){// When the creat button is clicked  
            var eventN =$('#nameEvent').val();
            var eLoc = $ ('#eventLoc').val();
            var eDate = $ ('#datepicker').val();
            
            var dataToSend ={
              "eN" : eventN,
              "eL" : eLoc,
              "eD" : eDate,
              "action" : "CE"// Create Event
            }; 

            if(eventN=='' || eLoc == '' )
              {$("#wrongR").text("Fill all the fields");
              $("#goodR").text(" ");
              }
            else{
              $("#wrongR").text("");
              $("#nameEvent").val("");
              $ ('#eventLoc').val(""); 
              $("#goodR").text(" ");
              $ ('#datepicker').val(""); 

              $.ajax({// Add new event to the database
 
              url: 'data/applicationLayer.php',
              type: 'POST',
              dataType:'html',
              contentType: 'application/x-www-form-urlencoded',
              data: dataToSend,
              
              success: function(response){
               
                if(response == 1)
                  $("#goodR").text("Event created!");
                if (response == 2)// event already exist on databse
                  $("#wrongR").text("The event already exists");

              },
              error: function () {
                alert("error");
                }
             });//end of ajax
          }// end of else

          });// End of the action of clicking the create button








  
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