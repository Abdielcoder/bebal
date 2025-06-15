  <style>
    body {
      font-family: 'ITC Avant Garde Std', Arial, Helvetica, sans-serif;
      margin: 0;
      padding: 0;
      height: 100vh;
      -webkit-font-smoothing: antialiased;
      -moz-osx-font-smoothing: grayscale;
    }

    .clock {
      width: 40%;
      display: flex;
      flex-direction: column;
      justify-content: left;
      align-items: left;
      background-color: #742c32;
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


<footer class="navbar fixed-bottom bg-primary">
<?php
//echo '<div class="container">';
//echo '<div class="d-flex justify-content-between align-items-center w-100">';
?>
        <span class="text-white small">
          <a href="http://www.tijuana.gob.mx" target="_blank" class="text-secondary text-decoration-none">
            <small>&copy; <?php echo date('Y');?> - Secretaría de Gobierno del XV Ayuntamiento de Tijuana</small>
          </a>
        </span>

        <div class="clock ms-3">
          <div class="time"></div>
          <div class="date-time"></div>
	</div>
<?php
//echo '</div>';
//echo '</div>';
?>
</footer>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <!-- Latest compiled and minified JavaScript -->
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>


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

