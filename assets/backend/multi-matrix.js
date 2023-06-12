$(document).ajaxSuccess(function() { $('.ajax-loading').show();$( ".loadingoverlay").remove();});
$(document).ajaxSend(function() { $('.ajax-loading').show();});
$( document ).ajaxStop(function() { $( ".ajax-loading").hide();$( ".loadingoverlay").remove(); });
$(document).on('click', '.ajax_form_submit', function(e) {
	e.preventDefault();
	var n = $(this).closest("form");
	var form_id= $(this).closest('form').attr('id');
	var r = new FormData($("#"+form_id)[0]);
	$.ajax({
		url: n.attr('action'),
		cache: false,
		async:true,
		type: n.attr('method'),
		dataType: "json",
		xhrFields: {
			withCredentials: true
			},
		contentType: false,
		cache: false,
		processData: false,
		data:r,
		success: function(response) {
			updateprocessJson(response);
			$( ".ajax-loading").hide();
		}
	});
});

function updateprocessJson(data) {
    if (data.status == 'info') {
		toastr.info(data.message);
		if (data.redirect !== 'undefined' && data.redirect == 'yes'){
			if (typeof data.url !== 'undefined' && data.url != '') { window.location.href = data.url;}
		}
    } else if (data.status == 'success') {
		 $("#ajax_form")[0].reset()
		toastr.success(data.message);
		if (data.redirect !== 'undefined' && data.redirect == 'yes'){
			if (typeof data.url !== 'undefined' && data.url != '') { window.location.href = data.url;}
		}
    } else if (data.status == 'error') {
		toastr.error(data.message);
		if (data.redirect !== 'undefined' && data.redirect == 'yes'){
			if (typeof data.url !== 'undefined' && data.url != '') { window.location.href = data.url;}
		}
    } else {
    }
}