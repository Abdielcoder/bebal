
  <style>
    body {
      font-family: sans-serif;
      margin: 0;
      padding: 0;
      height: 100vh;
    }

    .clock {
      width: 40%;
      display: flex;
      flex-direction: column;
      justify-content: left;
      align-items: left;
      background-color: #661C32;
    }

    .time {
      font-size: 9px;
      font-weight: bold;
      color: #fff;
    }

    .date-time {
      font-size: 8px;
      color: #fff;
    }

    @media screen and (max-width: 768px) {
      .time {
        font-size: 50px;
      }
    }
  </style>


<div class="navbar navbar-default navbar-fixed-bottom" >
    <div class="container">
      <p class="navbar-text pull-left">
	   <a href="http://mexcapproject.com/" target="_blank" style="color: #ecf0f1"> <font size="1">&copy <?php echo date('Y');?> - MEXCAP PROJECT PARTNERS SAPI</font></a>


  <div class="clock">
    <div class="time"></div>
    <div class="date-time"></div>
  </div>

</p>
</div>
</div>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <!-- Latest compiled and minified JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>


<script>
    var time = document.querySelector(".time");
    var dateTime = document.querySelector(".date-time");

    function updateClock() {
      // Get the current time, day , month and year
      var now = new Date();
      var hours = now.getHours();
      var minutes = now.getMinutes();
      var seconds = now.getSeconds();
      var day = now.getDay();
      var date = now.getDate();
      var month = now.getMonth();
      var year = now.getFullYear();

      // store day and month name in an array
      var dayNames = ["Domingo", "Lunes", "Martes", "Miercoles", "Jueves", "Viernes", "Sabado"];
      var monthNames = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Deciembre"];

      // format date and time
      hours = hours % 12 || 12;
      minutes = minutes < 10 ? "0" + minutes : minutes;
      seconds = seconds < 10 ? "0" + seconds : seconds;
      date = date < 10 ? "0" + date : date;

      // display date and time
      var period = hours < 12 ? "PM" : "AM";
      time.innerHTML = hours + ":" + minutes + ":" + seconds + " " + period;
      dateTime.innerHTML = dayNames[day] + ", " + monthNames[month] + " " + date + ", " + year;
    }

    updateClock();
    setInterval(updateClock, 1000);
</script>

