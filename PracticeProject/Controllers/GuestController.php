<?php
include_once "Models/Guest.php";
include_once "Controllers/Controller.php";

class GuestController extends Controller {
    function route() {
        $action = isset($_GET['action']) ? $_GET['action'] : "list"; // Default action is listing guests
        $id = isset($_GET['id']) ? intval($_GET['id']) : -1;

        switch ($action) {
            case "list":
                $this->listGuests();
                break;
            case "create":
                $this->render("Guest", "create", []);
                break;
            case "store":
                $this->storeGuest();
                break;
            case "edit":
                $this->editGuest($id);
                break;
            case "update":
                $this->updateGuest();
                break;
            case "delete":
                $this->deleteGuest($id);
                break;
            default:
                $this->listGuests();
                break;
        }
    }

    private function listGuests() {
        $model = new Guest();
        $guests = $model->listGuests();
        $this->render("Guest", "index", ["guests" => $guests]);
    }

    private function storeGuest() {
        $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
        $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
        $guestListId = filter_input(INPUT_POST, 'guestListId', FILTER_VALIDATE_INT);

        if (!$name || !$email || !$guestListId) {
            echo htmlspecialchars("All fields are required, and email must be valid.");
            return;
        }

        $model = new Guest();
        if ($model->createGuest((object) [
            'name' => $name,
            'email' => $email,
            'guestListId' => $guestListId
        ])) {
            header("Location: /PracticeProject/guest/list");
            exit;
        } else {
            echo htmlspecialchars("Failed to create guest.");
        }
    }

    private function editGuest($id) {
        if ($id < 0) {
            echo htmlspecialchars("Invalid ID.");
            return;
        }

        $model = new Guest($id);
        if ($model->id === "") {  // Check if the guest was found
            echo htmlspecialchars("Guest not found.");
            return;
        }

        $this->render("Guest", "edit", ["guest" => $model]);
    }
    
    private function updateGuest() {
        $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
        $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
        $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
        $guestListId = filter_input(INPUT_POST, 'guestListId', FILTER_VALIDATE_INT);

        // Validate required fields
        if (!$id || !$name || !$email || !$guestListId) {
            echo htmlspecialchars("All fields are required, and email must be valid.");
            return;
        }

        // Load the guest to check if they exist
        $model = new Guest($id);
        if ($model->id === "") {  // Check if the guest was found
            echo htmlspecialchars("Guest not found.");
            return;
        }

        // Attempt to update the guest
        if ($model->updateGuest((object) [
            'id' => $id,
            'name' => $name,
            'email' => $email,
            'guestListId' => $guestListId
        ])) {
            header("Location: /PracticeProject/guest/list");  // Redirect to the list view after updating
            exit;
        } else {
            echo htmlspecialchars("Failed to update guest.");
        }
    }

    private function deleteGuest($id) {
        if ($id < 0) {
            echo htmlspecialchars("Invalid ID.");
            return;
        }

        $model = new Guest();
        if ($model->deleteGuest($id)) {
            header("Location: /PracticeProject/guest/list");
            exit;
        } else {
            echo htmlspecialchars("Failed to delete guest.");
        }
    }
}
?>
