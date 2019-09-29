<!DOCTYPE html>
<html>
<head>
	<title>SchoolBot</title>
	<link rel="stylesheet" href="style_index.css">
	<script src="jquery.js"></script>
	<script src="submit.js"></script>
</head>
<body>
<?php 
require_once('../config.php');
 ?>
	<div class="lessons">
		<div class="menu">
			<form class="lessons-form" method="post">
				<ul>
					<li>
						<label>Класс</label>
						<input list="grade_list" class="search" name="grade" id="grade">
						<!-- How to update this? -->
						<datalist id="grade_list">
							<?php 
								$query = 'SELECT distinct grade from schedule where city="Кемь" and school="МБОУСОШ1" ORDER BY grade asc';
								$result = @mysqli_query($dbc, $query);
								if($result){
									while($row = mysqli_fetch_array($result)){
										echo "<option value='$row[0]'></option>";
									}
								}else{
									echo 'Ошибка в получении классов:';
									echo mysqli_error($dbc);
								}
							 ?>
  						</datalist>
					</li>
					<li>
						<label>Профиль</label>
						<input id="profile" list="profile_list" class="search" value="нет" name="profile">
						<datalist id='profile_list'>
							<?php 
								$query = 'SELECT distinct profile from schedule where city="Кемь" and school="МБОУСОШ1"';
								$result = @mysqli_query($dbc, $query);
								if($result){
									while($row = mysqli_fetch_array($result)){
										echo "<option value='$row[0]'></option>";
									}
								}else{
									echo 'Ошибка в получении профилей:';
									echo mysqli_error($dbc);
								}
							 ?>
						</datalist>
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

<?php 
mysqli_close($dbc);
 


 ?>