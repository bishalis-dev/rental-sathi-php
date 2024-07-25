<?php
session_start();
error_reporting(0);
include('includes/config.php');

if (strlen($_SESSION['alogin']) == 0) {
	header('location:index.php');
} else {
	// Handle booking cancellation
	if (isset($_REQUEST['eid'])) {
		$eid = intval($_GET['eid']);
		$status = "2";
		$sql = "UPDATE bookings SET Status=:status WHERE id=:eid";
		$query = $dbh->prepare($sql);
		$query->bindParam(':status', $status, PDO::PARAM_STR);
		$query->bindParam(':eid', $eid, PDO::PARAM_STR);
		$query->execute();
		$msg = "Booking Successfully Cancelled";
	}

	// Handle booking confirmation
	if (isset($_REQUEST['aeid'])) {
		$aeid = intval($_GET['aeid']);
		$status = 1;
		$sql = "UPDATE bookings SET Status=:status WHERE id=:aeid";
		$query = $dbh->prepare($sql);
		$query->bindParam(':status', $status, PDO::PARAM_STR);
		$query->bindParam(':aeid', $aeid, PDO::PARAM_STR);
		$query->execute();
		$msg = "Booking Successfully Confirmed";
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
		<title>Car Rental Portal | Admin Manage Bookings</title>
		<link rel="stylesheet" href="css/font-awesome.min.css">
		<link rel="stylesheet" href="css/bootstrap.min.css">
		<link rel="stylesheet" href="css/dataTables.bootstrap.min.css">
		<link rel="stylesheet" href="css/bootstrap-social.css">
		<link rel="stylesheet" href="css/bootstrap-select.css">
		<link rel="stylesheet" href="css/fileinput.min.css">
		<link rel="stylesheet" href="css/awesome-bootstrap-checkbox.css">
		<link rel="stylesheet" href="css/style.css">
		<style>
			.errorWrap {
				padding: 10px;
				margin: 0 0 20px 0;
				background: #fff;
				border-left: 4px solid #dd3d36;
				box-shadow: 0 1px 1px 0 rgba(0, 0, 0, .1);
			}

			.succWrap {
				padding: 10px;
				margin: 0 0 20px 0;
				background: #fff;
				border-left: 4px solid #5cb85c;
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
							<h2 class="page-title">Manage Bookings</h2>
							<div class="panel panel-default">
								<div class="panel-heading">Bookings Info</div>
								<div class="panel-body">
									<?php if ($error) { ?><div class="errorWrap"><strong>ERROR</strong>:<?php echo htmlentities($error); ?> </div><?php } else if ($msg) { ?><div class="succWrap"><strong>SUCCESS</strong>:<?php echo htmlentities($msg); ?> </div><?php } ?>
									<table id="zctb" class="display table table-striped table-bordered table-hover" cellspacing="0" width="100%">
										<thead>
											<tr>
												<th>#</th>
												<th>Name</th>
												<th>Vehicle</th>
												<th>From Date</th>
												<th>To Date</th>
												<th>Message</th>
												<th>Status</th>
												<th>Posting date</th>
												<th>Action</th>
											</tr>
										</thead>
										<tfoot>
											<tr>
												<th>#</th>
												<th>Name</th>
												<th>Vehicle</th>
												<th>From Date</th>
												<th>To Date</th>
												<th>Price</th>
												<th>Message</th>
												<th>Status</th>
												<th>Posting date</th>
												<th>Action</th>
											</tr>
										</tfoot>
										<tbody>
											<?php
											$sql = "SELECT users.full_name, brands.name as brandname, vehicles.vehicles_title, vehicles.price_per_day, bookings.start_date, bookings.end_date, bookings.message, bookings.vehicle_id as vid, bookings.status, bookings.created_at, bookings.id from bookings join vehicles on vehicles.id=bookings.vehicle_id join users on users.email_id=bookings.user_email join brands on vehicles.vehicles_brand=brands.id order by id DESC";
											$query = $dbh->prepare($sql);
											$query->execute();
											$results = $query->fetchAll(PDO::FETCH_OBJ);
											$cnt = 1;
											if ($query->rowCount() > 0) {
												foreach ($results as $result) {
													$startDate = new DateTime($result->start_date);
													$endDate = new DateTime($result->end_date);
													$interval = $startDate->diff($endDate);
													$totalDays = $interval->days + ($interval->h / 24) + ($interval->i / 1440) + ($interval->s / 86400);
													$totalDays = number_format($totalDays, 2);
													$totalPrice = $result->price_per_day * $totalDays;
											?>
													<tr>
														<td><?php echo htmlentities($cnt); ?></td>
														<td><?php echo htmlentities($result->full_name); ?></td>
														<td><a href="edit-vehicle.php?id=<?php echo htmlentities($result->vid); ?>"><?php echo htmlentities($result->brandname); ?>, <?php echo htmlentities($result->vehicles_title); ?></a></td>
														<td><?php echo htmlentities($result->start_date); ?></td>
														<td><?php echo htmlentities($result->end_date); ?></td>
														<td><?php echo $totalPrice ?></td>
														<td><?php echo htmlentities($result->message); ?></td>
														<td><?php echo ($result->status == 1) ? 'Confirmed' : 'Not Confirmed'; ?></td>
														<td><?php echo htmlentities($result->created_at); ?></td>
														<td>
															<?php
															if ($result->status == 1) {
															?>
																<a onclick="return alert('Already Confirmed!')" style="color: green">Already Confirm</a>
															<?php } else if ($result->status == 2) {
															?>
																<span class="text-danger"> Cancelled </span>
															<?php
															} else { ?>
																<a href="manage-bookings.php?aeid=<?php echo htmlentities($result->id); ?>" onclick="return confirm('Do you really want to Confirm this booking')"> Confirm</a> /
																<a href="manage-bookings.php?eid=<?php echo htmlentities($result->id); ?>" onclick="return confirm('Do you really want to Cancel this Booking')"> Cancel</a>

															<?php } ?>
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