<?php 

$connect_database = mysqli_connect("localhost","root","","myDB"); //connect to database 'myDB'
if (!$connect_database) {
    die("connect field" . mysqli_connect_error());
}
//sql qurey to select all data from table "courses" weher id is equel to where data come from and store data in $result varible
$sql = "SELECT * FROM courses WHERE id = $_GET[id];";
$result = mysqli_query($connect_database,$sql);
$row = mysqli_fetch_assoc($result);
mysqli_close($connect_database); //close connection to database 'myDB'

//function to format date like d/m/y
function formatDate($date){
    $formatedDate = explode('-',$date);
    return "$formatedDate[2]/$formatedDate[1]/$formatedDate[0]";
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Course Certificate</title>
    <link rel="stylesheet" href="../CSS/MyStyle.css">
</head>

<body>
    <nav class="Navbar">
        <ul class="list">
            <li class="not_active"><a href="../PHP/Home.php">Personal Information</a></li>
            <li class="not_active"><a href="../PHP/ViewCourses.php">Courses Information</a></li>
            <li class="not_active"><a href="../PHP/ViewExperience.php">Experience Information</a></li>
            <li class="not_active"><a href="../PHP/AddCourse.php">Add Course</a></li>
            <li class="not_active"><a href="../PHP/AddExperience.php">Add Experience</a></li>
        </ul>
        <img src="../Images/1.jpeg">
    </nav>
    <section class="course_view">
        <div class="container">
            <?php 
            echo " <h1 class=\"title\" style=\"padding: 40px 0 20px 0;font-size: 42px;\">Course \"" . $row['CourseName'] . "\"</h1>
            <p>from " . formatDate($row["StartDate"]) . " to " . formatDate($row['EndtDate']) . ", totally " . $row['TotalHours'] . " training hours" . "</p><br>
            <p>Institution was \"" . $row['Institution'] . "\"</p>";
            if($row['image'])
                echo "<img class=\"decode_image\" src=\"data:image/jpg;charset=utf8;base64," . base64_encode($row['image']) . "\"/><br>
                <p style=\"padding:20px 30px\">$row[FileName] File</p>"; 
            else
                echo "<a href=\"$row[Url]\">$row[Url]</a>";
            ?>
        </div>
    </section>
</body>

</html>