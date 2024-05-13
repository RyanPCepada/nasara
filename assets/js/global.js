$(document).ready(function () {
   to_landing();
   // to_login();
});

function to_landing() {
   $.post("landing_main.php", {},function (data) {
         $("#contents").html(data);  
       });
   }   

// function to_login() {
// $.post("pages/login/login_main.php", {},function (data) {
//       $("#contents").html(data);  
//     });
// }   
