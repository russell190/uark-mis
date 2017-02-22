<?php
	error_reporting(E_ALL);
	ini_set('display_errors', 1);
	
	if(false){
		$config = parse_ini_file('../private/credentials.ini');
		$servername = $config["servername"];
		$username = $config["username"];
		$password = $config["password"];
		$dbname = $config["dbname"];
		try {
			$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$stmt = $conn->prepare("INSERT INTO students (studentID,   firstName,  middleName,  lastName,  preferredName,  primaryEmail,  secondaryEmail,  primaryPhone,  secondaryPhone,  socialSecurityNumber,  dateOfBirth,  ethnicity,  gender,  citizenship) 
												  VALUES (:studentID, :firstName, :middleName, :lastName, :preferredName, :primaryEmail, :secondaryEmail, :primaryPhone, :secondaryPhone, :socialSecurityNumber, :dateOfBirth, :ethnicity, :gender, :citizenship)");
			$stmt->bindParam(':studentID', $studentID);
			$stmt->bindParam(':firstName', $firstName);
			$stmt->bindParam(':middleName', $middleName);
			$stmt->bindParam(':lastName', $lastName);
			$stmt->bindParam(':preferredName', $preferredName);
			$stmt->bindParam(':primaryEmail', $primaryEmail);
			$stmt->bindParam(':secondaryEmail', $secondaryEmail);
			$stmt->bindParam(':primaryPhone', $primaryPhone);
			$stmt->bindParam(':secondaryPhone', $secondaryPhone);
			$stmt->bindParam(':socialSecurityNumber', $socialSecurityNumber);
			$stmt->bindParam(':dateOfBirth', $dateOfBirth);
			$stmt->bindParam(':ethnicity', $ethnicity);	
			$stmt->bindParam(':gender', $gender);
			$stmt->bindParam(':citizenship', $citizenship);				

			$studentID = $_POST['studentID'];
			$firstName = $_POST['firstName'];
			$middleName = $_POST['middleName'];
			$lastName = $_POST['lastName'];
			$preferredName = $_POST['preferredName'];
			$primaryEmail = $_POST['primaryEmail'];
			$secondaryEmail = $_POST['secondaryEmail'];
			$primaryPhone = $_POST['primaryPhone'];
			$secondaryPhone = $_POST['secondaryPhone'];
			$socialSecurityNumber = $_POST['socialSecurityNumber'];
			$dateOfBirth = $_POST['dateOfBirth'];
			$ethnicity = $_POST['ethnicity'];
			$gender = $_POST['gender'];
			$citizenship = $_POST['citizenship'];
			$stmt->execute();

			echo "New records created successfully";
		}
		catch(Exception $e){
			echo "Error: " . $e->getMessage();
		}
		$conn = null;
	}else{
		echo "<table border=.5>";
		foreach( $_POST as $stuff => $val ) {
			echo "<tr>";
			if( is_array( $stuff ) ) {
				foreach( $stuff as $thing) {
					echo $thing;
				}
			} else {
				echo "<td>";
				echo $stuff;
				echo "</td>";
				echo "<td>";
				if($stuff=="socialSecurityNumber")
					echo password_hash($val,PASSWORD_DEFAULT);
				else
					echo $val;
				echo "</td>";
			}
			echo "</tr>";
		}
		echo "</table>";	
	}

	$target_dir = "../private/uploads/";
	//$target_dir="/";
	$target_file = $target_dir . basename($_FILES["resumeFile"]["name"]);
	$uploadOk = 1;
	$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
	// Check if image file is a actual image or fake image
	if(isset($_POST["submit"])) {
		$uploadOk=1;
		
		$check = getimagesize($_FILES["resumeFile"]["tmp_name"]);
		if($check !== false) {
			echo "File is an image - " . $check["mime"] . ".";
			$uploadOk = 1;
		} else {
			echo "File is not an image.";
			$uploadOk = 1;
		}
	}
	if (move_uploaded_file($_FILES["resumeFile"]["tmp_name"], $target_file)) {
		echo "The file ". basename( $_FILES["resumeFile"]["name"]). " has been uploaded.";
	} else {
		echo "Sorry, there was an error uploading your file.";
	}	

?>
