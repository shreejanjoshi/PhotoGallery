  </div>
    <!-- /#wrapper -->

    <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

     <!-- needed for summernote textedditor -->
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
    <script src="js/scripts.js"></script>

  <!-- google chart api -->
  <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {

          var data = google.visualization.arrayToDataTable([
              ['Task', 'Hours per Day'],
              ['Views',     <?php echo $session->count; ?>],
              ['Comments',      <?php echo Comment::count_all(); ?>],
              ['Users',  <?php echo User::count_all(); ?>],
              ['Photos', <?php echo Photo::count_all(); ?>],
          ]);

          var options = {

              //look this in google chart
              legend:'none',
              pieSliceText:'label',
              title: 'My Daily Activities',
              backgroundColor:'transparent'

          };

          var chart = new google.visualization.PieChart(document.getElementById('piechart'));

          chart.draw(data, options);
      }
  </script>

</body>

</html>
