<?php
include_once "Models/GuestList.php";
include_once "Controllers/Controller.php";

class GuestListController extends Controller {
    function route() {
        $action = isset($_GET['action']) ? $_GET['action'] : "list";
        $id = isset($_GET['id']) ? intval($_GET['id']) : -1;
        switch ($action) {
            case "list":
                $this->list();
                break;
            case "create":
                $this->render("GuestList", "create", []);
                break;
            case "store":
                $this->storeGuestList();
                break;
            case "edit":
                $this->editGuestList($id);
                break;
            case "update":
                $this->updateGuestList();
                break;
            case "delete":
                $this->deleteGuestList($id);
                break;
            default:
                $this->list();
                break;
        }
    }

    private function list() {
        $model = new GuestList();
        $guestLists = $model->list();
        $this->render("GuestList", "list", ["guestLists" => $guestLists]);
    }

    private function storeGuestList() {
        $eventId = filter_input(INPUT_POST, 'eventId', FILTER_SANITIZE_NUMBER_INT);

        if (!$eventId) {
            echo "Event ID is required.";
            return;
        }

        $model = new GuestList();
        if ($model->createGuestList((object) ['eventId' => $eventId])) {
            // Redirect to the list of guest lists
            header("Location: /PracticeProject/guestlist/list");
            exit;
        } else {
            echo "Failed to create guest list.";
        }
    }

    private function editGuestList($id) {
        if ($id < 0) {
            echo "Invalid ID.";
            return;
        }

        $model = new GuestList($id);
        $this->render("GuestList", "edit", ["guestList" => $model]);
    }

    private function updateGuestList() {
        $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
        $eventId = filter_input(INPUT_POST, 'eventId', FILTER_SANITIZE_NUMBER_INT);

        if (!$id || !$eventId) {
            echo "ID and Event ID are required.";
            return;
        }

        $model = new GuestList($id);
        if ($model->updateGuestList((object) ['id' => $id, 'eventId' => $eventId])) {
            // Redirect to the list of guest lists
            header("Location: /PracticeProject/guestlist/list");
            exit;
        } else {
            echo "Failed to update guest list.";
        }
    }

    private function deleteGuestList($id) {
        if ($id < 0) {
            echo "Invalid ID.";
            return;
        }

        $model = new GuestList();
        if ($model->deleteGuestList($id)) {
            // Redirect to the list of guest lists
            header("Location: /PracticeProject/guestlist/list");
            exit;
        } else {
            echo "Failed to delete guest list.";
        }
    }
}
?>
