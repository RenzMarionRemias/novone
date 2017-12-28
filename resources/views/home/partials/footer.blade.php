<!--
<div class="footer-section">
    <div class="first-footer">
        <div class="container">
            <div class="first-footer-content">
                <div class="row">
                    <div class="text-center col-md-4">
                        <p class="first-footer-title">Quick Inquiry :</p>
                        <p class="quick-contact-content">
                            <i class="fa fa-phone-square phone-icon" aria-hidden="true"></i>&nbsp;&nbsp;TEL.NO: +63-2-425-7356
                        </p>
                        <p class="quick-contact-content">
                            <i class="fa fa-phone-square phone-icon" aria-hidden="true"></i>&nbsp;&nbsp;MOBILE.NO: +63-916-213-0538
                        </p>
                        <p class="quick-contact-content">
                            <i class="fa fa-envelope" aria-hidden="true"></i>&nbsp;&nbsp;novone.company@gmail.com</p>
                        <p class="quick-contact-content">
                            <i class="fa fa-address-card" aria-hidden="true"></i>&nbsp;&nbsp;8 Calle Fabrica St., Malhacan, Meycauayan, Bulacan, Philippines.</p>
                    </div>
                    <div class="text-center col-md-4">
                        <p class="first-footer-title">Follow Us At :</p>
                        <button type="button" class="btn btn-default btn-lg social-media-btn">
                            <i class="fa fa-facebook-square" aria-hidden="true"></i>
                        </button>
                    </div>
                    <div class="text-center col-md-4 email-updates-section">
                        <p class="first-footer-title">Email Updates :</p>
                        <div class="form-group">
                            <input type="text" class="input-md form-control email-input" name="" placeholder="Your Email Address Here..">
                        </div>
                        <div class="form-group">
                            <button type="button" class="btn btn-default btn-md submit-btn">Submit</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
-->
<!--

<div class="second-footer">
    <div class="second-footer-content">
        <div class="text-center">
            <p class="novone-copyright">Copyright © NOVONE Chemical Providers Corp. 2017</p>
        </div>
    </div>
</div>
-->

<script src="/novone/public/assets/animate-scroll/animatescroll.js"></script>
<script src="/novone/public/assets/jquery-visible-master/jquery.visible.js"></script>
<script src="/novone/public/assets/jquery-pause/jquery.pause.js"></script>
<script src="/novone/public/assets/js/index.js"></script>
<script src="/novone/public/plugins/dropify/js/dropify.min.js"></script>
<script src="/novone/public/plugins/jquerysteps/jquery.steps.min.js"></script>
<script src="/novone/public/assets/js/users.js"></script>

<!-- PRODUCTS -->
<script defer>

    $(document).ready(function () {
        $(".sub > a").click(function () {
            var ul = $(this).next(),
                clone = ul.clone().css({ "height": "auto" }).appendTo(".mini-menu"),
                height = ul.css("height") === "0px" ? ul[0].scrollHeight + "px" : "0px";
            clone.remove();
            ul.animate({ "height": height });
            return false;
        });
        $('.mini-menu > ul > li > a').click(function () {
            $('.sub a').removeClass('active');
            $(this).addClass('active');
        }),
            $('.sub ul li a').click(function () {
                $('.sub ul li a').removeClass('active');
                $(this).addClass('active');
            });
    });

    $(function () {
        $("#slider-range").slider({
            range: true,
            min: 0,
            max: 1000,
            values: [190, 728],
            slide: function (event, ui) {
                $("#amount").val("$" + ui.values[0] + " - $" + ui.values[1]);
                var mi = ui.values[0];
                var mx = ui.values[1];
                filterSystem(mi, mx);
            }
        });
        $("#amount").val("$" + $("#slider-range").slider("values", 0) +
            " - $" + $("#slider-range").slider("values", 1));
    });


    function filterSystem(minPrice, maxPrice) {
        $(".items div.item").hide().filter(function () {
            var price = parseInt($(this).data("price"), 10);
            return price >= minPrice && price <= maxPrice;
        }).show();
    }
</script>


<script>
    // PRODUCTS

    $('.btn-show-product-information').on('click', function () {

        var currentCode = $(this).data('productcode');
        $('#productCode').val(currentCode)
        $('#clientProductCode').text($(this).data('productcode'))
        $('#clientProductName').text($(this).data('productname'))
        $('#clientProductDescription').text($(this).data('description'))
        $('#clientProductPrice').text($(this).data('price'))
        $('#clientProductImage').attr('src', ($(this).data('productimage')))
    });

</script>

<script>
    $("#example-basic").steps({
        headerTag: "h3",
        bodyTag: "section",
        transitionEffect: "slideLeft",
        autoFocus: true
    });
</script>


<script>
    // ORDER CART //

    $('#paymentMethod').on('change', function () {
        $('#paymentMethodLabel').text($(this).val());
    });

    function computeTotalPrice(){
        var totalPrice = 0;
        $('td.price-subtotal span').each(function(i, obj) {
            totalPrice = totalPrice + parseInt($(obj).text())
        });
        $('#orderTotalPrice span').text(totalPrice)
    }


    $('.cart-product-price').on('change', function () {
       
        var nextElement = $(this).next();
        var productObject = JSON.parse($('#' + nextElement.attr('id') + 'Object').val());
        $('#' + nextElement.attr('id') + '-cell').text($(this).val());
        $('#' + nextElement.attr('id') + '-total-cell span').text($('#' + nextElement.attr('id')).val() * $(this).val());
        productObject.quantity = $(this).val();
        $('#' + nextElement.attr('id') + 'Object').val(JSON.stringify(productObject))
        console.log($('#' + nextElement.attr('id') + 'Object').val());
        // -------------------------- //
        computeTotalPrice();
    });


    computeTotalPrice();





</script>
</body>

</html>