<?php

include '../master/config.php';
session_start();

require_once '../dompdf/autoload.inc.php';

use Dompdf\Dompdf;
use Dompdf\Options;

if(isset($_POST['class_report'])){
    $department_id = $_POST['department'];
    $batch_id = $_POST['batch'];
    $section_id = $_POST['section'];
    $from_date = $_POST['date-from'];
    $to_date = $_POST['date-to'];
    $academic_year_id = $_POST['academic-year'];
    $department_name_detail = 'select name from department where department_id="'.$department_id.'"';
    $queryEXE = mysqli_query($connection,$department_name_detail);
    $department_name = mysqli_fetch_array($queryEXE)[0];
    $query = 'select s.session_id,s.period,c.name,s.topics_covered,s.no_of_absent,s.no_of_present,s.no_of_od,s.date_of_session from session s '.
    'join mapping_teacher_course mtc on s.new_id=mtc.new_id '.
    'join mapping_course_department_batch mcdb on mtc.course_mapping_id=mcdb.course_mapping_id '.
    'join course c on c.course_id=mcdb.course_id '.
    'join mapping_program_department mpd on mpd.mapping_id=mcdb.mapping_id '.
    'where mcdb.batch_id="'.$batch_id.'" and mtc.section_id="'.$section_id.'" and mpd.department_id="'.$department_id.'" and s.academic_year_id="'.$academic_year_id.'"'.
    'and s.date_of_session between "'.$from_date.'" and "'.$to_date.'"'.
    'order by s.date_of_session,s.period';
    $queryEXE = mysqli_query($connection,$query);
    $newFromDate = $from_date;
    $newToDate = $to_date;
    $from_date = date("d-m-Y",strtotime($newFromDate));
    $to_date = date("d-m-Y",strtotime($newToDate));
    $grouped_results = [];
    while($row = mysqli_fetch_array($queryEXE)){
        $date = $row['date_of_session'];
        if(!isset($grouped_results[$date])){
            $grouped_results[$date] = [];
        }
        $grouped_results[$date][] = $row;
    }

$html = generateClassReportHtml($department_name,$from_date,$to_date,$grouped_results);
generatePdf('report.pdf',$html);
}
if(isset($_POST['subject_report'])){
$dropdown_details = explode(",",$_POST['main']);
$batch_id = $dropdown_details[0];
$department_id = $dropdown_details[1];
$course_id = $dropdown_details[2];
$section_id = $dropdown_details[3];
$academic_year_id = $_POST['academic-year'];
$date_from = $_POST['date-from'];
$date_to = $_POST['date-to'];
$get_subject_name = 'select name from course where course_id="'.$course_id.'"';
$queryEXE = mysqli_query($connection,$get_subject_name);
$subject_name = mysqli_fetch_row($queryEXE)[0];
    $query = 'select s.session_id,s.period,(s.no_of_present+s.no_of_absent+s.no_of_od) as total,c.name,s.topics_covered,s.no_of_absent,s.no_of_present,s.no_of_od,DATE_FORMAT(s.date_of_session,"%d-%m-%Y") as date_of_session from session s '.
    'join mapping_teacher_course mtc on s.new_id=mtc.new_id '.
    'join mapping_course_department_batch mcdb on mtc.course_mapping_id=mcdb.course_mapping_id '.
    'join course c on c.course_id=mcdb.course_id '.
    'join mapping_program_department mpd on mpd.mapping_id=mcdb.mapping_id '.
    'where mcdb.batch_id="'.$batch_id.'" and mtc.section_id="'.$section_id.'" and mpd.department_id="'.$department_id.'" and s.academic_year_id="'.$academic_year_id.'" and mcdb.course_id="'.$course_id.'" '.
    'and s.date_of_session between "'.$date_from.'" and "'.$date_to.'"'.
    'order by s.date_of_session,s.period';
    $get_log = mysqli_query($connection,$query);
    $row = mysqli_fetch_array($get_log);
    $total_strength = $row['total'];
    mysqli_data_seek($get_log,0);
    $newFromDate = $date_from;
    $newToDate = $date_to;
    $from_date = date("d-m-Y",strtotime($newFromDate));
    $to_date = date("d-m-Y",strtotime($newToDate));

$html = generateSubjectReportHtml($subject_name,$total_strength,$from_date,$to_date,$get_log);
generatePdf('report.pdf',$html);
}

function generateClassReportHtml($department_name,$from_date,$to_date,$grouped_results){
include '../master/config.php';
$html = <<<HTML
    <!DOCTYPE html>
    <html>
    <head>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    </head>
    <style>
    p{
    margin: 0px;
    }
    h2{
    margin-top: 1em;
    }
    table,tr,th,td{
        border: 1px solid black;
    }
    </style>
    <body>
        <div class="container">
            <h2 class="text-center">SRI SHAKTHI</h2>
            <h3 class="text-center">INSTITUTE OF ENGINEERING AND TECHNOLOGY</h3>
            <p class="text-center">Approved by AICTE New Delhi . affiliated to Anna University,Chennai</p>
            <p class="text-center">AN AUTONOMOUS INSTITUTION</p>
            <p class="text-center">L&T By-Pass, Chinniyampalayam Post,Coimbatore-641062 | Tel: +91 4222369900</p>

        <h2 class="text-center">CLASS LOG BOOK</h2>
        <h4 class="text-center">$department_name</h4>
        <h5 class="text-center">Date Range: $from_date to $to_date</h5>
    HTML;
    foreach ($grouped_results as $date => $daily_results){ 
        $html .= "<h4>Date: $date </h4>";
        $html .= <<<HTML
        <table class="table table-bordered table-striped mb-5">
                <tr>
                    <th scope="col">Period</th>
                    <th scope="col">Subject</th>
                    <th scope="col">Topics Covered</th>
                    <th scope="col">No. of Present </th>
                    <th scope="col">No. of Absent</th>
                    <th scope="col">No. of OD</th>
                    <th scope="col">Absentees name</th>
                </tr>
HTML;
		foreach ($daily_results as $row){
			$query = 'select s.name from student_information s join attendance a on a.register_no=s.register_no where a.session_id="'.$row['session_id'].'" and a.status=0;';
$queryEXE = mysqli_query($connection,$query);
			$column_array = [];
			if($queryEXE->num_rows>0){
				while($absent_row = mysqli_fetch_array($queryEXE)){
					$column_array[] = $absent_row['name'];
				}
			}
            $absentees = implode(", ",$column_array);
            $html .= <<<HTML
            <tr>
                        <td>{$row['period']}</td>
                        <td>{$row['name']}</td>
                        <td>{$row['topics_covered']}</td>
                        <td>{$row['no_of_present']}</td>
                        <td>{$row['no_of_absent']}</td>
                        <td>{$row['no_of_od']}</td>
                        <td>$absentees</td>
            </tr>
HTML;
            
		    } 
        $html .= "</table>";
} 
$html .= <<<HTML
<div class="row">
    <div class="col text-center">
    Subject Staff
    </div>
    <div class="col text-center">
    HoD
    </div>
    <div class="col text-center">
    Principal
    </div>
</div>

</body>
    </html>
HTML;

return $html;
}

function generateSubjectReportHtml($subject_name,$total_strength,$from_date,$to_date,$get_log){
include '../master/config.php';
$html = <<<HTML
<!DOCTYPE html>
<html>
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
</head>
<style>
p{
margin: 0px;
}
h2{
margin-top: 1em;
}
table,tr,th,td{
        border: 1px solid black;
    }

</style>
<body>
    <div class="container">
        <h2 class="text-center">SRI SHAKTHI</h2>
        <h3 class="text-center">INSTITUTE OF ENGINEERING AND TECHNOLOGY</h3>
        <p class="text-center">Approved by AICTE New Delhi . affiliated to Anna University,Chennai</p>
        <p class="text-center">AN AUTONOMOUS INSTITUTION</p>
        <p class="text-center">L&T By-Pass, Chinniyampalayam Post,Coimbatore-641062 | Tel: +91 4222369900</p>

	<h2 class="text-center mb-4">SUBJECT LOG BOOK</h2>
    <div class="row mb-4">
    <div class="col">
    <h4>$subject_name</h4>
    <h4>Total Strength: $total_strength </h4>
    </div>  
    <div class="col">
    <h5 class="text-end">Date Range: $from_date to $to_date</h5>
    </div>
    </div>
        <table class="table table-bordered table-striped mb-5">
                <tr>
                    <th scope="col">S.No</th>
                    <th scope="col">Date</th>
                    <th scope="col">Period</th>
                    <th scope="col">Topics Covered</th>
                    <th scope="col">No. of Present </th>
                    <th scope="col">No. of Absent</th>
                    <th scope="col">No. of OD</th>
                    <th scope="col">Absentees name</th>
                </tr>
HTML;
            $no_of_periods = 1;
             while($row = mysqli_fetch_array($get_log)){
            $column_array = [];
            $query = 'select s.name from student_information s join attendance a on a.register_no=s.register_no where a.session_id="'.$row['session_id'].'" and a.status=0;';
			$queryEXE = mysqli_query($connection,$query);
			if($queryEXE->num_rows>0){
				while($absent_row = mysqli_fetch_array($queryEXE)){
					$column_array[] = $absent_row['name'];
				}
			}
			$absentees = implode(", ",$column_array);

            $html.= <<<HTML
            <tr>
                        <td>$no_of_periods</td>
                        <td>{$row['date_of_session']}</td>
                        <td>{$row['period']}</td>
                        <td>{$row['topics_covered']}</td>
                        <td>{$row['no_of_present']}</td>
                        <td>{$row['no_of_absent']}</td>
                        <td>{$row['no_of_od']}</td>
                        <td>$absentees</td>
            </tr>
HTML;
    $no_of_periods++;
}
$html .= <<<HTML
    </table>

<div class="row">
    <div class="col text-center">
    Subject Staff
    </div>
    <div class="col text-center">
    HoD
    </div>
    <div class="col text-center">
    Principal
    </div>
</div>
</body>
</html>
HTML;

return $html;
}

function generatePdf($filename,$html){
$options = new Options();
$options->set('isRemoteEnabled',true);
$options->set('isHtml5ParserEnabled', true);
$options->set('chroot', realpath('../'));

$dompdf = new Dompdf($options);
$dompdf->loadHtml($html);

$dompdf->setPaper('A4','portrait');

$dompdf->render();
$dompdf->stream($filename,['Attachment'=>false]);
}
