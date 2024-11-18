<?php
include_once "Models/Model.php";
include_once "Controllers/Controller.php";


class Guest extends Model {
    public $id;
    public $name;
    public $email;
    public $guestListId; 
    function __construct($id = -1) {
        parent::__construct(); 

        $this->id = $id;

        if ($id < 0) {
            $this->name = "";
            $this->email = "";
            $this->guestListId = "";
        } else {
            $stmt = $this->conn->prepare("SELECT * FROM `guests` WHERE id = ?");
            if ($stmt) {
                $stmt->bind_param("i", $id);
                $stmt->execute();
                $result = $stmt->get_result()->fetch_assoc();
                if ($result) {
                    $this->id = $result['id'];
                    $this->name = $result['name'];
                    $this->email = $result['email'];
                    $this->guestListId = $result['guestListId'];  // Correct property name
                } else {
                    $this->id = "";
                    $this->name = "";
                    $this->email = "";
                    $this->guestListId = "";
                }
                $stmt->close();
            } else {
                echo "Error occurred: " . $this->conn->error;
            }
        }
    }

    // CRUD FUNCTIONS

    public function createGuest($data) {
        $sql = "INSERT INTO `guests` (`name`, `email`, `guestListId`) VALUES (?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        if ($stmt) {
            // Sanitize input data
            $data->name = htmlspecialchars($data->name);
            $data->email = filter_var($data->email, FILTER_SANITIZE_EMAIL);
            $data->guestListId = (int)$data->guestListId;  

            $stmt->bind_param("ssi", $data->name, $data->email, $data->guestListId);
            $result = $stmt->execute();
            $stmt->close();
            return $result;
        } else {
            echo "Error: " . $this->conn->error;
            return false;
        }
    }

    public function listGuests() {
        $stmt = $this->conn->prepare("SELECT * FROM `guests`");
        if ($stmt) {
            $stmt->execute();
            $result = $stmt->get_result();
            $guests = [];

            while ($row = $result->fetch_assoc()) {
                $guests[] = new Guest($row['id']);
            }

            $stmt->close();
            return $guests;
        } else {
            echo "Error: " . $this->conn->error;
            return [];
        }
    }

    public function updateGuest($data) {
        $sql = "UPDATE `guests` SET `name` = ?, `email` = ?, `guestListId` = ? WHERE `id` = ?";
        $stmt = $this->conn->prepare($sql);
        
        if ($stmt) {
            // Sanitize input data
            $data->name = htmlspecialchars($data->name);
            $data->email = filter_var($data->email, FILTER_SANITIZE_EMAIL);
            $data->guestListId = (int)$data->guestListId;

            $stmt->bind_param("ssii", $data->name, $data->email, $data->guestListId, $data->id);
            $result = $stmt->execute();
            $stmt->close();
            return $result;
        } else {
            echo "Error: " . $this->conn->error;
            return false;
        }
    }
    

    public function deleteGuest($id) {
        $stmt = $this->conn->prepare("DELETE FROM `guests` WHERE `id` = ?");
        if ($stmt) {
            $stmt->bind_param("i", $id);
            $result = $stmt->execute();
            $stmt->close();
            return $result;
        } else {
            echo "Error: " . $this->conn->error;
            return false;
        }
    }
}
?>
