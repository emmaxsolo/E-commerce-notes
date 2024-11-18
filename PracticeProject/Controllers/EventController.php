<?php
include_once "Models/Event.php";
include_once "Controllers/Controller.php";

class EventController extends Controller {
    public function route() {
        $action = isset($_GET['action']) ? $_GET['action'] : "list"; // Default to list events
        $id = isset($_GET['id']) ? intval($_GET['id']) : -1;

        switch ($action) {
            case "create":
                $this->render("Event", "createEventForm", []);
                break;
            case "createSave":
                $this->createEvent();
                break;
            case "edit":
                $this->editEvent($id);
                break;
            case "editSave":
                $this->editSave($id);
                break;
            case "delete":
                $this->deleteEvent($id);
                break;
            default:
                $this->listEvents();
                break;
        }
    }

    // List events
    private function listEvents() {
        $eventModel = new Event();
        $events = $eventModel->listEvents();
        $this->render("User", "dashboard", ['events' => $events]);
    }

    // Create a new event
    private function createEvent() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
            $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_STRING);
            $location = filter_input(INPUT_POST, 'location', FILTER_SANITIZE_STRING);
            $date = filter_input(INPUT_POST, 'date', FILTER_SANITIZE_STRING);

            $event = new Event();
            $event->name = $name;
            $event->description = $description;
            $event->location = $location;
            $event->date = $date;

            if ($event->createEvent($event)) {
                $lang = $_SESSION['lang'] ?? 'en';
                header("Location: /PracticeProject/{$lang}/event/list");
                exit;
            } else {
                echo "Error creating event.";
            }
        }
    }

    // Edit an event (loads event data into form for editing)
    private function editEvent($id) {
        $eventModel = new Event($id);

        if ($eventModel->id) {
            $this->render("Event", "edit", ['event' => $eventModel]);
        } else {
            $error = "Event with ID $id not found.";
            $this->render("Event", "edit", ['event' => null, 'error' => $error]);
        }
    }

    // Save the edited event
    private function editSave($id) {
        $event = new Event($id);
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && $event->id) {
            // Collect updated data from POST
            $event->name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
            $event->description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_STRING);
            $event->location = filter_input(INPUT_POST, 'location', FILTER_SANITIZE_STRING);
            $event->date = filter_input(INPUT_POST, 'date', FILTER_SANITIZE_STRING);

            if ($event->updateEvent($event)) {
                $lang = $_SESSION['lang'] ?? 'en';
            header("Location: /PracticeProject/{$lang}/event/list");
            exit;
            } else {
                echo "<p style='color:red;'>Error updating event.</p>";
            }
        }
        $this->render("Event", "edit", ['event' => $event]);
    }

    // Delete an event
    private function deleteEvent($id) {
        $eventModel = new Event($id);
        if ($eventModel->deleteEvent($id)) {
            $lang = $_SESSION['lang'] ?? 'en';
            header("Location: /PracticeProject/{$lang}/event/list");
            exit;
        } else {
            echo "Error deleting event.";
        }
    }
}
?>
