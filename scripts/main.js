$(document).ready(function() {

	var request = $.ajax({
		url: 'includes/ajax.php',
		method: 'POST',
		data: { requestType: 'default' },
		dataType: 'json',
		cache: false,
		error: function(error) {
			console.log(error);
		}
	});

	// display entire catalog on startup
	request.done(function(data) {
		$("#catalog").html("");
		data.forEach(function(value, index) {
			var element = formatEntry(value.title, value.releasedate,
				value.developer.sort(), value.tags.sort(), value.img);
			$("#catalog").append(element);
		});
	});

	// live searching for all search fields
	$(".searchField").keyup(function(){
		// grab search terms in all fields
		var searchTitle = $('.searchField[name=title]').val(),
			searchDevs = $('.searchField[name=developer]').val(),
			searchTags = $('.searchField[name=tags]').val(),
			searchYear = $('.searchField[name=year]').val();

		// if all search fields are empty, show entire catalog
		// else show catalog according to search terms
		if (searchTitle == '' && searchDevs == '' && searchTags == ''
			&& searchYear == '') {
			$type = 'default';
		}
		else {$type = 'search'}

		// ajax call
		var request = $.ajax({
			url: 'includes/ajax.php',
			method: 'POST',
			data: { requestType: $type, title: searchTitle, devs: searchDevs,
				tags: searchTags, year: searchYear },
			dataType: 'json',
			cache: false,
			error: function(error) {
				console.log(error);
			}
		});

		// call done
		request.done(function(data) {
			// clear existing entries in catalog
			$("#catalog").html("");
			
			// show no results for empty data
			if (data == null || data.length == 0) {
				$("#catalog").append("<span class='noresult'>No results for those terms.</span>")
			}
			else {
				// format returned games
				Object.keys(data).forEach(function(value, index) {
					var element = formatEntry(data[value].title, data[value].releasedate,
						data[value].developer.sort(), data[value].tags.sort(), data[value].img);
					$("#catalog").append(element);
				});
			}
		});	
	});

	$("#sort").change(function() {
		// retrieve all entries in catalog
		var request = $.ajax({
			url: 'includes/ajax.php',
			method: 'POST',
			data: { requestType :'default' },
			dataType: 'json',
			cache: false,
			error: function(error) {
				console.log(error);
			}
		});

		request.done(function(data) {
			// clear existing entries in catalog
			$("#catalog").html("");
			
			// determine sort method and generate new, sorted array of games
			var sortType = $("#sort select").val();
			var sortedArray = new Array();
			switch(sortType) {
				// default
				case 'default':
					data.forEach(function(value, index) {
						sortedArray.push(value);
					});
					break;
				
				// sort alphabetically by title
				case 'title':
					var titles = new Array();
					var keyVal = new Array();
					data.forEach(function(value, index) {
						titles.push(value.title);
						keyVal[value.title]=value;
					});
					
					titles.sort();
					titles.forEach(function(value) {
						sortedArray.push(keyVal[value]);
					})
					break;

				// sort alphabetically by developer
				case 'developer':
					var devs = new Array();
					var keyVal = new Array();
					data.forEach(function(value, index) {
						devs.push(value.developer.sort()[0]);
						keyVal[value.developer.sort()[0]]=value;
					});

					devs.sort();
					devs.forEach(function(value) {
						sortedArray.push(keyVal[value]);
					})
					break;

				case 'date':
					var years = new Array();
					var keyVal = new Array();
					data.forEach(function(value, index) {
						years.push(value.releasedate);
						if (keyVal[value.releasedate]==null) {
							keyVal[value.releasedate]= new Array();
						}
							keyVal[value.releasedate].push(value);
					});

					years.sort();
					years = removeDupes(years);
					years.forEach(function(value) {
						keyVal[value].forEach(function(val2) {
							sortedArray.push(val2);
						});
					})
					break;
			}
			// take new sorted entries, format, and put in catalog
			sortedArray.forEach(function(value, index) {
				var element = formatEntry(value.title, value.releasedate,
					value.developer.sort(), value.tags.sort(), value.img);
				$("#catalog").append(element);
			});
		});
	});

	// toggle visibility of add entry modal on button click
	$("#add_entry").click(function() {
		$("#add_modal").slideToggle(400);
	});

});

window.onload = function() {
    $(".thumbnail > img").each(function() {
        var aspectRatio = ($(this).width())/($(this).height());
        console.log('here');
        if(aspectRatio > 1) {
            // Image is landscape
            $(this).css({"height": "100%"});
        } else if (aspectRatio < 1) {
            // Image is portrait
            $(this).css({"width": "100%"});
        } else {
            // Image is square
            $(this).css({"width": "100%", "height": "100%"});            
        }
    });
};


// function to convert game object to HTML
function formatEntry(title, date, devs, tags, thumbpath) {
	var element = "<div class='entry'>";
	element += "<div class='thumbnail'><img src='" + 
		thumbpath + "' alt='" + title + "'></div>";
	element += "<div class='label'><img src='img/boxtop1.png'><div class='gameinfo'>";
	element += "<div class='title'>" + title + "</div>";
	element += "<div class='devs'>";
	for (i = 0; i < devs.length; i++) {
		if (i == devs.length-1) {
			element += devs[i] + "</div>";
		}
		else {
			element += devs[i] + ", ";
		}
	}
	element += "<div class='date'>" + date + "</div>";
	element += "<div class='taglist'>"
	for (i = 0; i< tags.length; i++) {
		element += "<div class='tag'>" + tags[i] + "</div>";
	}
	element += "</div></div><img src='img/boxbottom1.png'></div><div>";
	return element;
}

// function to remove duplicate entries in an array
function removeDupes(array) {
	var unique = new Array();
	$.each(array, function(index, value) {
		if ($.inArray(value,unique) === -1) {unique.push(value);}
	})
	return unique;
}