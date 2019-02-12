$(document).ready(function() {
    $('.new-event-item').on('click', function() {
        if ($(this).hasClass('selected')) {
            return;
        }
        $('.new-event-item').removeClass('selected');
        $(this).addClass('selected');
    });

    $('.agent-name').on('click', function() {
        console.log('clicked');
        showSearchAgentWindow();
    });

    $('.agent-item').on('click', function() {
        var agentID = $(this).attr('data-agent-id');
        var agentName = $(this).attr('data-agent-name');
        $('.new-event-item.selected .agent-id').val(agentID);
        $('.new-event-item.selected .agent-name').html(agentName);
        hideSearchAgentWindow();
        return agentID;
    });

    $('.new-events-container').on('submit', function(e) {
        e.preventDefault();
        if ($('.agent-id').val() == "") {
            console.log('canceled');
            alert('지휘요원을 선택하세요.');
            return;
		}
		
		// 기타 이벤트 선택 시 이벤트 이름 입력란이 비어있으면 실패
		if (Number(document.querySelector('.event-type').value) === 9) {
			if (document.querySelector('.etc-event-name').value === "") {
				alert('기타 이벤트명을 입력하세요.')
				return
			}
		}

        $.ajax({
    		url: '/ajax-php/add-agent-event.php',
    		type: 'POST',
    		data: $(this).serialize(),
    		success: function(data) {
                if (data) {
                    alert(data);
                } else {
                    alert('정상적으로 추가되었습니다.');
                    location.reload();
                }
    		},
    		error: function(error) {

    		},
    		complete: function() {

    		}
    	});
    });

    // 지휘요원 이벤트 삭제
    $('.item .delete').on('click', function() {
        var eventID = $(this).parent().get(0).getAttribute('data-event-id');
        console.log(eventID);
        if (!confirm('삭제하시겠습니까?')) {
            console.log('canceled');
            return;
        }

        $.ajax({
            url: '/ajax-php/remove-agent-event.php',
            type: 'post',
            data: { event_id: eventID },
            success: function(data) {
                if (data) {
                    alert(data);
                } else {
                    location.reload();
                }
            }
        })
    });
});
