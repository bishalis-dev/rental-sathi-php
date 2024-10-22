<?php
session_start();
error_reporting(0);
include('includes/config.php');
if (strlen($_SESSION['alogin']) == 0) {
	header('location:index.php');
} else {

	if (isset($_REQUEST['del'])) {
		$delid = intval($_GET['del']);
		$msg = "Data Deleted Successfully!";
		// $query = $dbh->prepare($sql);
		// $query->bindParam(':delid', $delid, PDO::PARAM_STR);
		// $query->execute();
		// $msg = "Vehicle  record deleted successfully";
	}
	if(isset($_GET['release']) && $_GET['release'] >= 1){
		$vid = $_GET['release']; 
		$sql = "UPDATE vehicles set isBooked = 0 where id = '$vid'";
		$query = $dbh->prepare($sql);
		$query->execute();
		$msg = "Vehicle Marked as Available";

	}

?>

	<!doctype html>
	<html lang="en" class="no-js">

	<head>
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
		<meta name="description" content="">
		<meta name="author" content="">
		<meta name="theme-color" content="#3e454c">

		<title>Car Rental Portal |Admin Manage Vehicles </title>

		<!-- Font awesome -->
		<link rel="stylesheet" href="css/font-awesome.min.css">
		<!-- Sandstone Bootstrap CSS -->
		<link rel="stylesheet" href="css/bootstrap.min.css">
		<!-- Bootstrap Datatables -->
		<link rel="stylesheet" href="css/dataTables.bootstrap.min.css">
		<!-- Bootstrap social button library -->
		<link rel="stylesheet" href="css/bootstrap-social.css">
		<!-- Bootstrap select -->
		<link rel="stylesheet" href="css/bootstrap-select.css">
		<!-- Bootstrap file input -->
		<link rel="stylesheet" href="css/fileinput.min.css">
		<!-- Awesome Bootstrap checkbox -->
		<link rel="stylesheet" href="css/awesome-bootstrap-checkbox.css">
		<!-- Admin Stye -->
		<link rel="stylesheet" href="css/style.css">
		<style>
			.errorWrap {
				padding: 10px;
				margin: 0 0 20px 0;
				background: #fff;
				border-left: 4px solid #dd3d36;
				-webkit-box-shadow: 0 1px 1px 0 rgba(0, 0, 0, .1);
				box-shadow: 0 1px 1px 0 rgba(0, 0, 0, .1);
			}

			.succWrap {
				padding: 10px;
				margin: 0 0 20px 0;
				background: #fff;
				border-left: 4px solid #5cb85c;
				-webkit-box-shadow: 0 1px 1px 0 rgba(0, 0, 0, .1);
				box-shadow: 0 1px 1px 0 rgba(0, 0, 0, .1);
			}
		</style>

	</head>

	<body>
		<?php include('includes/header.php'); ?>

		<div class="ts-main-content">
			<?php include('includes/leftbar.php'); ?>
			<div class="content-wrapper">
				<div class="container-fluid">

					<div class="row">
						<div class="col-md-12">

							<h2 class="page-title">Manage Vehicles</h2>

							<!-- Zero Configuration Table -->
							<div class="panel panel-default">
								<div class="panel-heading">Vehicle Details</div>
								<div class="panel-body">
									<?php if ($error) { ?><div class="errorWrap"><strong>ERROR</strong>:<?php echo htmlentities($error); ?> </div><?php } else if ($msg) { ?><div class="succWrap"><strong>SUCCESS</strong>:<?php echo htmlentities($msg); ?> </div><?php } ?>
									<table id="zctb" class="display table table-striped table-bordered table-hover" cellspacing="0" width="100%">
										<thead>
											<tr>
												<th>#</th>
												<th>Vehicle Title</th>
												<th>Brand </th>
												<th>Price Per day</th>
												<th>Fuel Type</th>
												<th>Model Year</th>
												<th>Status</th>
												<th>Action</th>
											</tr>
										</thead>
										<tfoot>
											<tr>
												<th>#</th>
												<th>Vehicle Title</th>
												<th>Brand </th>
												<th>Price Per day</th>
												<th>Fuel Type</th>
												<th>Model Year</th>
												<th>Status</th>
												<th>Action</th>
											</tr>
											</tr>
										</tfoot>
										<tbody>

											<?php $sql = "SELECT vehicles.vehicles_title, brands.name, vehicles.price_per_day, vehicles.id as vid, vehicles.isBooked, vehicles.fuel_type, vehicles.model_year, vehicles.id from vehicles join brands on brands.id = vehicles.vehicles_brand";
											$query = $dbh->prepare($sql);
											$query->execute();
											$results = $query->fetchAll(PDO::FETCH_OBJ);
											$cnt = 1;
											if ($query->rowCount() > 0) {
												
												foreach ($results as $result) {	
														?>
													<tr>
														<td><?php echo htmlentities($cnt); ?></td>
														<td><?php echo htmlentities($result->vehicles_title); ?></td>
														<td><?php echo htmlentities($result->name); ?></td>
														<td><?php echo htmlentities($result->price_per_day); ?></td>
														<td><?php echo htmlentities($result->fuel_type); ?></td>
														<td><?php echo htmlentities($result->model_year); ?></td>
														<td>
															<?php 
															if($result->isBooked == 1){
																?>
																Booked! <a href="manage-vehicles.php?release=<?php echo $result->vid ?>">Make Avilable </a>
																<?php
															}else{
																echo "<span class='text-success'>Available</span>";
															}
															?>
														</td>
														<td><a href="edit-vehicle.php?id=<?php echo $result->vid; ?>"><i class="fa fa-edit"></i></a>&nbsp;&nbsp;
															<a href="manage-vehicles.php?del=<?php echo $result->vid; ?>" onclick="return confirm('Do you want to delete');"><i class="fa fa-close"></i></a>
														</td>
													</tr>
											<?php $cnt = $cnt + 1;
												}
											} ?>

										</tbody>
									</table>



								</div>
							</div>



						</div>
					</div>

				</div>
			</div>
		</div>

		<!-- Loading Scripts -->
		<script src="js/jquery.min.js"></script>
		<script src="js/bootstrap-select.min.js"></script>
		<script src="js/bootstrap.min.js"></script>
		<script src="js/jquery.dataTables.min.js"></script>
		<script src="js/dataTables.bootstrap.min.js"></script>
		<script src="js/Chart.min.js"></script>
		<script src="js/fileinput.js"></script>
		<script src="js/chartData.js"></script>
		<script src="js/main.js"></script>
	</body>

	</html>
<?php } ?>