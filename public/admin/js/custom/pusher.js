(function ($) {
	"use strict";
	$(document).on("ready", function () {
		$("#test_pusher").on("click", () => {
			axios
				.get(test_pusher)
				.then((response) => {
					if (response.data.status) {
						toastr.success(response.data.message);
					} else {
						toastr.error(response.data.message);
					}
				})
				.catch((error) => {
					console.error("Error triggering event:", error);
					toastr.error("Something went wrong, please try again.");
				});
		});
		$("#check_pusher_credentials").on("click", () => {
			axios
				.get(check_credentials)
				.then((response) => {
					console.log(response);
					const { status, message, error } = response.data;
					if (status) {
						Swal.fire({
							title: "Success",
							text: message,
							icon: "success",
							confirmButtonText: "OK",
						});
					} else if (error) {
						Swal.fire({
							title: "Error",
							text: error,
							icon: "error",
							confirmButtonText: "OK",
						});
					} else {
						Swal.fire({
							title: "Error",
							text: message,
							icon: "error",
							confirmButtonText: "OK",
						});
					}
				})
				.catch((error) => {
					console.error("Error checking Pusher credentials:", error);
					Swal.fire({
						title: "Error",
						text: "Something went wrong, please try again.",
						icon: "error",
						confirmButtonText: "OK",
					});
				});
		});
	});
})(jQuery);
