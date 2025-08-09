<!DOCTYPE html>
<html lang="en">
<head>
    <title>Web Programming using PHP - Coursework 2 - Task 3</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<link rel="stylesheet" type="text/css" href="css/styles.css?">

</head>
<body>
	<header>   
        <h1>Web Programming using PHP - Coursework 2 - Task 3</h1>
		<h2>Webform data entry, validation, and database storage</h2>
	</header>
	<main>
		<?php
		#Your PHP solution code should go here...
		session_start();


		$host = '******';
		$db   = '****';
		$user = '****';
		$pass = '******';
		$charset = 'utf8mb4';
		$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
		$options = [
			PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
			PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
			PDO::ATTR_EMULATE_PREPARES => false,
		];
	
		try {
			$pdo = new PDO($dsn, $user, $pass, $options);
		} catch (PDOException $e) {
		die("Connection failed: " . $e->getMessage());
		}
		// create the usersTable
		$sql = "CREATE TABLE IF NOT EXISTS usersTable (
			usersTable_id INT AUTO_INCREMENT PRIMARY KEY,
			usersTable_email VARCHAR(45) NOT NULL UNIQUE,
			usersTable_username VARCHAR(30) NOT NULL UNIQUE,
			usersTable_password VARCHAR(100) NOT NULL,  -- removed UNIQUE here
			usersTable_userType ENUM('admin','academic','student') NOT NULL
		)";
		$pdo->exec($sql);
		$initialUsers = [
			[1, 'test1@test.com', 'ubadmin001', 'Aaaa1111##', 'admin'],
			[2, 'test2@test.com', 'ubacadem01', 'Aaaa1111##', 'academic'],
			[3, 'test3@test.com', 'fflintoff01', 'Aaaa1111##', 'student'],
			[4, 'ahmedtaha@live.co.uk', 'ahmed34343', 'Adsdw4$2323', 'academic'],
			[5, 'larisa@test.com', 'larisa011111', 'Larisa20003!', 'student'],
			[6, 'example@test.com', 'example12345', 'Example12345!', 'academic'],
			[7, 'test5@test.com', 'ubadmin002', 'dnbviwbo12S!', 'admin'],
			[8, 'olga.cocos@outlook.com', 'ococos0100000', 'Craziness10!', 'academic'],
			[9, 'test4@test.com', 'ubadmin0012', 'Qdssfsdf123123$', 'academic'],
			[10, 'test10@test.com', 'ubadmin0011', 'Qwerty1234$', 'academic'],
			[11, 'uncaxjsnc@gmail.com', 'icbeaxnj01', 'jndjnedaDJ123!', 'admin'],
			[17, 'jbxsj@gmail.com', 'icbeaxnj02', 'jndjnedaDJ123!', 'admin'],
			[18, 'knskankx@jsnws.com', 'snjxwsxswn01', 'jndjnedaDJ123!', 'academic'],
			[19, 'test1234@mail.com', 'acghruthn123', 'Abcdefg123!etau', 'academic'],
			[20, 'test14@test.com', 'ubadmin034', 'AAAAAAAaa123!', 'academic'],
			[21, 'muhammadumarrasheed68@gmail.com', 'omerrasheed68', 'asdasdasA12&', 'academic'],
			[22, 'wer@abc.com', 'werasdsad123', 'werewr123&A', 'academic'],
			[23, 'dp@gmail.com', 'fgsavyy76yg', 'ABCV&1246abns99', 'academic'],
			[24, 'test100@example.com', 'tester1234', 'Notallowed123!', 'student'],
			[25, 'sdfsdf@asdasda.com', 'sdfsdfasdasdasdasd', 'sdfs23Pasad£#as', 'academic'],
			[26, 'test12@test.com', 'ubadmin0sdfsd', 'sdfs23Pasadass#', 'academic'],
			[27, 'test45@test.com', 'ubdadminfr4', 'Password!!!1', 'academic'],
			[28, 'johnsmith@test.com', 'johnsmith01', 'Johnnyboy123!', 'student'],
			[29, 'hi@mail.com', 'hi0100000152265', 'TestPassword1!', 'academic']
		];

		foreach ($initialUsers as [$id, $email, $username, $password, $userType]) {
			$stmt = $pdo->prepare("SELECT COUNT(*) FROM usersTable WHERE usersTable_username = ? OR usersTable_email = ?");
			$stmt->execute([$username, $email]);
			if ($stmt->fetchColumn() == 0) {
				$stmt = $pdo->prepare("INSERT INTO usersTable (usersTable_email, usersTable_username, usersTable_password, usersTable_userType) VALUES (?, ?, ?, ?)");
				$stmt->execute([$email, $username, $password, $userType]);  // FIXED: use $stmt here
			}
		}


		$email = $username = $password = $userType = "";
		$errors = [];
		$successMsg = "";

		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			if (isset($_POST['clear'])) {
				$_POST = [];
			} elseif (isset($_POST['save'])) {
				$email = trim($_POST['email'] ?? '');
				$username = trim($_POST['username'] ?? '');
				$password = trim($_POST['password'] ?? '');
				$userType = trim($_POST['userType'] ?? '');

				if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
					$errors['email'] = 'Invalid email format.';
				}

				if (!preg_match("/^[a-zA-Z0-9]{10,}$/", $username)) {
					$errors['username'] = 'Username must be at least 10 alphanumeric characters.';
				}

				if (!preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[&\-\$%\*!#]).{10,}$/", $password)) {
					$errors['password'] = 'Password must be at least 10 characters, include upper, lower, number and special character.';
				}

				if (!in_array($userType, ['admin', 'academic', 'student'])) {
					$errors['userType'] = 'Invalid user type selected.';
				}

				if (empty($errors)) {
					$stmt = $pdo->prepare("INSERT INTO usersTable (email, username, password, userType) VALUES (?, ?, ?, ?)");
					try {
						$stmt->execute([$email, $username, $password, $userType]);
						$successMsg = "New user $username successfully inserted into database";
						$email = $username = $password = $userType = "";
					} catch (PDOException $e) {
						$errors['db'] = 'Email or Username already exists.';
					}
				}
			}
		}

		function escape($val) {
			return htmlspecialchars($val ?? '', ENT_QUOTES);
		}

		include 'html/userDataForm.html';

		echo "<h2>Users Stored In The Database</h2>";
		$stmt = $pdo->query("SELECT * FROM usersTable");
		$users = $stmt->fetchAll();
		
		

		if (count($users) === 0) {
			echo "<p>No users stored in the database</p>";
		} else {
			foreach ($users as $u) {
				echo "<p>ID:{$u['usersTable_id']}, Email:{$u['usersTable_email']}, Username:{$u['usersTable_username']}, Type:{$u['usersTable_userType']}</p>";

			}
		}


		?>
		
    </main> 
</body>
</html>