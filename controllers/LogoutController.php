<?php
    class LogoutController {
        public function logout() {
            session_start();
            if(isset($_SESSION['zalogowany']) && $_SESSION['zalogowany']) {
                unset($_SESSION['zalogowany']);
            }

            header("Location: /elektron/");
        }
    }
?>