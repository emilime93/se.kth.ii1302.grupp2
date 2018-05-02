<main>
    <section id="banner">
        <h2>Currently displayed Message</h2>
        <p>Hej hej monika hej på dig monika!</p>
    </section>
    <section>
        <h2>Saved Messages</h2>
        <div class="message">
            <p>Jag VABBAR</p>
        </div>
        <div class="message">
            <p>Fast i Trafik</p>
        </div>
        <div class="message">
            <p>Skolkar (hehe)</p>
        </div>
        <?php 
            // require_once('controller/message_controller.php');
            // $obj = new MessageController();
            // echo($obj->getABC);
        ?>
        <textarea form="save_message_form" name="text" id="" cols="30" rows="10"></textarea>
        <form id="save_message_form" action="util/post_handler.php" method="POST">
			<input type="text" name="time_to_live" placeholder="Time to live (seconds)">
			<button type="submit" name="submit" value="save">Save message</button>
        </form>
        <?php
            if(isset($_SESSION['save_message_success'])) {
                if($_SESSION['save_message_success']) {
                    echo '<p class="success">Message successfully saved!</p>';
                    unset($_SESSION['save_message_success']);
                } else {
                    echo '<p class="error">Error saving message</p>';
                }
            }
        ?>
    </section>

    <section>
        <h2>Enter Message</h2>
        <textarea placeholder="Message to display" form="enter_message_form" name="message" cols="30" rows="10"></textarea>
        <form id="enter_message_form" action="util/post_handler.php" method="POST">
			<button type="submit" name="submit" value="send">Send message</button>
        </form>
    </section>
</main>