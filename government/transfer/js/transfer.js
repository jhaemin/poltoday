$(document).ready(function() {
    console.log('ready');
    var markdownWatcher = function(text) {
        // console.log('watching');

        var convertedText = "str";
        var convertedText = text;
        var diff = false;

        convertedText = convertedText.replace(/\[]/g, '<input type="checkbox" />');

        var elm = document.createElement('div');
        elm.innerHTML = convertedText;

        // console.log(elm);

        if (text !== convertedText) {
            diff = true;
        }

        var result = {
            "diff": diff,
            "convertedText": convertedText
        }

        return result;
    };

    // Live markdown update
    $('.diary-contents').on('keyup', function(e) {
        var elm = $(this).get(0);
        var result = markdownWatcher(elm.innerHTML);
        // console.log(result);

        if (result.diff) {
            elm.innerHTML = result.convertedText;
        }
    });

    $('.diary-contents').on('keydown', function(e) {

        if (e.keyCode === 13) {
            var sel = document.getSelection();
            var range = sel.getRangeAt(0);

            // document.execCommand('insertHTML', false, '<br /><br />');

            var br = document.createElement('br');
            range.insertNode(br);
            range.setStartAfter(br);

            return false;
        }
    });
});
