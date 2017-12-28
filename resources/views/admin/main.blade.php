<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        
        <title>Laravel</title>

        <!-- Fonts -->
        <!--<link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">-->
        <!--<link href='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css' rel='stylesheet'>-->
        <!-- Styles -->
       <!-- <link href='https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css' rel='stylesheet'>-->$_FILES
        <link href="/novone/public/assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <link href="/novone/public/assets/css/admin-sidebar.css" rel="stylesheet">
        <style>

        .nopadding{
            margin:0 auto;
            padding-left: 0 !important;
    padding-right: 0 !important;
        }
    body {
    padding-top: 120px;
    padding-bottom: 40px;
    background-color: #eee;
  
  }
  .btn 
  {
   outline:0;
   border:none;
   border-top:none;
   border-bottom:none;
   border-left:none;
   border-right:none;
   box-shadow:inset 2px -3px rgba(0,0,0,0.15);
  }
  .btn:focus
  {
   outline:0;
   -webkit-outline:0;
   -moz-outline:0;
  }
  .fullscreen_bg {
    position: fixed;
    top: 0;
    right: 0;
    bottom: 0;
    left: 0;
    background-size: cover;
    background-position: 50% 50%;
    background-image: url('http://cleancanvas.herokuapp.com/img/backgrounds/color-splash.jpg');
    background-repeat:repeat;
  }
  .form-signin {
    max-width: 280px;
    padding: 15px;
    margin: 0 auto;
      margin-top:50px;
  }
  .form-signin .form-signin-heading, .form-signin {
    margin-bottom: 10px;
  }
  .form-signin .form-control {
    position: relative;
    font-size: 16px;
    height: auto;
    padding: 10px;
    -webkit-box-sizing: border-box;
    -moz-box-sizing: border-box;
    box-sizing: border-box;
  }
  .form-signin .form-control:focus {
    z-index: 2;
  }
  .form-signin input[type="text"] {
    margin-bottom: -1px;
    border-bottom-left-radius: 0;
    border-bottom-right-radius: 0;
    border-top-style: solid;
    border-right-style: solid;
    border-bottom-style: none;
    border-left-style: solid;
    border-color: #000;
  }
  .form-signin input[type="password"] {
    margin-bottom: 10px;
    border-top-left-radius: 0;
    border-top-right-radius: 0;
    border-top-style: none;
    border-right-style: solid;
    border-bottom-style: solid;
    border-left-style: solid;
    border-color: rgb(0,0,0);
    border-top:1px solid rgba(0,0,0,0.08);
  }
  .form-signin-heading {
    color: #fff;
    text-align: center;
    text-shadow: 0 2px 2px rgba(0,0,0,0.5);
  }

  #radioBtn .notActive{
    color: #3276b1;
    background-color: #fff;
}

.field-edit{
    display:none;
}
        </style>
    </head>
    <body>
        <!--
        <div class="flex-center position-ref full-height">
            @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        <a href="{{ url('/home') }}">Home</a>
                    @else
                        <a href="{{ route('login') }}">Login</a>
                        <a href="{{ route('register') }}">Register</a>
                    @endauth
                </div>
            @endif
            -->

           
        <nav id="header" class="navbar navbar-inverse navbar-fixed-top">
            <div id="header-container" class="container navbar-container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a id="brand" class="navbar-brand" href="#">Novone</a>
                </div>
                <div id="navbar" class="collapse navbar-collapse">
                </div>
            </div>
        </nav>
		<script src="/novone/public/js/app.js"></script>


<script>

$('.edit-user').on('click',function(e){
    var currentId = $(this).data("id");
    $('#editLastname').val($(this).data('lastname'));
    $('#editFirstname').val($(this).data('firstname'));
    $('#editMiddlename').val($(this).data('middlename'));
    $('#editEmail').val($(this).data('email'));
    $('#currentEmail').val($(this).data('email'));
    $('#editAccountType').val($(this).data('accounttype'));
});

$('.edit-product').on('click',function(e){
    var currentId = $(this).data("id");
    $('#editProductCode').val($(this).data('productcode'));
    $('#editProductName').val($(this).data('productname'));
    $('#productCategory').val($(this).data('producttype'));
    $('#editProductImage').attr('src','/novone/storage/app/'+$(this).data('image'));
    $('#hiddenProductId').val(currentId);

});

$('.btn-edit-critical').on('click',function(e){
    var currentId = $(this).data('productcode');
    $('.editCriticalLevel').val($(this).data('critical'));
    $('.hiddenProductCode').val(currentId);
    $('.productCodeLabel').text(currentId);
    $('.productNameLabel').text($(this).data('productname'));

});

$('.btn-edit-quantity').on('click',function(e){
    var currentProductCode = $(this).data('productcode');
    $('.hiddenProductCode').val(currentProductCode);
    $('.productCodeLabel').text(currentProductCode);
    $('.productNameLabel').text($(this).data('productname'));

});



$('#productImage').on('change',function(){
    readURL(this);
});

function readURL(input) {

  if (input.files && input.files[0]) {
    var reader = new FileReader();

    reader.onload = function(e) {
      $('#editProductImage').attr('src', e.target.result);
    }

    reader.readAsDataURL(input.files[0]);
  }
}

$('#product_unit').attr("disabled", "disabled");

$('#product_measurement').on('change',function(){

    var currentVal = $(this).val();
    if(currentVal == 'None'){
        $('#product_unit').val('');
        $('#product_unit').attr("disabled", "disabled");
    }
    else{

        $('#product_unit').removeAttr('disabled');
    }
})

$('.edit-product-category').on('click',function (){
    var currentId = $(this).data('id');
    $('#editCategoryId').val(currentId);
    $('#editCategoryName').val($(this).data('categoryname'));
});


$('.btn-client-information').on('click',function() {
    var actionURL = '/novone/public/client/approve/';
    if($(this).data('clientstatus') == 1){
        actionURL += 2;
        $('#clientStatusSubmit').text('Deactivate Account');
    }
    else if($(this).data('clientstatus') == 2){
        actionURL += 1;
        $('#clientStatusSubmit').text('Activate Account');
    }
    else if($(this).data('clientstatus') == 0){
        actionURL += 1;
        $('#clientStatusSubmit').text('Activate Account');
    }
    var approveAccountURL = $('#approveAccountURL').attr('action',actionURL);

    var currentId = $(this).data('id');
    var fullName = $(this).data('firstname') +' '+ $(this).data('middlename') +' '+  $(this).data('lastname');
    $('#hiddenClientId').val(currentId);
    $('#clientEmail').text($(this).data('email'));
    $('#clientFullName').text(fullName);
    $('#clientGender').text($(this).data('gender'));
    $('#clientBirthdate').text($(this).data('birthdate'));
    $('#clientBusinessName').text($(this).data('businessname'));
    $('#clientBusinessAddress').text($(this).data('businessaddress'));
    $('#clientBusinessContact').text($(this).data('businesscontact'));
});
</script>
    </body>
</html>
