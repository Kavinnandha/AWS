#!/bin/bash
from="sietproducts@siet.ac.in"
recipient="missionuniverse07@gmail.com"
Cc="keerthiraghavan2005@gmail.com,missionuniverse018@gmail.com,harishkumarkannan2005@gmail.com,liyanderrishwanthlabinger23cys@srishakthi.ac.in"
subject="Attendance Report"
body="Automated Attendance Report for $(date '+%d-%m-%Y')"

# Fetch the PDF and encode it in base64
pdf_base64=$(curl -s http://110.172.151.105/SMS/web.php | base64)

# Check if PDF generation was successful
if [ $? -eq 0 ] && [ -n "$pdf_base64" ]; then
    echo "PDF generated successfully."
else
    echo "Failed to generate PDF."
    exit 1
fi

# Prepare the email content with Cc
email_content="From: $from
To: $recipient
Cc: $Cc
Subject: $subject
MIME-Version: 1.0
Content-Type: multipart/mixed; boundary=\"boundary\"

--boundary
Content-Type: text/plain; charset=UTF-8

$body

--boundary
Content-Type: application/pdf; name=\"attendance_report.pdf\"
Content-Disposition: attachment; filename=\"attendance_report.pdf\"
Content-Transfer-Encoding: base64

$pdf_base64

--boundary--"

# Send the email with msmtp
echo "$email_content" | msmtp --debug --from=$from -t

# Check if the email was sent successfully
if [ $? -eq 0 ]; then
    echo "Email sent successfully."
else
    echo "Failed to send email."
fi
