<?php
include_once "Models/Model.php";

class Event extends Model {
    public $id;
    public $name;
    public $description;
    public $location;
    public $date;

    function __construct($id = -1) {
        parent::__construct();
    
        $this->id = $id;
        if ($id < 0) {
            $this->name = "";
            $this->description = "";
            $this->location = "";
            $this->date = "";
        } else {
            $stmt = $this->conn->prepare("SELECT * FROM `events` WHERE `id` = ?");
            if ($stmt) {
                $stmt->bind_param("i", $id);
                $stmt->execute();
                $result = $stmt->get_result()->fetch_assoc();
    
                // Debugging Output
                if ($result) {
                    $this->id = $result['id'];
                    $this->name = $result['name'];
                    $this->description = $result['description'];
                    $this->location = $result['location'];
                    $this->date = $result['date'];
                } else {
                    $this->id = null;
                    $this->name = "";
                    $this->description = "";
                    $this->location = "";
                    $this->date = "";
                }
                $stmt->close();
            } else {
                echo "Error occurred: " . $this->conn->error;
            }
        }
    }

    // CRUD FUNCTIONS

    public function createEvent($data) {
        $sql = "INSERT INTO `events` (`name`, `description`, `location`, `date`) VALUES (?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        
        if ($stmt) {
            $data->name = htmlspecialchars($data->name);
            $data->description = htmlspecialchars($data->description);
            $data->location = htmlspecialchars($data->location);
            $data->date = htmlspecialchars($data->date);
            
            $stmt->bind_param("ssss", $data->name, $data->description, $data->location, $data->date);
            $result = $stmt->execute();
            $stmt->close();
            return $result;
        } else {
            echo "Error: " . $this->conn->error;
            return false;
        }
    }

    public function listEvents() {
        $stmt = $this->conn->prepare("SELECT * FROM `events`");
        if ($stmt) {
            $stmt->execute();
            $result = $stmt->get_result();
            $events = [];

            while ($row = $result->fetch_assoc()) {
                $events[] = new Event($row['id']);
            }
            $stmt->close();
            return $events;
        } else {
            echo "Error: " . $this->conn->error;
            return [];
        }
    }

    public function updateEvent($data) {
        $sql = "UPDATE `events` SET `name` = ?, `description` = ?, `location` = ?, `date` = ? WHERE `id` = ?";
        $stmt = $this->conn->prepare($sql);
    
        if ($stmt) {
            $stmt->bind_param("ssssi", $data->name, $data->description, $data->location, $data->date, $data->id);
            $result = $stmt->execute();
            $stmt->close();
            return $result;
        } else {
            echo "<p style='color:red;'>Error: " . $this->conn->error . "</p>";
            return false;
        }
    }
    

    public function deleteEvent($id) {
        $sql = "DELETE FROM `events` WHERE `id` = ?";
        $stmt = $this->conn->prepare($sql);
        
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
