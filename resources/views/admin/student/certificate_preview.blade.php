<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print Invoice</title>
    <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.3.0/css/all.css">
    <style>

    @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap');

    @font-face {
        font-family: treFont;
        src: url('{{ asset('fonts/trebuc.ttf') }}');
    }

    @font-face {
      font-family: 'time_new_roman';
      src: url('{{ asset('fonts/times_new_reman_bold.ttf')}}')';
    }

    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-size: 16px;
        font-family: 'treFont';
    }


    .wrapper {
      width: 100vw;
      height: 100vh; 
      position:relative;
    }

    #backdrop {
      opacity:0.1;
      position:absolute;
      top:20%;
    }

    #backdrop img {
      width: 100%;
      /* transform: rotate(-35deg); */
    }

    nav {
      display: flex;
      justify-content: space-between;
      padding: 0.25rem 1rem;
      align-items: center;
      margin-bottom:1rem;
    }

    .logo {
      width: 80px;
    }

    .info {
      display: flex;
      padding: 0.25rem 1rem;
      justify-content: space-between;
    }

    #infoTable {
      width: 20rem;
    }

    #infoTable tr td{
      padding: 0.5rem 0;
    }

    #table {
      border-collapse: collapse;
      width: 100%;
    }

    #table td,th {
      padding: 0.5rem;
        border:1px solid rgba(0,0,0,0.3);
        border: 1px solid #808B96;
    }

    #title {
      font-weight:bold;
      font-size:1.5rem;
      letter-spacing:2px;
      display:flex;
      justify-content:flex-end;
    }

    small, small > i {
      font-size:8px;
    }

    #date {
       padding: 0.5rem 1rem;
      display:flex;
      justify-content:flex-end;
    }
   
    @page {
        size: A4;
        margin-left: 0px;
        margin-right: 0px;
        margin-top: 0px;
        margin-bottom: 0px;
        margin: 0;
        -webkit-print-color-adjust: exact;
    }

    .square-border {
      width: 96px; /* Adjust the width and height as needed */
      height: 96px;
      border: 1px solid black; /* Specify the border width, style, and color */
    }
    </style>
</head>

<body>

    <div class="wrapper">
      <div style="height: 15%;">

      </div>
      <div style="height:15%">
        <p style="text-align:center;font-size: 36px;font-family: time_new_roman !important;font-weight: bold;">Computer Training Certificate</p>
      </div>

      <p style="text-align:center;font-size: 42px;">{{$student->name}}</p>
      <p style="text-align:center;font-size: 20px;margin-top: 12px;">has been successfully completed the following course:</p>
      <div style="height:3%"></div>
      @foreach($certificate_majors as $key=>$major)
        <p style="text-align:center;font-size: 20px;margin-bottom: 7px;">{{$major->name}}</p>
      @endforeach

      <div style="position:absolute;left: 100px;bottom: 160px;">
         @if($print_option == 1)

        @if($student->photo != null)
            <img src="{{ asset('uploads/student_photo/' . $student->photo) }}" style="width:70px;height:70px;" class="img-fluid">
        @else
            <img src="{{ asset('uploads/no_photo.jpeg') }}" style="width:70px;height:70px;" class="img-fluid">
        @endif

        @endif
      </div>
      <div style="position: absolute;left: 144px;bottom: 190px;">
        <div class="square-border"></div>
      </div>

      <div style="position: absolute;left: 144px;bottom: 124px;">
        <!-- <p>{{$student->studentID}}/NPT</p>
        <p>{{date('d F Y',strtotime($date))}}</p> -->

       
        <img src="{{ asset('uploads/qr_code/qr_' . $student->studentID.'.png') }}" style="width:45px;height:45px;" class="img-fluid">
      </div>
    </div>
   
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.3/jquery.min.js"
        integrity="sha512-STof4xm1wgkfm7heWqFJVn58Hm3EtS31XFaagaa8VMReCXAkQnJZ+jEy8PCC/iT18dFy95WcExNHFTqLyp72eQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>


    	window.print();

        
    </script>
</body>

</html>