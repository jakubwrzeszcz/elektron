<?php
	session_start();
	require_once "config.php";
	require_once "permission.php";

    if ((!isset($_POST['login'])) || (!isset($_POST['password']))) {
		header('Location: admin-logowanie-formularz.php');
		exit();
	}

	if(!isset($_POST['recaptcha_token'])) {
		$_SESSION['blad'] = '<span style="color:red">Brak tokena captcha!</span>';
		header("Location: admin-logowanie-formularz.php");
		exit();
	}
	
	if(isset($_POST['login']) && isset($_POST['password']) && isset($_POST['recaptcha_token'])) {
		$login = $_POST['login'];
		$password = $_POST['password'];

		if(!verifyCaptcha($_POST['recaptcha_token'])) {
			$_SESSION['blad'] = '<span style="color:red">Błąd w captcha v3!</span>';
			header("Location: admin-logowanie-formularz.php");
			exit();
		}
		
		if($result = mysqli_query($polaczenie, "SELECT pracownicy.id_pracownika, pracownicy.imie, pracownicy.nazwisko, stanowiska.nazwa_stanowiska, pracownicy.adres_email, pracownicy.telefon FROM pracownicy JOIN stanowiska ON stanowiska.id_stanowiska = pracownicy.id_stanowiska WHERE adres_email='$login' AND haslo='$password'")) {
			if(mysqli_num_rows($result) > 0) {
				$_SESSION['zalogowany'] = true;
				$row = mysqli_fetch_assoc($result);
				$_SESSION['id_pracownika'] = $row['id_pracownika'];
				$_SESSION['imie'] = $row['imie'];
				$_SESSION['nazwisko'] = $row['nazwisko'];
				$_SESSION['telefon'] = $row['telefon'];
				$_SESSION['adres_email'] = $row['adres_email'];
				$_SESSION['typ_sesji'] = "pracownik";
				$_SESSION['stanowisko'] = $row['nazwa_stanowiska'];
				$_SESSION['perms'] = getWorkerPermissions($row['nazwa_stanowiska']);
				unset($_SESSION['blad']);
				mysqli_close($polaczenie);
				header('Location: admin.php');
				exit();
			} else {
				mysqli_close($polaczenie);
				$_SESSION['blad'] = '<span style="color:red">Nieprawidłowy login lub hasło!</span>';
				header("Location: admin-logowanie-formularz.php");
				exit();
			}
		} else {
			mysqli_close($polaczenie);
			$_SESSION['blad'] = '<span style="color:red">Blad zapytania!</span>';
			header("Location: admin-logowanie-formularz.php");
			exit();
		}
	}
?>