// sayit.js
$(document).ready(function () {
    $("#update").click(function () {
        location.reload(true);
    });

    $("#beensaid").on("click", "div.content", function () {
        let section = $(this).parent();
        $("#beensaid")
            .find(".detail-box")
            .slideUp(function (data) {
                $(this).remove();
            });

        let bid = section.attr("id").substr(4);
        let csrf_token = $('input[name="_token"]').val();
        $.post(
            "message_detail",
            { "msg-id": bid, _token: csrf_token },
            function (data) {
                if (data == "error") return;
                section.append(data).hide().slideDown();
            }
        );
    });
});
