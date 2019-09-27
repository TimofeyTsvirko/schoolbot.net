<?php  
require_once('../config.php');
if($_POST['type']=='searchlessons'){
	$data_missing = array();

	if(empty($_POST['grade'])){
		$data_missing[]='класс';
	}else{
		$grade = trim($_POST['grade']);
	}
	if(empty($_POST['profile'])){
		$data_missing[]='класс';
	}else{
		$profile = trim($_POST['profile']);
	}

	$day = $_POST['day'];

	if(!(empty($data_missing))){
		echo 'Введите следующие данные:</br>';
		foreach ($data_missing as $missing) {
			echo "$missing </br>";
		}

	
	} else {
		$query = "SELECT * FROM schedule where grade='$grade' and profile='$profile' and day='$day' and city='Кемь' and school='МБОУСОШ1'";
		$result = @mysqli_query($dbc,$query);


		$lessons_set = array('Русский', 
									'Математика', 
									'Литература', 
									'Физкультура', 
									'География', 
									'Информатика', 
									'Изо', 
									'Биология', 
									'ОБЖ', 
									'История', 
									'Физика', 
									'Химия', 
									'Биология', 
									'Черчение', 
									'Обществознание ',
									'Иностранный язык ');
		if($result){
			$i=0;
			$schedule_data = array();
			while($row = mysqli_fetch_array($result)){
				$schedule_data[]=$row;
				$i++;
			}
			if($i==0){
				echo '<div class="heading">
						<span>Уроки</span>
						<span>Кабинет</span>
					</div>
					<ol>';

				for ($k=0; $k < 7; $k++) {
					echo "<li><input list='lessons' id='lesson-$k'> <input type='text' id='class-$k'></li>";
				}


				echo '<datalist id="lessons">';
				foreach ($lessons_set as $lesson) {
					echo "<option value='$lesson'></option>";
				}
				
				echo '</datalist>
					</ol>
					<label>Срок:</label>
					<select id="priority">
						<option value="main">Основной</option>
						<option value="1">1 раз</option>
						<option value="2">2 раза</option>
						<option value="3">3 раза</option>
						<option value="4">4 раза</option>
						<option value="5">5 раз</option>
						<option value="6">6 раз</option>
						<option value="7">7 раз</option>
			</select>
			<br>
			<input type="button" value="Сохранить" onclick="SubmitUpdateLessons();">';

		}elseif ($i==1) {
			echo '<div class="heading">
						<span>Уроки</span>
						<span>Кабинет</span>
					</div>
					<ol>';
			$lessons_classes = explode(';', $schedule_data[0][lessons]);
			$k = 0;
			foreach ($lessons_classes as $pair) {
				$pair = explode('_', $pair);
				echo "<li><input list='lessons' id='lesson-$k' value=$pair[0]> <input type='text' id='class-$k' value=$pair[1]></li>";
				$k++;
			}
			echo '<datalist id="lessons">';
				foreach ($lessons_set as $lesson) {
					echo "<option value='$lesson'></option>";
				}
			echo '</datalist>
					</ol>
					<label>Срок:</label>
					<select id="priority">
						<option value="main">Основной</option>
						<option value="1">1 раз</option>
						<option value="2">2 раза</option>
						<option value="3">3 раза</option>
						<option value="4">4 раза</option>
						<option value="5">5 раз</option>
						<option value="6">6 раз</option>
						<option value="7">7 раз</option>
			</select>
			<br>
			<input type="button" value="Сохранить" onclick="SubmitUpdateLessons();">';

		}else{

		}
	}else{
			echo 'Could not issue database query';
			echo mysqli_error($dbc);
		}
	}
}



if($_POST['type']=='updatelessons'){
	$data_missing = array();

	if(empty($_POST['grade'])){
		$data_missing[]='класс';
	}else{
		$grade = trim($_POST['grade']);
	}
	if(empty($_POST['profile'])){
		$data_missing[]='класс';
	}else{
		$profile = trim($_POST['profile']);
	}

	if(!(empty($data_missing))){
		echo 'Введите следующие данные:</br>';
		foreach ($data_missing as $missing) {
			echo "$missing </br>";
		}
	}else{
		$day = $_POST['day'];
		$lessons = $_POST['lessons_string'];
		$priority = $_POST['priority'];
		$time_created = time();

		$query = "SELECT * FROM schedule where grade='$grade' and profile='$profile' and day='$day'";
		$result = @mysqli_query($dbc,$query);

		if($result){
			$i=0;
			while($row = mysqli_fetch_array($result)){
				$i++;
			}
			if($i==0){
				$query="INSERT INTO schedule (city,school,grade,profile,day,lessons,priority,time_created) VALUES ('Кемь','МБОУСОШ1','$grade','$profile','$day', '$lessons','$priority',$time_created)";
				$result = @mysqli_query($dbc,$query);
				if($result){
					echo 'Успешно!';
				}else{
					echo 'Ошибка:';
					echo mysqli_error($dbc);
				}
			}elseif ($priority=='main') {
				// 
				// $query="UPDATE schedule SET lessons=$lessons, "
				// 
			}
		}else{
			echo 'Could not issue database query';
			echo mysqli_error($dbc);
		}

	}
}

mysqli_close($dbc);
  ?>