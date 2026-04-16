<section class="seccionContact">
    <h2>Contact</h2>
    <form action="">
        @csrf
        <div class="formLabel">
            <label for="name">Name</label>
            <input placeholder="Roger" type="text" id="name" name="name" required>
        </div>
        <div class="formLabel">
            <label for="subject">Subject</label>
            <input placeholder="info" type="text" id="subject" name="subject" required>
        </div>
        <div class="formLabel">
            <label for="email">Email</label>
            <input placeholder="example@email.com" type="email" id="email" name="email" required>
        </div>
        <div class="formLabel textarea">
            <label for="message">Message</label>
            <textarea id="message" name="message" required></textarea>
        </div>
        <div class="formLabel">
            <button type="submit">Send</button>
        </div>
    </form>
</section>