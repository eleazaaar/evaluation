$(document).ready(function(){
    $(".student-form").hide();
    $(".student").css("background","none");
    
    $(".student").click(function()
    {
        $(".login-form").hide();
        $(".student-form").show();
        $(".login").css("background","none");
        $(".student").css("background","#fff");  
    });

   $(".login").click(function()
    {
        $(".student-form").hide();
        $(".login-form").show();
        $(".login").css("background","#fff");
        $(".student").css("background","none");
   });

  $(".n2").click(function(){
    $(".n1").val("");
  });
});