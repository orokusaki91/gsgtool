function defModal(url) {
	$.ajax({
		url: url,
		type: 'get',
		success: function (data) {
			document.getElementById('defModal').innerHTML = data.html;
			document.getElementById('defModal').style.display = 'block';
		}
	});
}

function closeDefModal() {
	document.getElementById("defModal").style.display = "none";
}

function confirmationModal(message, button, url) {
	document.getElementById('message').innerHTML = message;
	document.getElementById('button').innerHTML = button;
	document.getElementById('confirmationModal').style.display = 'block';
	document.getElementById('button').onclick = function () {
		window.location = url;
	};
}

function toDate(dateStr) {
 	var date = dateStr.split("-");
 	return new Date(date[2], date[1] - 1, date[0]);
}

