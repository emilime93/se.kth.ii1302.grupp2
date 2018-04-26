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
    </section>
    <section>
        <h2>Enter Message</h2>
        <form id="enter_message_form" action="../../controller/message_controller.php" method="post"></form>
        <p>Enter Message</p>
        <textarea form="enter_message_form" name="message" id="" cols="30" rows="10"></textarea>
    </section>
</main>