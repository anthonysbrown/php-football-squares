<?php
include 'classes/football_squares.class.php';
$squares = new football_squares;
$squares->password = 'password';
$squares->team_one = 'Seahawks';
$squares->team_two = 'Broncos';
$squares->price = '2.50';
$squares->currency_symbol = '$';
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Football Squares</title>
<script src="http://code.jquery.com/jquery-1.10.1.min.js"></script>
<script src="http://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
<script src="js/scripts.js"></script>
<link rel='stylesheet' href='http://code.jquery.com/ui/1.10.4/themes/redmond/jquery-ui.css' type='text/css' media='all' />
<link rel='stylesheet' href='css/style.css' type='text/css' media='all' />
</head>

<body>
<div id="wrapper">
<?php echo $squares->build(); ?>
<div class="noPrint">
<h2>Rules</h2>
<ul>
  <li>Fee: 2 squares for <?php echo $squares->currency_symbol; ?>5</li>
  <li>Payout TBD (Thinking 100 1st half 150 2nd?) Suggestions</li>
    <li>Numbers picked randomly on superbowl sunday before kickoff</li>
</ul>
</div>
</div>

</body>
</html>
