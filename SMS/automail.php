<?php include 'automail_backend.php'?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">  
    <title>Email Template</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            width: 100%;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 8px;
            text-align: center;
            border: 1px solid #ddd;
        }
        th {
            background-color: #f2f2f2;
        }
        .section-title {
            font-size: 18px;
            margin-top: 20px;
        }
        h1,h3, h4, h5 {
            margin: 0;
            padding-top: 10px;
        }

        @media screen and (max-width: 600px) {
            table {
                width: 100%;
            }
            .responsive-table {
                display: block;
                overflow-x: auto;
                white-space: nowrap;
            }
            th, td {
                display: block;
                text-align: left;
            }
            th {
                background-color: #f9f9f9;
            }
            .section-title {
                font-size: 16px;
            }
        }
    </style>
</head>
<body>
<table align="center" width="100%" cellpadding="0" cellspacing="0">
<tr>
  <td align="center">
        <h1>SRI SHAKTHI</h1>
        <h3>INSTITUTE OF ENGINEERING AND TECHNOLOGY</h3>
        <h5>Approved by AICTE New Delhi . affiliated to Anna University,Chennai</h5>
        <h4>AN AUTONOMOUS INSTITUTION</h4>
        <h5>L&T By-Pass, Chinniyampalayam Post,Coimbatore-641062 | Tel: +91 4222369900</h5>
        <?php echo $data;?>
<!--<h3>Total Absent:</h3> -->

</body>
</html>
