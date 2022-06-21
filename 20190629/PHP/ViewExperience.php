<?php 
//create connect to database "myDB"
$connect_database = mysqli_connect("localhost","root","","myDB");
if (!$connect_database) {
    die("connect field" . mysqli_connect_error());
}
//sql query to select all information for each experience from table "Experience" and assign them in $result virable
$sql = "SELECT * FROM experiences";
$result = mysqli_query($connect_database,$sql);
mysqli_close($connect_database);

//function to format date like d/m/y
function formatDate($date){
    if($date=="until present")
        return "until present";
        else{
            $formatedDate = explode('-',$date);
            return "$formatedDate[1]/$formatedDate[0]";
        }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Experience Information</title>
    <link rel="stylesheet" href="../CSS/MyStyle.css">
</head>

<body>
    <nav class="Navbar">
        <ul class="list">
            <li class="not_active"><a href="../PHP/Home.php">Personal Information</a></li>
            <li class="not_active"><a href="../PHP/ViewCourses.php">Courses Information</a></li>
            <li class="active"><a href="../PHP/ViewExperience.php">Experience Information</a></li>
            <li class="not_active"><a href="../PHP/AddCourse.php">Add Course</a></li>
            <li class="not_active"><a href="../PHP/AddExperience.php">Add Experience</a></li>
        </ul>
        <img src="../Images/1.jpeg">
    </nav>
    <div class="container">
            <h1 class="title">All Experience Information</h1>
            <?php 
            if(mysqli_num_rows($result) > 0){
                while($row = mysqli_fetch_assoc($result)){
                    echo "<section>
                                <h3>" . $row['ExperiencesTitle'] ."</h3>
                                <span class=\"training\"> " . $row['Institution'] . " / " . $row['ExperiencesCategory'] . "</span>
                                <br>
                                <span class=\"date\">from " . formatDate($row['StartMonth']) . " to " . formatDate($row['EndtMonth']) . "</span>
                                <p class=\"describtion\">" . $row['Description'] . "</p>
                                </section>";
                }
            }          
            ?>            
        </div>
</body>

</html>