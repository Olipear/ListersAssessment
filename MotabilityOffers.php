<?php

// get the page id, or set it to the first vehicle if not present
// assumes that the link will be made from elsewhere on the site or set with REQUEST instead
if (isset($_GET['id'])){
	$vehicleId = $_GET['id'];
}else{
	$vehicleId = '5629a64e9185130a78ed2a34';
}

//get the vehicle info for the given Id 
function getVehicleById($id){
	$vehicleDataString = file_get_contents("vehicle.json");
	$vehicleDataArray = json_decode($vehicleDataString, true);
	foreach($vehicleDataArray['Vehicles'] as $value){
		// return the vehicle information that matches the given Id
		if ($value['_id'] == $id){
			return $value;
		};
	};
};

//Get value in vehicle 
function getVehicleValue($L1, $category, $techCode){
	foreach($GLOBALS['vehicle']['technical'] as $cat){
		if ($cat['category'] == $category){
			foreach($cat['contents'] as $code){
				if($code['techcode'] == $techCode){	
					// check if there is a real value or just N
					if ($code['value'] == 'N' || $code['value'] == 'n' || $code['value'] == 'False'){
						return false;
					}else{
						return $code['value'];
					};					
				}					
			};
		};
	};
	// if it hasnt found the tech code return false so it's not displayed
	return false;
};

//for making css tables to display vehicle data, doesn't display if there is no value
function specTable($x, $descriptor, $unit = " "){
	if($x){
		echo '<div><p>', $descriptor, '</p><p>', $x, ' ', $unit, '</p></div>';
	};						
};

//for displaying specs with an icon
function iconSpec($x, $descriptor, $icon, $unit = " "){
	if($x){
		echo '<li><h1>', $icon, '<h1><h4>', $descriptor, '</h4><p>', $x, $unit, '</p></li>'; 
	};						
};

$vehicle = getVehicleById($vehicleId);

$baseURL = "https://listers.co.uk";
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width,initial-scale=1">
		<title>Motability Offers</title>
		<meta name="author" content="OliverPearson">
		<link rel="stylesheet" href="code/css/normalize.css" type="text/css">
		<link rel="stylesheet" href="code/css/skeleton.css" type="text/css">
		<link href="https://fonts.googleapis.com/css?family=Montserrat:300,400,600,800" rel="stylesheet">		
		<link rel="stylesheet" href="code/css/main.css" type="text/css">  
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
		<script src="code/js/main.js" type="text/javascript"></script>
	</head>
		
	<body>
	<?php require 'header.php';?>
		<div class="container"> 
			<div class="row matchHeight" id="vehicleHeading">
				<div class="two columns matchThis unresponsive hideOnMobile">
					<img class="roundedBox" src="<?php echo $baseURL, $vehicle['manufacturer']['logo'] ?>" >
				</div>
				<div class="ten columns unresponsive matchToThis">
					<h1>
					<?php 
						echo $vehicle['manufacturer']['name'], ' ', $vehicle['range']['name'], ' ', $vehicle['derivative']['name'], " Motability Offer";
					?></h1>
					<p>
					Lorem ipsum dolor amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
					</p>
				</div>				
			</div>
			<div class="row">
				<div class="five columns">
					<div class="roundedBox imageSlider">
						<ul>
						<!-- there's only one image per vehicle but I think you want me to demonstrate a slider in JS
						so I'm just going to show the same one a few times-->
							<li>
								<img src="<?php echo $baseURL, $vehicle['image']['full'] ?>" >
								<div></div>
							</li><li>
								<img src="<?php echo $baseURL, $vehicle['image']['full'] ?>" >
								<div></div>
							</li><li>
								<img src="<?php echo $baseURL, $vehicle['image']['full'] ?>" >
								<div></div>
							</li><li>
								<img src="<?php echo $baseURL, $vehicle['image']['full'] ?>" >
								<div></div>
							</li>
						</ul>
					</div>
					<ul class="keyBullets">
						<li>60,000 mile allowance over 3 years for cars, rising to 100,000 over 5 years for wheelchair accessible vehicles.</li>
						<li>You can nominate up to two drivers (who should live within 5 miles of the disabled customer's address).</li>
						<li>If you need adaptations, many of the most popular ones can be added at no extra cost.</li>
					</ul>
				</div>
				<div class="seven columns">
					<div class="roundedBox">
						<div id="retalDetails" >
							<h4>RENTAL DETAILS</h4>
							<div class="table">
								<div>
									<p>Advance payment of:</p>
									<p>&#163;2,899</p>
								</div>
								<div>
									<p>Mileage Allowance:</p>
									<p>60,000*</p>
								</div>
								<div>
									<p>Road Tax:</p>
									<p>Included</p>
								</div>
								<div>
									<p>Full Breakdown Assistance:</p>
									<p>Included</p>
								</div>
								<div>
									<p>Insurance:</p>
									<p>Included</p>
								</div>
								<div>
									<p>Service and Maintenance:</p>
									<p>Included</p>
								</div>
								<div>
									<p>Tyre Replacement:</p>
									<p>Included</p>
								</div>
								<div>
									<p>Windscreen Replacement:</p>
									<p>Included</p>
								</div>
							</div>
						</div>
						<div id="detailsForm" >
							<h4>YOUR DETAILS</h4>
							<form name="MotabilityEnquiry" method="POST">
								<div class="row matchHeight">
									<div class="left column matchToThis">
										<input name="fullname" type="text" required placeholder="Full Name:">
										<input name="telephone" type="text" pattern="^(((\+44\s?\d{4}|\(?0\d{4}\)?)\s?\d{3}\s?\d{3})|((\+44\s?\d{3}|\(?0\d{3}\)?)\s?\d{3}\s?\d{4})|((\+44\s?\d{2}|\(?0\d{2}\)?)\s?\d{4}\s?\d{4}))(\s?\#(\d{4}|\d{3}))?$" placeholder="Telephone:">
										<input name="email" type="text" required placeholder="Email Address:">
										<input name="building" type="text" required placeholder="Building No./Name:"><input name="postcode" type="text" pattern="([Gg][Ii][Rr] 0[Aa]{2})|((([A-Za-z][0-9]{1,2})|(([A-Za-z][A-Ha-hJ-Yj-y][0-9]{1,2})|(([A-Za-z][0-9][A-Za-z])|([A-Za-z][A-Ha-hJ-Yj-y][0-9]?[A-Za-z]))))\s?[0-9][A-Za-z]{2})" required placeholder="Post Code:">
									</div>
									<div class="right column matchThis">
										<textarea name="requirements" placeholder="Requirements"></textarea>
									</div>
								</div>
								<button type="submit" value="submit">SEND LEASING ENQUIRY</button>
							</form>
						</div>
					</div>
					<div class="roundedBox">
						<div id="assistanceInfo" >
							<h2>Need some assistance?</h2>
							<p>To speak with a member of our motability team, call a dealership local to you directly from one of the numbers below.</p>
							<div class="table fullwidth">
								<div>
									<p>Listers Volkswagen Coventry</p>
									<p>024 7771 0184</p>									
								</div>
								<div>									
									<p>Listers Volkswagen Evesham</p>
									<p>01386 570 714</p>
								</div>
							</div>
							<!-- I would put local numbers here with the right information, i.e. geo-coordinates for dealerships -->						
						</div>
					</div>
				</div>
			</div>
		</div>
	<div class="darkBg">
		<div class="container">
			<h2 style="text-align:center;width:100%;">Technical Specifications</h2>
			<ul id="keySpecs">
				<?php 
					iconSpec(getVehicleValue('technical', 'Fuel Consuption', 8), 'COMBINED MPG', '&#xe900;', ' mpg');
					iconSpec(getVehicleValue('technical', 'Emissions', 67), 'CO2 EMMISSIONS', '&#xe901;', ' g/km');
					iconSpec(getVehicleValue('technical', 'Weight and Capacities', 23), '0-60 MPH', '&#xe902;', ' secs');
					iconSpec(getVehicleValue('technical', 'Performance', 13), 'MAX SPEED', '&#xe904;', ' mph');
					iconSpec(getVehicleValue('technical', 'Performance', 21), 'MAX POWER', '&#xe903;', ' bhp');
				?>
			</ul>
			<div class="row" id="dimensions">
				<div class="six columns">
					<!-- didn't have time to create the images for these --> 
				</div>
				<div class="six columns">
				</div>
			</div>
			<div id="weightCapacities">
			<div class="row">
				<div class="three columns">
					<h3>Weight and Capacities</h3>
				</div>
				<div class="nine columns">
				<!-- these two tables in CSS rather than table element because then it's easier to remove null values  -->
					<div class="table">
						<?php
						specTable(getVehicleValue('technical', 'Weight and Capacities', 14), "Gross Vehicle Weight", "Kg" );
						specTable(getVehicleValue('technical', 'Weight and Capacities', 32), "Luggage Capacity (Seats Up)", "Litres" );
						specTable(getVehicleValue('technical', 'Weight and Capacities', 3), "Minimum Kerbweight", "Kg");
						specTable(getVehicleValue('technical', 'Weight and Capacities', 47), "No. of Seats");
						specTable(getVehicleValue('technical', 'Weight and Capacities', 24), "Fuel Tank Capacity", "Litres");
						specTable(getVehicleValue('technical', 'Weight and Capacities', 70), "Max Loading Weight", "Kg");
						?>
					</div>
				</div>
			</div>
			<div class="row" >
				<div class="nine columns offset-by-three" >
					
					<div class="table">
						<?php
						specTable(getVehicleValue('technical', 'Weight and Capacities', 21), "Engine Power", "BHP/PS" );
						specTable(getVehicleValue('technical', 'Weight and Capacities', 49), "Engine Power at", "RPM");
						// this one needs to be yes or no
						if (getVehicleValue('technical', 'Performance', 22)){
							$x = "Yes";
						}else{
							$x = "No";
						};
						specTable($x, "Engine power in PS?", "");
						specTable(getVehicleValue('technical', 'Weight and Capacities', 50), "Engine Torque", "lbs/ft");
						specTable(getVehicleValue('technical', 'Weight and Capacities', 23), ">0- 60 MPH", "Secs" );
						specTable(getVehicleValue('technical', 'Weight and Capacities', 51), "Engine Torque", "Nm" );
						specTable(getVehicleValue('technical', 'Weight and Capacities', 13), "Top Speed", "MPH" );
						specTable(getVehicleValue('technical', 'Weight and Capacities', 13), "Engine Torque at", "RPM" );
						?>
					</div>
				</div>
			</div>
			</div>
		</div>
	</div>
	</body>
<?php require 'footer.php';?>
</html>