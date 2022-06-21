<?php
//create connect to mysql
$connect_mysql = mysqli_connect("localhost", "root", "");
if (!$connect_mysql) {
    die("connect field" . mysqli_connect_error());
}

//create database if the database is not alerady exists
$sql = "CREATE DATABASE IF NOT EXISTS myDB";
mysqli_query($connect_mysql,$sql);
//close connection to mysql
mysqli_close($connect_mysql);

//create connect to database "myDB"
$connect_database = mysqli_connect("localhost","root","","myDB");

//sql qurey to create table "Users" if it not exists
$sql = "CREATE TABLE IF NOT EXISTS Users(
    FullName VARCHAR(100) NOT NULL,
    Gender VARCHAR(6) NOT NULL,
    BirthDate VARCHAR(255) NOT NULL,
    Nationality VARCHAR(50) NOT NULL,
    PlaceOfBirth VARCHAR(50) NOT NULL,
    JobTitle VARCHAR(100) NOT NULL,
    YearOfExperience INT(2) NOT NULL,
    PersonalImage VARCHAR(255) NOT NULL
)";
mysqli_query($connect_database,$sql);

//sql qurey to create table "Courses" if it not exists
$sql = "CREATE TABLE IF NOT EXISTS Courses(
    Id INT UNSIGNED AUTO_INCREMENT NOT NULL PRIMARY KEY,
    CourseName VARCHAR(255) NOT NULL,
    TotalHours INT UNSIGNED NOT NULL ,
    StartDate date NOT NULL,
    EndtDate date NOT NULL,
    Institution VARCHAR(100) NOT NULL,
    Url VARCHAR(255),
    image longblob,
    FileName VARCHAR(255),
    Notes TEXT
    )";
    mysqli_query($connect_database,$sql);

//sql qurey to create table "Experiences" if it not exists
    $sql = 'CREATE TABLE IF NOT EXISTS Experiences(
        ExperiencesCategory VARCHAR(20) NOT NULL,
        ExperiencesTitle VARCHAR(100) NOT NULL,
        StartMonth VARCHAR(30) NOT NULL,
        EndtMonth VARCHAR(30),
        Institution VARCHAR(100) NOT NULL,
        Description TEXT
    )';
    mysqli_query($connect_database,$sql);

//sql qurey to select user info from table "Users"
$sql = "SELECT * FROM Users";
$result = mysqli_query($connect_database,$sql); # $result will have all user info 
if(mysqli_num_rows($result)>0){
    $row = mysqli_fetch_assoc($result);
}else{
    //sql qurey to insert my data if it not exist to "Users" table and then select user info from table "Users"
    $sql = "INSERT INTO users (FullName, Gender, BirthDate, Nationality, PlaceOfBirth, JobTitle, YearOfExperience, PersonalImage) VALUES (\"Mohammed Wael Alijl\", \"Male\", '30<sup>th</sup>, July 2001', \"palestinian\", \"Gaza\", \"Software Engineering\", 3, \"../Images/me.jpg\")";
    mysqli_query($connect_database,$sql);
    $sql = "SELECT * FROM Users";
    $result = mysqli_query($connect_database,$sql);
    $row = mysqli_fetch_assoc($result);
}
mysqli_query($connect_database,$sql);

//close database "myDB" connection 
mysqli_close($connect_database);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Personal Information</title>
    <link rel="stylesheet" href="../CSS/MyStyle.css">
</head>

<body>
    <nav class="Navbar">
        <ul class="list">
            <li class="active"><a href="../PHP/Home.php">Personal Information</a></li>
            <li class="not_active"><a href="../PHP/ViewCourses.php">Courses Information</a></li>
            <li class="not_active"><a href="../PHP/ViewExperience.php">Experience Information</a></li>
            <li class="not_active"><a href="../PHP/AddCourse.php">Add Course</a></li>
            <li class="not_active"><a href="../PHP/AddExperience.php">Add Experience</a></li>
        </ul>
        <img src="../Images/1.jpeg">
    </nav>    
        <div class="container">
            <div class="parent">
                <h1 class="title">Personal Information</h1>
                <br>
                <br>
                <span class="basic">Full Name:</span>
                <span class="bold"><?php echo $row['FullName']?></span>
                <br>
                <br>
                <br>
                <span class="basic">Gender:</span>
                <span class="bold"><?php echo $row['Gender']?></span>
                <br>
                <br>
                <br>
                <span class="basic">Birth Date:</span>
                <span class="bold"><?php echo $row['BirthDate'] ?></span>
                <br>
                <br>
                <br>
                <span class="basic">Nationality:</span>
                <span class="bold"><?php echo $row['Nationality']?></span>
                <br>
                <br>
                <br>
                <span class="basic">Place of Birth:</span>
                <span class="bold"><?php echo $row['PlaceOfBirth']?></span>
                <br>
                <br>
                <br>
                <span class="basic">Job title:</span>
                <span class="bold"><?php echo $row['JobTitle']?></span>
                <br>
                <br>
                <br>
                <span class="basic">Year of experience:</span>
                <span class="bold"><?php echo $row['YearOfExperience']?> years</span>
                <br>
                <br>
                <br>
                <img src="<?php echo $row['PersonalImage']?>">
            </div>
        </div>   
</body>
</html>