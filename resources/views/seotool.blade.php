<!DOCTYPE html>
<html lang="en">
<head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
</head>
<body class="container m-5">
   
       

           
                <label for="exampleInputEmail1">Enter Your URL</label>
                <input type="text" class="form-control mb-2" name='url' id="url" placeholder="Enter Your URL">
                <input class="btn btn-primary" id="submit" type="submit">

<table id="myTable">
    <thead>
        <tr>
            <th>
                External
            </th>
        </tr>
    </thead>
    <tbody id="user_jobs">
        
      

        <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script>

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
$(document).ready( function () {
    $('#myTable').DataTable();
} );

$( document ).ready(function() {
    $("#submit").on('click',function(){
       var url=$('#url').val();
    //    console.log(url);
      $.ajax({

        url:"{{ route('dashboard') }}",
        method:'POST',
        data:{
            url:url
        }
        
      }).success(function(response){
        if(data.success == true) {
              //user_jobs div defined on page
              $('#user_jobs').append(data.html);
            } else{
                alert("hello");
            }
      
      })
    })
});

</script>
</body>
</html>