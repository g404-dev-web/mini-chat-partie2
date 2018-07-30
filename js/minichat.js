function storeMessage(event, form) {
    let $form = $(form);
    let $button = $form.find("button");
    if(!$button.data('originalText')) {
        $button.data('originalText', $button.text())
    }
    let $originalButtonText = $button.data('originalText');

    event.preventDefault();

    let requestData = $form.serialize();

    $.post({
        url: $form.attr( 'action' ),
        data: requestData,
        success: function(error) {
            if(error) {
                console.log("storeMessage Error", error);
                $button.text("❌");
            }
            else {
                $button.text("✔");
            }
            setTimeout(function () {
                $button.text($originalButtonText);
            }, 1000);
        }
    });

    document.getElementById('message').value = "";
}

setInterval(function() {
    $.get('partials/messages.php', function(htmlMessages) {
        $('#messages').html(htmlMessages);

        window.scrollTo(0, 9999);
    });
}, 2000);


window.scrollTo(0, 9999);