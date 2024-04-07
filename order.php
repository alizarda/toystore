<?php   										// Opening PHP tag
	
	// Include the database connection script
	require 'includes/database-connection.php';


	/*
	 * TO-DO: Define a function that retrieves ALL customer and order info from the database based on values entered into form.
	 		  - Write SQL query to retrieve ALL customer and order info based on form values
	 		  - Execute the SQL query using the pdo function and fetch the result
	 		  - Return the order info
	 */

	
	// Check if the request method is POST (i.e, form submitted)
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		
		// Retrieve the value of the 'email' field from the POST data
		$email = $_POST['email'];

		// Retrieve the value of the 'orderNum' field from the POST data
		$orderNum = $_POST['orderNum'];

		// Write SQL query to retrieve order details based on email and order number
		$sql = "SELECT o.*, c.* FROM orders o
			INNER JOIN customer c ON o.custnum = c.custnum
			WHERE c.email = :email AND o.ordernum = :orderNum";
		
		// Prepare the SQL statement
		$stmt = $pdo->prepare($sql);
		
		// Bind the parameters
		$stmt->bindParam(':email', $email);
		$stmt->bindParam(':orderNum', $orderNum);
		
		// Execute the SQL statement
		$stmt->execute();
		
		// Fetch the result
		$orderInfo = $stmt->fetch(PDO::FETCH_ASSOC);
	}
	
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

			<div class="order-lookup-container">
				<div class="order-lookup-container">
					<h1>Order Lookup</h1>
					<form action="order.php" method="POST">
						<div class="form-group">
							<label for="email">Email:</label>
							<input type="email" id="email" name="email" required>
						</div>

						<div class="form-group">
							<label for="orderNum">Order Number:</label>
							<input type="text" id="orderNum" name="orderNum" required>
						</div>

						<button type="submit">Lookup Order</button>
					</form>
				</div>
				
				<?php if (!empty($orderInfo)): ?>
					<div class="order-details">
						<h1>Order Details</h1>
						<p><strong>Name: </strong> <?= $orderInfo['cname'] ?></p>
						<p><strong>Username: </strong> <?= $orderInfo['username'] ?></p>
						<p><strong>Order Number: </strong> <?= $orderInfo['ordernum'] ?></p>
						<p><strong>Quantity: </strong> <?= $orderInfo['quantity'] ?></p>
						<p><strong>Date Ordered: </strong> <?= $orderInfo['date_ordered'] ?></p>
						<p><strong>Delivery Date: </strong> <?= $orderInfo['date_deliv'] ?></p>
					</div>
				<?php endif; ?>

				<?php if (!empty(null)): ?>
					<div class="order-details">
						<h1>Order Details</h1>
						<p><strong>Name: </strong> <?= $orderInfo['cname'] ?></p>
						<p><strong>Username: </strong> <?= $orderInfo['username'] ?></p>
						<p><strong>Order Number: </strong> <?= $orderInfo['ordernum'] ?></p>
						<p><strong>Quantity: </strong> <?= $orderInfo['quantity'] ?></p>
						<p><strong>Date Ordered: </strong> <?= $orderInfo['date_ordered'] ?></p>
						<p><strong>Delivery Date: </strong> <?= $orderInfo['date_deliv'] ?></p>
					</div>
				<?php endif; ?>
				</div>

		</main>

	</body>

</html>
