<?php include 'includes/header.php'; ?>
<main>
    <section class="inner-page-header full-wid">
        <div class="wrapper">
            <h1>Frequently Asked Questions</h1>
        </div>
    </section>
    
    <section class="faq-page full-wid">
        <div class="wrapper">
            <div class="faq-page-inner">
                <h1>Frequently Asked Questions</h1>
                <p>Find answers to common questions about property listings, buying, and renting properties.</p>
                
                <div class="faq-section">
                    <div class="faq-item">
                        <button class="faq-question">
                            What is the process for listing my property?
                        </button>
                        <div class="faq-answer">
                            <p>To list your property, sign up for an account, navigate to the 'List Your Property' section, and fill out the required details, including property photos, price, and description. Once submitted, our team will review and approve your listing.</p>
                        </div>
                    </div>

                    <div class="faq-item">
                        <button class="faq-question">
                            How can I search for properties in a specific location?
                        </button>
                        <div class="faq-answer">
                            <p>Use the search bar on our homepage to enter the desired location, or use the filters to refine your search by price, property type, and amenities.</p>
                        </div>
                    </div>

                    <div class="faq-item">
                        <button class="faq-question">
                            Are there any fees for listing or buying a property?
                        </button>
                        <div class="faq-answer">
                            <p>Listing a property may include a small fee depending on the type of listing (basic or premium). Buyers can browse and inquire about properties for free.</p>
                        </div>
                    </div>

                    <div class="faq-item">
                        <button class="faq-question">
                            Can I schedule a property viewing online?
                        </button>
                        <div class="faq-answer">
                            <p>Yes, most property listings include an option to schedule a viewing. You can contact the property owner or agent directly to arrange a convenient time.</p>
                        </div>
                    </div>

                    <div class="faq-item">
                        <button class="faq-question">
                            How do I report an issue with a property listing?
                        </button>
                        <div class="faq-answer">
                            <p>If you notice any incorrect or suspicious information in a listing, click the "Report" button on the listing page and provide the necessary details. Our team will investigate and take action promptly.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
</main>
<script>
// JavaScript for FAQ Accordion
document.querySelectorAll('.faq-question').forEach(button => {
    button.addEventListener('click', () => {
        button.classList.toggle('active');
        const answer = button.nextElementSibling;

        if (button.classList.contains('active')) {
            answer.style.display = 'block';
        } else {
            answer.style.display = 'none';
        }
    });
});
</script>
<?php include 'includes/footer.php'; ?>
