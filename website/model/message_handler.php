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
            $result_string = $result_string . '<form action="util/post_handler.php" method="POST" class="clearfix">';
            $result_string = $result_string . '<input type="hidden" name="comment-id" value="' . $message->get_ID() . '">';
            $result_string = $result_string . '<button id="delete-button" type="submit" value="delete-saved" name="submit">';
            $result_string = $result_string . 'Delete';
            $result_string = $result_string . '</button>';
            $result_string = $result_string . '<button id="send-saved-button" type="submit" value="send-saved" name="submit">';
            $result_string = $result_string . 'Send';
            $result_string = $result_string . '</button>';
            $result_string = $result_string . '</form>';
            $result_string = $result_string . '</div>';
        }
        return $result_string;
    }
}