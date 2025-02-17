<?php
session_start();
error_reporting(0);
include('includes/config.php');
if (strlen($_SESSION['alogin']) == 0) {
	header('location:index.php');
} else {
	if (isset($_POST['submit'])) {
		$title = $_POST['vehicletitle'];
		$brand_id = $_POST['brandname'];
		$overview = $_POST['vehicalorcview'];
		$price_per_day = $_POST['priceperday'];
		$fuel_type = $_POST['fueltype'];
		$model_year = $_POST['modelyear'];
		$seating_capacity = $_POST['seatingcapacity'];
		$air_conditioner = $_POST['airconditioner'];
		$power_door_locks = $_POST['powerdoorlocks'];
		$anti_lock_braking_system = $_POST['antilockbrakingsys'];
		$brake_assist = $_POST['brakeassist'];
		$power_steering = $_POST['powersteering'];
		$driver_airbag = $_POST['driverairbag'];
		$passenger_airbag = $_POST['passengerairbag'];
		$power_windows = $_POST['powerwindow'];
		$cd_player = $_POST['cdplayer'];
		$central_locking = $_POST['centrallocking'];
		$crash_sensor = $_POST['crashcensor'];
		$leather_seats = $_POST['leatherseats'];
		$id = intval($_GET['id']);

		$sql = "UPDATE vehicles SET title=:title, brand_id=:brand_id, overview=:overview, price_per_day=:price_per_day, fuel_type=:fuel_type, model_year=:model_year, seating_capacity=:seating_capacity, air_conditioner=:air_conditioner, power_door_locks=:power_door_locks, anti_lock_braking_system=:anti_lock_braking_system, brake_assist=:brake_assist, power_steering=:power_steering, driver_airbag=:driver_airbag, passenger_airbag=:passenger_airbag, power_windows=:power_windows, cd_player=:cd_player, central_locking=:central_locking, crash_sensor=:crash_sensor, leather_seats=:leather_seats WHERE id=:id";
		$query = $dbh->prepare($sql);
		$query->bindParam(':title', $title, PDO::PARAM_STR);
		$query->bindParam(':brand_id', $brand_id, PDO::PARAM_STR);
		$query->bindParam(':overview', $overview, PDO::PARAM_STR);
		$query->bindParam(':price_per_day', $price_per_day, PDO::PARAM_STR);
		$query->bindParam(':fuel_type', $fuel_type, PDO::PARAM_STR);
		$query->bindParam(':model_year', $model_year, PDO::PARAM_STR);
		$query->bindParam(':seating_capacity', $seating_capacity, PDO::PARAM_STR);
		$query->bindParam(':air_conditioner', $air_conditioner, PDO::PARAM_STR);
		$query->bindParam(':power_door_locks', $power_door_locks, PDO::PARAM_STR);
		$query->bindParam(':anti_lock_braking_system', $anti_lock_braking_system, PDO::PARAM_STR);
		$query->bindParam(':brake_assist', $brake_assist, PDO::PARAM_STR);
		$query->bindParam(':power_steering', $power_steering, PDO::PARAM_STR);
		$query->bindParam(':driver_airbag', $driver_airbag, PDO::PARAM_STR);
		$query->bindParam(':passenger_airbag', $passenger_airbag, PDO::PARAM_STR);
		$query->bindParam(':power_windows', $power_windows, PDO::PARAM_STR);
		$query->bindParam(':cd_player', $cd_player, PDO::PARAM_STR);
		$query->bindParam(':central_locking', $central_locking, PDO::PARAM_STR);
		$query->bindParam(':crash_sensor', $crash_sensor, PDO::PARAM_STR);
		$query->bindParam(':leather_seats', $leather_seats, PDO::PARAM_STR);
		$query->bindParam(':id', $id, PDO::PARAM_STR);
		$query->execute();

		$msg = "Data updated successfully";
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

		<title>Car Rental Portal | Admin Edit Vehicle Info</title>

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

							<h2 class="page-title">Edit Vehicle</h2>

							<div class="row">
								<div class="col-md-12">
									<div class="panel panel-default">
										<div class="panel-heading">Basic Info</div>
										<div class="panel-body">
											<?php if ($msg) { ?><div class="succWrap"><strong>SUCCESS</strong>:<?php echo htmlentities($msg); ?> </div><?php } ?>
											<?php
											$id = intval($_GET['id']);
											$sql = "SELECT vehicles.*, brands.name, brands.id as bid from vehicles join brands on brands.id = vehicles.vehicles_brand where vehicles.id=:id";
											$query = $dbh->prepare($sql);
											$query->bindParam(':id', $id, PDO::PARAM_STR);
											$query->execute();
											$results = $query->fetchAll(PDO::FETCH_OBJ);
											$cnt = 1;
											if ($query->rowCount() > 0) {
												foreach ($results as $result) {	?>

													<form method="post" class="form-horizontal" enctype="multipart/form-data">
														<div class="form-group">
															<label class="col-sm-2 control-label">Vehicle Title<span style="color:red">*</span></label>
															<div class="col-sm-4">
																<input type="text" name="vehicletitle" class="form-control" value="<?php echo htmlentities($result->vehicles_title) ?>" required>
															</div>
															<label class="col-sm-2 control-label">Select Brand<span style="color:red">*</span></label>
															<div class="col-sm-4">
																<select class="selectpicker" name="brandname" required>
																	<option value="<?php echo htmlentities($result->bid); ?>"><?php echo htmlentities($bdname = $result->name); ?> </option>
																	<?php $ret = "select id,name from brands";
																	$query = $dbh->prepare($ret);
																	//$query->bindParam(':id',$id, PDO::PARAM_STR);
																	$query->execute();
																	$resultss = $query->fetchAll(PDO::FETCH_OBJ);
																	if ($query->rowCount() > 0) {
																		foreach ($resultss as $results) {
																			if ($results->name == $bdname) {
																				continue;
																			} else {
																	?>
																				<option value="<?php echo htmlentities($results->id); ?>"><?php echo htmlentities($results->name); ?></option>
																	<?php }
																		}
																	} ?>

																</select>
															</div>
														</div>

														<div class="hr-dashed"></div>
														<div class="form-group">
															<label class="col-sm-2 control-label">Vehical Overview<span style="color:red">*</span></label>
															<div class="col-sm-10">
																<textarea class="form-control" name="vehicalorcview" rows="3" required><?php echo htmlentities($result->vehicles_overview); ?></textarea>
															</div>
														</div>

														<div class="form-group">
															<label class="col-sm-2 control-label">Price Per Day(in USD)<span style="color:red">*</span></label>
															<div class="col-sm-4">
																<input type="text" name="priceperday" class="form-control" value="<?php echo htmlentities($result->price_per_day); ?>" required>
															</div>
															<label class="col-sm-2 control-label">Select Fuel Type<span style="color:red">*</span></label>
															<div class="col-sm-4">
																<select class="selectpicker" name="fueltype" required>
																	<option value="<?php echo htmlentities($results->FuelType); ?>"> <?php echo htmlentities($result->fuel_type); ?> </option>

																	<option value="Petrol">Petrol</option>
																	<option value="Diesel">Diesel</option>
																	<option value="CNG">CNG</option>
																</select>
															</div>
														</div>


														<div class="form-group">
															<label class="col-sm-2 control-label">Model Year<span style="color:red">*</span></label>
															<div class="col-sm-4">
																<input type="text" name="modelyear" class="form-control" value="<?php echo htmlentities($result->ModelYear); ?>" required>
															</div>
															<label class="col-sm-2 control-label">Seating Capacity<span style="color:red">*</span></label>
															<div class="col-sm-4">
																<input type="text" name="seatingcapacity" class="form-control" value="<?php echo htmlentities($result->seating_capacity); ?>" required>
															</div>
														</div>
														<div class="hr-dashed"></div>
														<div class="form-group">
															<div class="col-sm-12">
																<h4><b>Vehicle Images</b></h4>
															</div>
														</div>


														<div class="form-group">
															<div class="col-sm-4">
																Image 1 <img src="img/vehicleimages/<?php echo htmlentities($result->image1); ?>" width="300" height="200" style="border:solid 1px #000">
																<a href="changeimage1.php?imgid=<?php echo htmlentities($result->id) ?>">Change Image 1</a>
															</div>
															<div class="col-sm-4">
																Image 2<img src="img/vehicleimages/<?php echo htmlentities($result->image2); ?>" width="300" height="200" style="border:solid 1px #000">
																<a href="changeimage2.php?imgid=<?php echo htmlentities($result->id) ?>">Change Image 2</a>
															</div>
															<div class="col-sm-4">
																Image 3<img src="img/vehicleimages/<?php echo htmlentities($result->image3); ?>" width="300" height="200" style="border:solid 1px #000">
																<a href="changeimage3.php?imgid=<?php echo htmlentities($result->id) ?>">Change Image 3</a>
															</div>
														</div>

														<div class="hr-dashed"></div>
										</div>
									</div>
								</div>
							</div>



							<div class="row">
								<div class="col-md-12">
									<div class="panel panel-default">
										<div class="panel-heading">Accessories</div>
										<div class="panel-body">


											<div class="form-group">
												<div class="col-sm-3">
													<?php if ($result->AirConditioner == 1) { ?>
														<div class="checkbox checkbox-inline">
															<input type="checkbox" id="inlineCheckbox1" name="airconditioner" checked value="1">
															<label for="inlineCheckbox1"> Air Conditioner </label>
														</div>
													<?php } else { ?>
														<div class="checkbox checkbox-inline">
															<input type="checkbox" id="inlineCheckbox1" name="airconditioner" value="1">
															<label for="inlineCheckbox1"> Air Conditioner </label>
														</div>
													<?php } ?>
												</div>
												<div class="col-sm-3">
													<?php if ($result->PowerDoorLocks == 1) { ?>
														<div class="checkbox checkbox-inline">
															<input type="checkbox" id="inlineCheckbox1" name="powerdoorlocks" checked value="1">
															<label for="inlineCheckbox2"> Power Door Locks </label>
														</div>
													<?php } else { ?>
														<div class="checkbox checkbox-success checkbox-inline">
															<input type="checkbox" id="inlineCheckbox1" name="powerdoorlocks" value="1">
															<label for="inlineCheckbox2"> Power Door Locks </label>
														</div>
													<?php } ?>
												</div>
												<div class="col-sm-3">
													<?php if ($result->AntiLockBrakingSystem == 1) { ?>
														<div class="checkbox checkbox-inline">
															<input type="checkbox" id="inlineCheckbox1" name="antilockbrakingsys" checked value="1">
															<label for="inlineCheckbox3"> AntiLock Braking System </label>
														</div>
													<?php } else { ?>
														<div class="checkbox checkbox-inline">
															<input type="checkbox" id="inlineCheckbox1" name="antilockbrakingsys" value="1">
															<label for="inlineCheckbox3"> AntiLock Braking System </label>
														</div>
													<?php } ?>
												</div>
												<div class="col-sm-3">
													<?php if ($result->BrakeAssist == 1) {
													?>
														<div class="checkbox checkbox-inline">
															<input type="checkbox" id="inlineCheckbox1" name="brakeassist" checked value="1">
															<label for="inlineCheckbox3"> Brake Assist </label>
														</div>
													<?php } else { ?>
														<div class="checkbox checkbox-inline">
															<input type="checkbox" id="inlineCheckbox1" name="brakeassist" value="1">
															<label for="inlineCheckbox3"> Brake Assist </label>
														</div>
													<?php } ?>
												</div>

												<div class="form-group">
													<?php if ($result->PowerSteering == 1) {
													?>
														<div class="col-sm-3">
															<div class="checkbox checkbox-inline">
																<input type="checkbox" id="inlineCheckbox1" name="powersteering" checked value="1">
																<label for="inlineCheckbox1"> Power Steering </label>
															</div>
														<?php } else { ?>
															<div class="col-sm-3">
																<div class="checkbox checkbox-inline">
																	<input type="checkbox" id="inlineCheckbox1" name="powersteering" value="1">
																	<label for="inlineCheckbox1"> Power Steering </label>
																</div>
															<?php } ?>
															</div>
															<div class="col-sm-3">
																<?php if ($result->DriverAirbag == 1) {
																?>
																	<div class="checkbox checkbox-inline">
																		<input type="checkbox" id="inlineCheckbox1" name="driverairbag" checked value="1">
																		<label for="inlineCheckbox2">Driver Airbag</label>
																	</div>
																<?php } else { ?>
																	<div class="checkbox checkbox-inline">
																		<input type="checkbox" id="inlineCheckbox1" name="driverairbag" value="1">
																		<label for="inlineCheckbox2">Driver Airbag</label>
																	<?php } ?>
																	</div>
																	<div class="col-sm-3">
																		<?php if ($result->DriverAirbag == 1) {
																		?>
																			<div class="checkbox checkbox-inline">
																				<input type="checkbox" id="inlineCheckbox1" name="passengerairbag" checked value="1">
																				<label for="inlineCheckbox3"> Passenger Airbag </label>
																			</div>
																		<?php } else { ?>
																			<div class="checkbox checkbox-inline">
																				<input type="checkbox" id="inlineCheckbox1" name="passengerairbag" value="1">
																				<label for="inlineCheckbox3"> Passenger Airbag </label>
																			</div>
																		<?php } ?>
																	</div>
																	<div class="col-sm-3">
																		<?php if ($result->PowerWindows == 1) {
																		?>
																			<div class="checkbox checkbox-inline">
																				<input type="checkbox" id="inlineCheckbox1" name="powerwindow" checked value="1">
																				<label for="inlineCheckbox3"> Power Windows </label>
																			</div>
																		<?php } else { ?>
																			<div class="checkbox checkbox-inline">
																				<input type="checkbox" id="inlineCheckbox1" name="powerwindow" value="1">
																				<label for="inlineCheckbox3"> Power Windows </label>
																			</div>
																		<?php } ?>
																	</div>


																	<div class="form-group">
																		<div class="col-sm-3">
																			<?php if ($result->CDPlayer == 1) {
																			?>
																				<div class="checkbox checkbox-inline">
																					<input type="checkbox" id="inlineCheckbox1" name="cdplayer" checked value="1">
																					<label for="inlineCheckbox1"> CD Player </label>
																				</div>
																			<?php } else { ?>
																				<div class="checkbox checkbox-inline">
																					<input type="checkbox" id="inlineCheckbox1" name="cdplayer" value="1">
																					<label for="inlineCheckbox1"> CD Player </label>
																				</div>
																			<?php } ?>
																		</div>
																		<div class="col-sm-3">
																			<?php if ($result->CentralLocking == 1) {
																			?>
																				<div class="checkbox  checkbox-inline">
																					<input type="checkbox" id="inlineCheckbox1" name="centrallocking" checked value="1">
																					<label for="inlineCheckbox2">Central Locking</label>
																				</div>
																			<?php } else { ?>
																				<div class="checkbox checkbox-success checkbox-inline">
																					<input type="checkbox" id="inlineCheckbox1" name="centrallocking" value="1">
																					<label for="inlineCheckbox2">Central Locking</label>
																				</div>
																			<?php } ?>
																		</div>
																		<div class="col-sm-3">
																			<?php if ($result->CrashSensor == 1) {
																			?>
																				<div class="checkbox checkbox-inline">
																					<input type="checkbox" id="inlineCheckbox1" name="crashcensor" checked value="1">
																					<label for="inlineCheckbox3"> Crash Sensor </label>
																				</div>
																			<?php } else { ?>
																				<div class="checkbox checkbox-inline">
																					<input type="checkbox" id="inlineCheckbox1" name="crashcensor" value="1">
																					<label for="inlineCheckbox3"> Crash Sensor </label>
																				</div>
																			<?php } ?>
																		</div>
																		<div class="col-sm-3">
																			<?php if ($result->CrashSensor == 1) {
																			?>
																				<div class="checkbox checkbox-inline">
																					<input type="checkbox" id="inlineCheckbox1" name="leatherseats" checked value="1">
																					<label for="inlineCheckbox3"> Leather Seats </label>
																				</div>
																			<?php } else { ?>
																				<div class="checkbox checkbox-inline">
																					<input type="checkbox" id="inlineCheckbox1" name="leatherseats" value="1">
																					<label for="inlineCheckbox3"> Leather Seats </label>
																				</div>
																			<?php } ?>
																		</div>
																	</div>

															<?php }
													} ?>


															<div class="form-group">
																<div class="col-sm-8 col-sm-offset-2">

																	<button class="btn btn-primary" name="submit" type="submit" style="margin-top:4%">Save changes</button>
																</div>
															</div>

															</form>
															</div>
														</div>
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