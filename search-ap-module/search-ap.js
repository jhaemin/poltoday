// Searching friends
$('.search-input').on('keyup', function(e) {

    // Search when user stops typing for 0.3 sec
    clearTimeout(this.wait);

    var name = $(this).val(); // Get input value from the input field
    if (name == '') {
        $('.search-result-container').empty();
        return; // Exit function when input is empty.
    }
    var serializedData = 'ap_name_search=' + name;

    this.wait = setTimeout(function() {
        $.ajax({
    		url: '/search-ap-module/search-ap.php',
    		type: "post",
    		data: serializedData,

    		success: function(data){
                console.log(data);
    		    var result = JSON.parse(data);
    		    $('.search-result-container').empty();
    		    $.each(result, function(i, ap) {
    		     	// console.log(friend['name'] + ', ' + friend['stat']);
    		     	var platoonDisplay;
                    if (Number(ap['platoon']) === 0) {
                        platoonDisplay = '본부소대';
                    } else {
                        platoonDisplay = ap['platoon'] + '소대';
                    }

    		        $('.search-result-container').append('<div class="search-result-item" data-ap-id="' + ap['id'] + '"><div class="col col-search-result-name">' + ap['name'] + '</div><div class="col col-search-result-platoon">' + platoonDisplay + '</div><div class="col col-search-result-level">' + ap['level'] + '기' + '</div></div>');
    		    });
    	    },
    		error: function(error) {

    		},
    		complete: function() {

    		}
    	});
    }, 200);
});

$('.search-module-bg').on('click', function() {
    toggleSearchWindow();
});

function toggleSearchWindow() {
    var $w = $('#search-ap-module');
    if ($w.hasClass('hidden') && !$w.hasClass('active')) {
        $w.removeClass('hidden');

        setTimeout(function() {
            $w.addClass('active');
        }, 0);

        $('.search-input').focus();
    } else if ($w.hasClass('active') && !$w.hasClass('hidden')) {
        $w.removeClass('active');

        setTimeout(function() {
            $w.addClass('hidden');
        }, 500);

        $('.search-input').val('');
        $('.search-result-container').empty();
    }
}

function closeSearchWindow() {
    var $w = $('#search-ap-module');
    $w.removeClass('active');

    setTimeout(function() {
        $w.addClass('hidden');
    }, 500);

    $('.search-input').val('');
    $('.search-result-container').empty();
}


// Close search window
$(window).on('keyup', function(e) {
    if (e.which === 27) {
        closeSearchWindow();
    }
});

$('.search-result-container').on('click', '.search-result-item', function() {
    toggleSearchWindow();
})
