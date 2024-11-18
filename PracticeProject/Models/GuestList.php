<?php
include_once "Models/Model.php";

class GuestList extends Model {
    public $id;
    public $eventId;

    function __construct($id = -1) {
        parent::__construct(); 

        $this->id = $id;

        if ($id < 0) {
            $this->eventId = "";
        } else {
            $stmt = $this->conn->prepare("SELECT * FROM `guestlists` WHERE id = ?");
            if ($stmt) {
                $stmt->bind_param("i", $id);
                $stmt->execute();
                $result = $stmt->get_result()->fetch_assoc();
                if ($result) {
                    $this->id = $result['id'];
                    $this->eventId = $result['eventId'];
                } else {
                    $this->id = "";
                    $this->eventId = "";
                }
                $stmt->close();
            } else {
                echo "Error occurred: " . $this->conn->error;
            }
        }
    }

    // CRUD Functions

    // Create a new guest list
    public function createGuestList($data) {
        $sql = "INSERT INTO `guestlists` (`eventId`) VALUES (?)";
        $stmt = $this->conn->prepare($sql);
        if ($stmt) {
            // Ensure eventId is an integer
            $data->eventId = (int)$data->eventId;
            $stmt->bind_param("i", $data->eventId);
            $result = $stmt->execute();
            $stmt->close();
            return $result;
        } else {
            echo "Error: " . $this->conn->error;
            return false;
        }
    }

    // List all guest lists 
    public function list() {
        $stmt = $this->conn->prepare("SELECT * FROM `GuestLists`");
        if ($stmt) {
            $stmt->execute();
            $result = $stmt->get_result();
            $guestLists = [];

            while ($row = $result->fetch_assoc()) {
                $guestLists[] = new GuestList($row['id']);
            }
            $stmt->close();
            return $guestLists;
        } else {
            echo "Error: " . $this->conn->error;
            return [];
        }
    }

    // Update an existing guest list
    public function updateGuestList($data) {
        $sql = "UPDATE `guestlists` SET `eventId` = ? WHERE `id` = ?";
        $stmt = $this->conn->prepare($sql);
        if ($stmt) {
            // Ensure eventId and id are integers
            $data->eventId = (int)$data->eventId;
            $data->id = (int)$data->id;
            $stmt->bind_param("ii", $data->eventId, $data->id);
            $result = $stmt->execute();
            $stmt->close();
            return $result;
        } else {
            echo "Error: " . $this->conn->error;
            return false;
        }
    }

    // Delete a guest list
    public function deleteGuestList($id) {
        $sql = "DELETE FROM `guestlists` WHERE `id` = ?";
        $stmt = $this->conn->prepare($sql);
        if ($stmt) {
            // Ensure id is an integer
            $id = (int)$id;
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
