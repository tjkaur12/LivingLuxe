<?php include 'includes/header.php'; ?>
<?php include 'includes/db.php'; ?>

<main>
    <section class="inner-page-header full-wid">
        <div class="wrapper">
            <h1>Contact Us</h1>
        </div>
    </section>
    <section class="full-wid">
        <div class="wrapper">
            <div class="contactus-inner">
                <div class="contact-box">
                    <span>Let's Talk</span>
                    <h2>Speak With Our Expert Engineers.</h2>
                    <div class="adr-box">
                        <div class="adr-icon">
                            <i class="fa fa-phone"></i>
                        </div>
                        <div class="adr-text">
                            <span class="label">Phone:</span>
                            <a href="tel:(123)-456-7890">+1 (123)-456-7890</a>
                        </div>
                    </div>
                    <div class="adr-box">
                        <div class="adr-icon">
                            <i class="fa fa-home"></i>
                        </div>
                        <div class="adr-text">
                            <span class="label">Email:</span>
                            <a href="mailto:info@techCore.com">info@techCore.com</a>
                        </div>
                    </div>
                    <div class="adr-box">
                        <div class="adr-icon">
                            <i class="fa fa-map-marker"></i>
                        </div>
                        <div class="adr-text">
                            <span class="label">Address:</span>
                            <div class="cdesc">70 Oakstreet, brantford, Ontario, Canada, N3T 078</div>
                        </div>
                    </div>
                </div>
                <div class="contact-form">
                    <span>Get In Touch</span>
                    <h2>Fill The Form Below</h2>
                    <form id="contact-form" action="#">
                        <div class="form-field">
                            <input type="text" id="name" name="name" placeholder="Name">
                            <input type="email" id="email" name="email" placeholder="Email">
                        </div>
                        <div class="form-field">
                            <input type="tel" id="phone" name="phone" placeholder="Phone">
                            <input type="text" id="website" name="website" placeholder="Your Website">
                        </div>
                        <div class="form-field-full">
                            <textarea id="message" name="message" placeholder="Your message Here"></textarea>
                        </div>
                        <div class="form-btn center">
                            <button class="submit" type="submit">Submit Now</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <section class="full-wid map">
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2911.623530163808!2d-80.27720292786525!3d43.13343419669566!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x882c661c6b02a241%3A0x3ad6dc607f45f310!2s70%20Oak%20St%2C%20Brantford%2C%20ON%20N3T%202B1!5e0!3m2!1sen!2sca!4v1701986344503!5m2!1sen!2sca" width="100%" height="500" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
    </section>
</main>

<?php include 'includes/footer.php'; ?>
