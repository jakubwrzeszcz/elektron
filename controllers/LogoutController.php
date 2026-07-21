<?php
    class LogoutController {
        public function logout() {
            session_start();
            if($_SESSION['zalogowany']) {
                unset($_SESSION['zalogowany']);
            }

            header("Location: /elektron/");
        }
    }
?>