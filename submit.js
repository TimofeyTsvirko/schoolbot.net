function SubmitSearchQuery(){
	var grade = $("#grade").val();
	var profile = $("#profile").val();
	var day = $("#day").val();
	$.post("submit.php", {type:'searchlessons', grade:grade, profile:profile, day:day, priority:''}, function(data) {
			$('.schedule').html(data);
	})
}

function SubmitUpdateLessons(){
	var grade = $("#grade").val();
	var profile = $("#profile").val();
	var day = $("#day").val();
	var priority = $('#priority').val();

	var lessons_string = '';
	var lesson = '';
	var cab = '';
	for (var i = 0; i < 6; i++) {
		lesson = $('#lesson-'+i).val().trim();
		cab = $('#class-'+i).val().trim();
		lessons_string+=lesson+'_'+cab+';';
	}
	lesson = $('#lesson-6').val().trim();
	cab = $('#class-6').val().trim();
	lessons_string+=lesson+'_'+cab;
	
	$.post("submit.php", {type:'updatelessons', profile:profile, day:day, priority:priority, lessons_string:lessons_string, grade:grade}, function(data) {
			$('.result').html(data);
	})
}


var k=0;
function SubmitQueryLessonsMultipleOptions(){
	if (k % 2 == 1){
		var grade = $("#grade").val();
		var profile = $("#profile").val();
		var day = $("#day").val();
		var priority = $("#remaining").val();
		$.post("submit.php", {type:'searchlessons', grade:grade, profile:profile, day:day, priority:priority}, function(data) {
			$('.schedule').html(data);
	})
	}
	k++;

}

function DeleteSchedule(){
	var grade = $("#grade").val();
	var profile = $("#profile").val();
	var day = $("#day").val();
	var priority = $('#priority').val();

	$.post("submit.php", {type:'deleteschedule', grade:grade, profile:profile, day:day, priority:priority}, function(data) {
			$('.schedule').html(data);
	})
}

function SubmitBotText(){
	var text = $("#text").val();
	$.post("index.php", {text:text}, function(data) {
			$('.result').html(data);
	})
}