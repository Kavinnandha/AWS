# Student Management System(SMS)

A Web Application designed to help faculty and students manage various academic and administrative activities.

# Database Structure ER Diagram

<picture>
 <source media="(prefers-color-scheme: light)" srcset="YOUR-LIGHTMODE-IMAGE">
 <img alt="ER Diagram" src="database_er_diagram.png">
</picture>

# Usage 

> [!NOTE]
> The webapp was tested on xampp with default configurations, if you have a different configuration or server, please change the `master/config.php` file for the database credentials.

Import the AttendanceManagement.sql file into your database.
Insert a new record into login with the role_id as 5(admin role), for the password, use the built-in mysql PASSWORD() function.
Open the webpage and login using the user you just created.
populate the database through the DB Upload dropdown in the sidebar.

# Features

## Student Login

- Check your total attendance including subject wise and overall percentage.
- View your internal marks and semester results (yet to be implemented)
- Leaderboard rankings (yet to be implemented)
- Submit leave requests or on duty requests for approval by Advisor.
- Submit any requests or feedbacks to the department HOD's.
- Upload extra curricular activities such as courses,competitions,internships and research papers for extra credits.

## Staff Login

- Take attendance for a class once logged in.
- Submit leave requests for approval by Head Of Department.
- Student details of each class taught by the teacher.
- Subjects taught by the teacher.
- show details of slow learners (yet to be implemented).
- top achievers in their subject
- show arrears in their subjects if any.
- show low attendance of students.

## Advisor Login

- shows the missed attendance for recent days and current day
- shows absentees for current day
- shows attendance shortage for students
- view any semester setbacks and ranking of students.
- Get a log report for specified dates that shows details of subjects/topics taught and absentees.

## HOD login

- view and accept faculty and student leave requests
- view absentees report for department in the current day
- Create advisor mapping for each class.
- Specify the course,department and batch mapping for each subject.
- Specify teacher course mapping.
- get a log report for all classes in the department.
- upload student details(supports bulk upload)
- Request changes in database to database admin.

## Admin login

Upload functionality for:
- Student Details
- Staff details
- Course
- Batch
- Department
- Programme
- Academic Year
- Programme Department Mapping
- Advisor Mapping
- Course Department Batch Mapping
- Teacher Course Mapping
