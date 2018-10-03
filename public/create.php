<?php

/**
 * Use an HTML form to create a new entry in the
 * users table.
 *
 */

// The isset() function return false if testing variable contains a NULL value.
if (isset($_POST['submit'])) {
	require "../config.php";

	try {
		// $dsn and other parameters are included in config.php
		// trying to establish connection with PDO()
		$connection = new PDO($dsn, $username, $password, $options);
		
		// define array users; "index => value";
		// we declare to array where to look for its values
		$new_user = array(
			"firstname" => $_POST['firstname'],
			"lastname"  => $_POST['lastname'],
			"email"     => $_POST['email'],
			"age"       => $_POST['age'],
			"location"  => $_POST['location']
		);

		// We need to execute a SQL query; sprintf() automates the process
		// The sprintf() function writes a formatted string to a variable.
		// The arg1, arg2, ++ parameters will be inserted at percent (%) signs in the main string.
		$sql = sprintf(
			"INSERT INTO %s (%s) values (%s)",
			"users",
			// implode() function returns a string from the elements of an array.
			// implode(separator,array)
			implode(", ", array_keys($new_user)),
			// dot in php concats strings
			":" . implode(", :", array_keys($new_user))
		);
		
		$statement = $connection->prepare($sql);
		$statement->execute($new_user);
	} catch(PDOException $error) {
		// standard command for error handling
		echo $sql . "<br>" . $error->getMessage();
	}
	
}
?>

<?php include "templates/header.php"; ?>

<h2>Add a user</h2>

<form method="post">
	<label for="firstname">First Name</label>
	<input type="text" name="firstname" id="firstname">
	<label for="lastname">Last Name</label>
	<input type="text" name="lastname" id="lastname">
	<label for="email">Email Address</label>
	<input type="text" name="email" id="email">
	<label for="age">Age</label>
	<input type="text" name="age" id="age">
	<label for="location">Location</label>
	<input type="text" name="location" id="location">
	<input type="submit" name="submit" value="Submit">
</form>

<a href="index.php">Back to home</a>

<?php include "templates/footer"; ?>