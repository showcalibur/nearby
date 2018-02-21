var ajax_get = function(url, onSuccess, onError, onTimeout, timeout = 15000) {
	var xhr = window.XMLHttpRequest ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP')
	xhr.open('GET', url)
	xhr.onreadystatechange = function() {
		if (xhr.readyState>3 && xhr.status==200 && onSuccess) onSuccess(xhr.responseText)
	}
	xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest')
	xhr.timeout = timeout
	xhr.send()
	return xhr
}

var ajax_post = function(url, data, onSuccess, onError, onTimeout, timeout = 15000) {
	var params = typeof data == 'string' ? data : Object.keys(data).map(
		function(k){ return encodeURIComponent(k) + '=' + encodeURIComponent(data[k]) }
	).join('&')
	var xhr = window.XMLHttpRequest ? new XMLHttpRequest() : new ActiveXObject("Microsoft.XMLHTTP")
	xhr.open('POST', url)
	xhr.onreadystatechange = function() {
		if (xhr.readyState>3 && xhr.status==200 && onSuccess) onSuccess(xhr.responseText)
	}
	xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest')
	xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded')
	xhr.timeout = timeout
	xhr.send(params)
	return xhr
}

var ajax_put = function(url, data, onSuccess, onError, onTimeout, timeout = 15000) {
	var params = typeof data == 'string' ? data : Object.keys(data).map(
		function(k){ return encodeURIComponent(k) + '=' + encodeURIComponent(data[k]) }
	).join('&')
	var xhr = window.XMLHttpRequest ? new XMLHttpRequest() : new ActiveXObject("Microsoft.XMLHTTP")
	xhr.open('PUT', url)
	xhr.onreadystatechange = function() {
		if (xhr.readyState>3 && xhr.status==200 && onSuccess) onSuccess(xhr.responseText)
	}
	xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest')
	xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded')
	xhr.timeout = timeout
	xhr.send(params)
	return xhr
}

var ajax_delete = function(url, onSuccess, onError, onTimeout, timeout = 15000) {
	var xhr = window.XMLHttpRequest ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP')
	xhr.open('DELETE', url)
	xhr.onreadystatechange = function() {
		if (xhr.readyState>3 && xhr.status==200 && onSuccess) onSuccess(xhr.responseText)
	}
	xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest')
	xhr.timeout = timeout
	xhr.send()
	return xhr
}
