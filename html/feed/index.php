<?php
  include("../assets/includes/config.php");
  if (!isLoggedIn()) {
    header('Location: http://yeetr.me/');
    die();
  }
  $user = getUserBySID();
?>
<html>
  <head>
    <title>Feed - <?php echo $conf_name; ?></title>
    <link type="text/css" rel="stylesheet" href="../assets/css/master.css<?php if ($conf_refresh) { echo "?t=".strval(time()); } ?>">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  </head>
  <body>
    <marquee>Welcome to YEeTr; (Y)esterday's (E)l(e)ctronic (T)witte(r)</marquee>
    <a href="http://yeetr.me/feed"><img src="/assets/img/logo.gif" alt="YEET"></a><!-- Source: cooltext -->
    <div class="rfloat">
      Search:
      <br>
      <input id="search" type="text" placeholder="Search users" size=100>
      <button onclick="notsearch()"> Search! </button>
    </div>
    <center>
      <a href="http://yeetr.me/yeet/"><button> New Yeet :) </button></a>
      <a href="http://yeetr.me/u/"+ <?php echo $user['id'] ?>><button style="float:right;"> Profile </button></a>
    </center>
    <br>
    <script>
      function notsearch() {
        window.location = "http://yeetr.me/search/" + encodeURI($('#search').val());
      }
      $(function() {
        loadYeets();
      });
      setInterval(function() {
        loadYeets();
	    }, 2000);
      function loadYeets() {
        $.ajax({
          type: "GET",
          url: "../endpoints/feed.php",
          data: "",
          success: function(data) {
            var obj = JSON.parse(data);
            if (obj.status == 1) {
              $("#yeets tr").remove();
              $.each(obj.content, function(index, value) {
                var yeetHtml = "<tr><td width=\"96px\">";
                yeetHtml += "<a href=\"http://yeetr.me/u/"+ value.user.id +"\"><img style=\"vertical-align:top\" src=\"" + value.user.pic + "\"></a></td>";
                yeetHtml += "<td width=\"20%\"><a href=\"http://yeetr.me/u/"+ value.user.id +"\"><b class=\"name\">" + value.user.name + "</b></a><br>";
                yeetHtml += "<label class=\"handle\">" + value.user.id + "</label><br>";
                yeetHtml += "<label class=\"time\">Posted " + value.time + " seconds ago</label></td><td>";
                yeetHtml += "<label class=\"yeet\">" + value.body + "</label></td></tr>";
                $("#yeets").append(yeetHtml);
              });
            }
          }
        });
      }
    </script>
    <table border="1px" width="100%" id="yeets">
    </table>
  </body>
</html>
