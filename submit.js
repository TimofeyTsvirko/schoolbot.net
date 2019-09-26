function SubmitSearchQuery(){
	var grade = $("#grade").val();
	var profile = $("#profile").val();
	var day = $("#day").val();
	$.post("submit.php", {type:'searchlessons', grade:grade, profile:profile, day:day}, function(data) {
			$('.schedule').html(data);
	})
}

function SubmitUpdateLessons(){
	var grade = $("#grade").val();
	var profile = $("#profile").val();
	var day = $("#day").val();
	var priority = $('#priority').val();
	
	// document.write(priority);

	var lessons_string = '';
	var lesson = '';
	var cab = '';
	for (var i = 0; i < 6; i++) {
		lesson = $('#lesson-'+i).val().trim();
		cab = $('#class-'+i).val().trim();
		lessons_string+=lesson+'-'+cab+';';
	}
	lesson = $('#lesson-6').val().trim();
	cab = $('#class-6').val().trim();
	lessons_string+=lesson+'-'+cab;
	
	$.post("submit.php", {type:'updatelessons', profile:profile, day:day, priority:priority, lessons_string:lessons_string, grade:grade}, function(data) {
			$('.result').html(data);
	})
}