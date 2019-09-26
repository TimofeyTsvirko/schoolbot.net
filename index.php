<?php 




 ?>
<!DOCTYPE html>
<html>
<head>
	<title>SchoolBot</title>
	<link rel="stylesheet" href="style_index.css">
	<script src="jquery.js"></script>
	<script src="submit.js"></script>
</head>
<body>
	<div class="lessons">
		<div class="menu">
			<form class="lessons-form" method="post">
				<ul>
					<li>
						<label>Класс</label>
						<input list="grades" class="search" name="grade" id="grade">
						<!-- How to update this? -->
						<datalist id="grades">
  						</datalist>
					</li>
					<li>
						<label>Профиль</label>
						<input id="profile" type="text" class="search" value="нет" name="profile">
					</li>
					<li>
						<label>День Недели</label>
						<select class="search" name="day" id="day">
							<option value="mon">ПН</option>
							<option value="tue">ВТ</option>
							<option value="wed">СР</option>
							<option value="thu">ЧТ</option>
							<option value="fri">ПТ</option>
							<option value="sat">СБ</option>
							<option value="sun">ВС</option>
						</select>
					</li>
					<li>
						<input type="button" value="Поиск" onclick="SubmitSearchQuery();">
					</li>
				</ul>
			</form>
		</div>
		<form class="schedule">
			
		</form>
		<div class="result"></div>
	</div>
</body>
</html>