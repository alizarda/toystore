<?php   										// Opening PHP tag
	
	// Include the database connection script
	require 'includes/database-connection.php';

	// Retrieve the value of the 'toynum' parameter from the URL query string
	//		i.e., ../toy.php?toynum=0001
	$toy_id = $_GET['toynum'];

	/*
	 * Retrieve toy information from the database based on the toy ID.
	 * 
	 * @param PDO $pdo       An instance of the PDO class.
	 * @param string $id     The ID of the toy to retrieve.
	 * @return array|null    An associative array containing the toy information, or null if no toy is found.
	 */

	function get_toy_info(PDO $pdo, $toy_id) {
		// SQL query to retrieve toy and manufacturer info based on toynum
		$sql = "SELECT toy.toynum AS toy_number, toy.name AS toy_name, toy.price AS toy_price, toy.agerange AS toy_age_range,
					toy.numinstock AS toy_stock, toy.imgSrc AS toy_image, toy.description AS toy_description, manuf.name AS
					manufacturer_name, manuf.Street, manuf.City, manuf.State, manuf.ZipCode, manuf.phone, manuf.contact
				FROM toy
				INNER JOIN manuf ON toy.manid = manuf.manid
				WHERE toy.toynum = :toynum";

		// Prepare the SQL query
		$stmt = $pdo->prepare($sql);

		// Bind the toynum parameter to the toy_id
		$stmt->bindParam(':toynum', $toy_id);

		// Execute the SQL query
		$stmt->execute();

		// Fetch the result as an associative array
		$toy_info = $stmt->fetch(PDO::FETCH_ASSOC);

		// Return the toy info
		return $toy_info;
	}
	
	// Retrieve info about toy from the db using provided PDO connection
	$toy_info = get_toy_info($pdo, $toy_id);

// Closing PHP tag  ?> 

<!DOCTYPE>
<html>

	<head>
		<meta charset="UTF-8">
  		<meta name="viewport" content="width=device-width, initial-scale=1.0">
  		<title>Toys R URI</title>
  		<link rel="stylesheet" href="css/style.css">
  		<link rel="preconnect" href="https://fonts.googleapis.com">
		<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
		<link href="https://fonts.googleapis.com/css2?family=Lilita+One&display=swap" rel="stylesheet">
	</head>

	<body>

		<header>
			<div class="header-left">
				<div class="logo">
					<img src="imgs/logo.png" alt="Toy R URI Logo">
      			</div>

	      		<nav>
	      			<ul>
	      				<li><a href="index.php">Toy Catalog</a></li>
	      				<li><a href="about.php">About</a></li>
			        </ul>
			    </nav>
		   	</div>

		    <div class="header-right">
		    	<ul>
		    		<li><a href="order.php">Check Order</a></li>
		    	</ul>
		    </div>
		</header>
			
		<main>
			<div class="toy-details-container">
				<div class="toy-image">
					<!-- Display image of toy with its name as alt text -->
					<img src="<?= $toy_info['toy_image'] ?>" alt="<?= $toy_info['toy_name'] ?>">
				</div>

				<div class="toy-details">

					<!-- Display name of toy -->
					<h1><?= $toy_info['toy_name'] ?></h1>

					<hr />

					<h3>Toy Information</h3>

					<!-- Display description of toy -->
					<p><strong>Description:</strong> <?= $toy_info['toy_description'] ?></p>

					<!-- Display price of toy -->
					<p><strong>Price:</strong> $<?= $toy_info['toy_price'] ?></p>

					<!-- Display age range of toy -->
					<p><strong>Age Range:</strong> <?= $toy_info['toy_age_range'] ?></p>

					<!-- Display stock of toy -->
					<p><strong>Number In Stock:</strong> <?= $toy_info['toy_stock'] ?></p>

					<br />

					<h3>Manufacturer Information</h3>

					<!-- Display name of manufacturer -->
					<p><strong>Name:</strong> <?= $toy_info['manufacturer_name'] ?> </p>

					<!-- Display address of manufacturer -->
					<p><strong>Address:</strong> <?= $toy_info['Street'] ?>, <?= $toy_info['City'] ?>, <?= $toy_info['State'] ?>, <?= $toy_info['ZipCode'] ?></p>

					<!-- Display phone of manufacturer -->
					<p><strong>Phone:</strong> <?= $toy_info['phone'] ?></p>

					<!-- Display contact of manufacturer -->
					<p><strong>Contact:</strong> <?= $toy_info['contact'] ?></p>
				</div>
			</div>
		</main>

		</body>
		</html>
