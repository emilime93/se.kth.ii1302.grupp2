<main>
    
    <section class="clearfix" id="banner">
        <h2>Currently displayed Message</h2>
		<?php
			require_once($_SERVER['DOCUMENT_ROOT'].'/controller/message_controller.php');
            $msg_controller = new MessageController();
			$result = $msg_controller->get_display_message();
			if ($result) {
				echo "<p>" . $result->get_text() . "</p>";
			} else {	// no message displayed atm
				echo "<p>Currently no message displayed!</p>";
			}
		?>
        <form id="erase-message-form" action="util/post_handler.php" method="POST">
			<button id="erase-button" type="submit" name="submit" value="erase">Erase Message</button>
        </form>
    </section>

    <section>
        <h2>Enter Message</h2>
        <textarea placeholder="Message to display" form="enter-message-form" id="enter-message-textarea" name="text" cols="30" rows="10"></textarea>
        <form id="enter-message-form" action="util/post_handler.php" method="POST">
			<input type="text" class="ttl-input" name="time-to-live" placeholder="Time to live (minutes)">
			<button type="submit" name="submit" value="send">Send message</button>
        </form>
        <?php
            if(isset($_SESSION['send_message_length_error'])) {
                echo '<p class="error">'.$_SESSION['send_message_length_error'].'</p>';
                unset($_SESSION['send_message_length_error']);
            }
			if(isset($_SESSION['send_message_ttl_error'])) {
                echo '<p class="error">'.$_SESSION['send_message_ttl_error'].'</p>';
                unset($_SESSION['send_message_ttl_error']);
            }
            if(isset($_SESSION['send_message_success'])) {
                if($_SESSION['send_message_success']) {
                    echo '<p class="success">Message successfully sent!</p>';
                    unset($_SESSION['send_message_success']);
                } else {
                    echo '<p class="error">Error sending message.</p>';
					unset($_SESSION['send_message_success']);
                }
            }
        ?>
    </section>
    
    <!-- Saved Messages Section -->
    <section>
        <h2>Saved Messages</h2>
        <?php 
            if(isset($_SESSION['send_saved_message_success'])) {
                if($_SESSION['send_saved_message_success']) {
                    echo '<p class="success">Message successfully sent!</p>';
                    unset($_SESSION['send_saved_message_success']);
                } else {
                    echo '<p class="error">Error sending message.</p>';
                    unset($_SESSION['send_saved_message_success']);
                }
            }
            
            require_once($_SERVER['DOCUMENT_ROOT'].'/model/message_handler.php');
            $msg_handler = new MessageHandler();
            echo($msg_handler->print_saved_messages());

        ?>
        <textarea placeholder="Enter message to save" form="save-message-form" name="text" id="save-message-textarea" cols="30" rows="10"></textarea>
        <form id="save-message-form" action="util/post_handler.php" method="POST">
			<input type="text" class="ttl-input" name="time-to-live" placeholder="Time to live (minutes)">
			<button type="submit" name="submit" value="save">Save message</button>
        </form>
        <?php
            if(isset($_SESSION['save_message_length_error'])) {
                echo '<p class="error">'.$_SESSION['save_message_length_error'].'</p>';
                unset($_SESSION['save_message_length_error']);
            }
			if(isset($_SESSION['save_message_ttl_error'])) {
                echo '<p class="error">'.$_SESSION['save_message_ttl_error'].'</p>';
                unset($_SESSION['save_message_ttl_error']);
            }
            if(isset($_SESSION['save_message_success'])) {
                if($_SESSION['save_message_success']) {
                    echo '<p class="success">Message successfully saved!</p>';
                    unset($_SESSION['save_message_success']);
                } else {
                    echo '<p class="error">Error saving message</p>';
					unset($_SESSION['send_message_success']);
                }
            }
            if(isset($_SESSION['erase_saved_message_success'])) {
                if($_SESSION['erase_saved_message_success']) {
                    echo '<p class="success">Message successfully deleted!</p>';
                    unset($_SESSION['erase_saved_message_success']);
                } else {
                    echo '<p class="error">Error deleting message</p>';
					unset($_SESSION['send_message_success']);
                }
            }
            
        ?>
    </section>

</main>