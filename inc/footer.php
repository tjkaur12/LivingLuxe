<footer>
    <div class="footer-wrapper">
        <div class="footer-col">
            <h4>About Living Luxe</h4>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum</p> 
        </div>
        <div class="footer-col">
            <h4>Quick Links</h4>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="about.php">About Us</a></li>
                <li><a href="shop.php">Shop</a></li>
                <li><a href="contact.php">Contact Us</a></li>
            </ul>
        </div>
        <div class="footer-col">
            <h4>Our Social Connect</h4>
            <ul>
                <li><b>Address</b> - 313 Oakstreet, brantford, Ontario, Canada, N3T 078</li>
                <li><b>Phone</b> - <a href="tel:1234567890">(123)-456-7890</a></li>
                <li><b>Email</b> - <a href="mailto:info@livingluxe.com">info@livingluxe.com</a></li>
            </ul>
        </div>
    </div>
    <div class="copyright">© 2023 Living Luxe | All Right Reserved</div>
</footer>
<div id="popup-message" style="display:none; position:fixed; top:121px; right:20px; background-color:#4CAF50; color:white; padding:10px; border-radius:5px;">
  The product has been added to your cart.
</div>

<script>
$(document).ready(function() {
    $('#add-to-cart-form').submit(function(event) {
        event.preventDefault();
        var formData = $(this).serialize();
        $.ajax({
            url: 'add_to_cart.php',
            type: 'POST',
            data: formData,
            success: function(response) {
                try {
                    var data = JSON.parse(response);
                    if (data.success) {
                        var popup = document.getElementById('popup-message');
                        popup.style.display = 'block';
                        setTimeout(function() {
                            popup.style.display = 'none';
                        }, 3000);

                        $('#cart-count').html('(' + data.cart_count + ')');
                    } else {
                        alert(data.message);
                    }
                } catch (e) {
                    console.error('Error parsing JSON response:', e);
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX Error:', error);
            }
        });
    });
});
</script>
</body>
</html>
