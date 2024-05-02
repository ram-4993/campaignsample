<?php
ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
error_reporting(E_ERROR | E_PARSE);
$host = "localhost";
$dbname = "campaign";
$username = "root";
$password = "root";
$conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

if($_GET['campaign_id']){
    $campaign_id = $_GET['campaign_id'];
}
else{
    $campaign_id = 1;
}

$sql    = "SELECT name,phone_no,emailid,date,time,proffesion,utm,CONCAT(date,' ',time) AS datettime FROM registers WHERE course_id=$campaign_id ORDER BY id DESC";

$stmt   = $conn->prepare($sql);
$result = $stmt->execute();

?>

<!DOCTYPE html>
<html lang="en" >
<head>
  <meta charset="UTF-8">
  <title>Registration Datas</title>
  <link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css'>
<link rel='stylesheet' href='https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css'>
<link rel='stylesheet' href='https://cdn.datatables.net/buttons/1.2.2/css/buttons.bootstrap.min.css'><link rel="stylesheet" href="./style.css">
<style>
	header{
		margin-bottom:20px;
		text-align:center;
	}
	.sidenav {
		height: 100%; /* Full-height: remove this if you want "auto" height */
		width: 160px; /* Set the width of the sidebar */
		position: fixed; /* Fixed Sidebar (stay in place on scroll) */
		z-index: 1; /* Stay on top */
		top: 0; /* Stay at the top */
		left: 0;
		background-color: #2c1d82; /* Black */
		overflow-x: hidden; /* Disable horizontal scroll */
		padding-top: 100px;
	}

	/* The navigation menu links */
	.sidenav a {
		padding: 6px 8px 6px 16px;
		text-decoration: none;
		font-size: 25px;
		color: #818181;
		display: block;
	}
	.sidenav a.active{
		color: rgba(255, 228, 85, 0.89);
	}
	/* When you mouse over the navigation links, change their color */
	.sidenav a:hover {
		color: #f1f1f1;
	}

	/* Style page content */
	.main {
	margin-left: 160px; /* Same as the width of the sidebar */
	padding: 0px 10px;
	}
</style>
</head>
<body>
    <?php
        $sqlsidebar     = "SELECT id,date,title,campaign_id FROM camapigns WHERE 1 ORDER BY id DESC";
        $stmtsidebar    = $conn->prepare($sqlsidebar );
        $resultsidebar  = $stmtsidebar ->execute();
        $liarr = array();
        while($datasidebar = $stmtsidebar->fetch(PDO::FETCH_ASSOC)){
            if($datasidebar['campaign_id'] == $campaign_id){
                $heading = $datasidebar['date'].' - '.$datasidebar['title'];
                $liarr[] = "<a href='#' class='active'>".$datasidebar['date']."</a>";
            }
            else{
                $liarr[] = "<a href='index?campaign_id=".$datasidebar['campaign_id']."'>".$datasidebar['date']."</a>";
            }
        }
    ?>
<header>
	<img src="../images/workshop/pickmyskillnew.png">
	<h1><?php echo $heading ?></h1>
</header>
<div class="sidenav">
        <?php
        foreach ($liarr as $value){
            echo $value;
        }
        ?>
    </div>
<div class="main">
	<table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
		<thead>
			<tr>
				<th>Name</th>
				<th>Phone no</th>
				<th>Email</th>
				<th>proffession</th>
				<th>Registered time(IST)</th>
				<th>UTM</th>
			</tr>
		</thead>
		<tbody>
			<?php
				while($data = $stmt->fetch(PDO::FETCH_ASSOC)){
					$datetime = $data['datettime'];
					$newDate = date('Y-m-d H:i:s', strtotime($datetime. ' + 330 minutes'));
					echo "<tr>";
					echo "<td>".$data['name']."</td>";
					echo "<td>".$data['phone_no']."</td>";
					echo "<td>".$data['emailid']."</td>";
					echo "<td>".$data['proffesion']."</td>";
					// echo "<td>".$data['date']." ".$data['time']."</td>";
					echo "<td>".$newDate."</td>";
					echo "<td>".$data['utm']."</td>";
					echo "</tr>";
				}
			?>
		</tbody>
	</table>
</div>
<!-- partial -->
  <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.0/jquery.min.js'></script>
<script src='https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js'></script>
<script src='https://cdn.datatables.net/buttons/1.2.2/js/dataTables.buttons.min.js'></script>
<script src='https://cdn.datatables.net/buttons/1.2.2/js/buttons.colVis.min.js'></script>
<script src='https://cdn.datatables.net/buttons/1.2.2/js/buttons.html5.min.js'></script>
<script src='https://cdn.datatables.net/buttons/1.2.2/js/buttons.print.min.js'></script>
<script src='https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js'></script>
<script src='https://cdn.datatables.net/buttons/1.2.2/js/buttons.bootstrap.min.js'></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js'></script>
<script src='https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/vfs_fonts.js'></script>
<script src='https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/pdfmake.min.js'></script><script  src="./script.js"></script>

</body>
</html>
