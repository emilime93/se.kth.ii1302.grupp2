<?php
class MessageHandler {

    /**
     * This returns a HTML string of all messages
     */
    function print_saved_messages() {
        require_once($_SERVER['DOCUMENT_ROOT'] . "/controller/message_controller.php");
        require_once($_SERVER['DOCUMENT_ROOT']."/model/message_model.php");
        $controller = new MessageController();
        $messages = $controller->get_saved_messages();

        $result_string = "";
        foreach($messages as $message) {
            $result_string = $result_string . '<div class="message">';
            $result_string = $result_string . '<p>' . $message->get_text() . '</p>';
            $result_string = $result_string . '</div>';
        }
        return $result_string;
        /*
        <div class="message">
            <p>Skolkar (hehe)</p>
        </div>
        */
    }
}