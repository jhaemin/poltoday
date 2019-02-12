function showSearchAgentWindow() {
    $('#search-agent-module').removeClass('hidden');
}

function hideSearchAgentWindow() {
    $('#search-agent-module').addClass('hidden');
}

$(document).ready(function() {
    $('#search-agent-bg').on('click', function() {
        hideSearchAgentWindow();
    });
});
