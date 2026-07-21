<?php
    class Models {
        private $database;

        public function __construct(object $database) {
            $this->database = $database;
        }

        protected function executeQuery(string $sql): array {
            $result = mysqli_query($this->database, $sql);

            if ($result === false) {
                $errorMsg = mysqli_error($this->database);
                throw new Exception("Błąd bazy danych: $errorMsg");
            }

            $data = [];
            if ($result && mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $data[] = $row;
                }
            }
            return $data;
        }

        protected function executeInsertQuery(string $sql): bool {
            $result = mysqli_query($this->database, $sql);

            if ($result === false) {
                $errorMsg = mysqli_error($this->database);
                throw new Exception("Błąd bazy danych: $errorMsg");
            }

            if (mysqli_affected_rows($this->database) > 0) {
                return true;
            }
            return false;
        }

        protected function executeDeleteQuery(string $sql): bool {
            $result = mysqli_query($this->database, $sql);

            if ($result === false) {
                $errorMsg = mysqli_error($this->database);
                throw new Exception("Błąd bazy danych: $errorMsg");
            }

            return mysqli_affected_rows($this->database) > 0;
        }
    }
?>