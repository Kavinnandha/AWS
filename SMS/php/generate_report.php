<?php

include '../master/config.php';
session_start();

$department_id = $_POST['department'];
$batch_id = $_POST['batch'];
$section_id = $_POST['section'];
$from_date = $_POST['date-from'];
$to_date = $_POST['date-to'];
$academic_year_id = $_POST['academic_year'];
$department_name_detail = 'select name from department where department_id="'.$department_id.'"';
$queryEXE = mysqli_query($connection,$department_name_detail);
$department_name = mysqli_fetch_array($queryEXE)[0];
$query = 'select s.session_id,s.period,c.name,s.topics_covered,s.no_of_absent,s.date_of_session from session s '.
'join mapping_teacher_course mtc on s.new_id=mtc.new_id '.
'join mapping_course_department_batch mcdb on mtc.course_mapping_id=mcdb.course_mapping_id '.
'join course c on c.course_id=mcdb.course_id '.
'join mapping_program_department mpd on mpd.mapping_id=mcdb.mapping_id '.
'where mcdb.batch_id="'.$batch_id.'" and mtc.section_id="'.$section_id.'" and mpd.department_id="'.$department_id.'" and s.academic_year_id="'.$academic_year_id.'"'.
'and s.date_of_session between "'.$from_date.'" and "'.$to_date.'"'.
'order by s.date_of_session,s.period';
$queryEXE = mysqli_query($connection,$query);
$grouped_results = [];
while($row = mysqli_fetch_array($queryEXE)){
	$date = $row['date_of_session'];
	if(!isset($grouped_results[$date])){
		$grouped_results[$date] = [];
	}
	$grouped_results[$date][] = $row;
}
?>

<html>
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <link rel="stylesheet" href="../master/css/dashboard.css">
</head>
<body>
	<div class="container">
	<h1 class="text-center">Log report</h1>
    <h2 class="text-center"><?php echo $department_name ?></h2>
    <h3 class="text-center">Date Range: <?php echo $from_date . " to " . $to_date; ?></h2>

    <?php foreach ($grouped_results as $date => $daily_results){ ?>
        <h4>Date: <?php echo $date; ?></h4>
        <table class="table table-bordered table-striped mb-5">
            <thead>
                <tr>
                    <th scope="col">Period</th>
                    <th scope="col">Subject</th>
                    <th scope="col">Topics Covered</th>
                    <th scope="col">No. of Absent</th>
                    <th scope="col">Absentees name</th>
                </tr>
            </thead>
            <tbody>
		<?php foreach ($daily_results as $row){?>
		<?php
			$query = 'select s.name from student_information s join attendance a on a.register_no=s.register_no where a.session_id="'.$row['session_id'].'" and a.status=0;';
			$queryEXE = mysqli_query($connection,$query);
		?>

                    <tr>
                        <td><?php echo $row['period']; ?></td>
                        <td><?php echo $row['name']; ?></td>
                        <td><?php echo $row['topics_covered']; ?></td>
			<td><?php echo $row['no_of_absent']; ?></td>
			<td><?php
			$column_array = [];
			if($queryEXE->num_rows>0){
				while($row = mysqli_fetch_array($queryEXE)){
					$column_array[] = $row['name'];
				}
			}
			echo implode(", ",$column_array);
			?></td>	
		    </tr>
		<?php } ?>
	    </tbody>
	</table>
<?php } ?>
	</div>

</body>
</html>
