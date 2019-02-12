$(document).ready(function() {
    $('.add-coupon-container').on('click', '.ap-name', function() {
        $('.ap-name').removeClass('current');
        $(this).addClass('current');
        toggleSearchWindow();
    });

    $('.search-result-container').on('click', '.search-result-item', function() {
        var apId = $(this).data('ap-id');
    	var name = $(this).find('.col-search-result-name').html();

        $('.ap-name.current .ap-id-input').val(apId);
        $('.ap-name.current .ap-name-input').html(name);
    });

    $('.add-single').on('click', function() {
        var itemOrg = document.querySelector('.add-coupon-item');
        var itemCpy = itemOrg.cloneNode();
        itemCpy.innerHTML = itemOrg.innerHTML;
        document.querySelector('.add-coupon-container').appendChild(itemCpy);
    });
});
