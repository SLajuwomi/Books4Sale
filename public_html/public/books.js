$(document).ready(function () {
    $("#update").click(function () {
        location.reload(true);
    });

    $("#posted_books").on("click", "div.content", function () {
        let section = $(this).parent();
        $("#posted_books")
            .find(".detail-box")
            .slideUp(function (data) {
                $(this).remove();
            });

        let bid = section.attr("id").substr(4);
        let csrf_token = $('input[name="_token"]').val();
        // alert(bid);
        // alert(csrf_token);
        $.post(
            "bookdetail",
            { book_id: bid, _token: csrf_token },
            function (data) {
                if (data == "error") return;
                section.append(data).hide().slideDown();
            }
        ).fail(function (jqXHR, textStatus, errorThrown) {
            alert("You must be logged in to view book details.");

            console.log("Status: " + textStatus);
            console.log("Error: " + errorThrown);
            console.log("Response Code: " + jqXHR);
        });
    });
});
