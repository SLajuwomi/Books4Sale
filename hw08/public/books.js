$(document).ready(function(){
	$("#update").click(function(){
		location.reload(true);
	});

	function myFunction() {
		var popup = document.getElementById("myPopup");
		popup.classList.toggle("show");
		console.log(popup);
	  }
	  

	$("#books4sale").on("click", "div.content", function() {
        let section= $(this).parent();

		let bid= section.attr("id").substr(4);
		let csrf_token= $("#csrftok").val();

		$.post("bookdetail.php", { book_id: bid , csrftok: csrf_token }, function(data) {
			if (data=='error') return;
			section.append(data);
			$("#bookdetail").html(data);
            console.log(data);
			myFunction();
        });



		$(document).on("click", "#delete-button .clickdelete", function() {

			console.log(bid);
			$.post("delete-book.php", { book_id: bid , csrftok: csrf_token }, function(data) {

				var bookdelete = document.getElementById("bid_"+bid);

				bookdelete.remove();

			});
		 });
		
	 });


	 

	
	 $(document).on("click", function(event) {
		var popup = document.getElementById("myPopup");
		if (!!popup){
			if (event.target != popup && !popup.contains(event.target)) {
				popup.classList.remove("show");
			}
		}
	 });
});
