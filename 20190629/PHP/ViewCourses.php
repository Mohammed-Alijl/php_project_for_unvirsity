<?php
//create connect to database "myDB"
$connect_database = mysqli_connect("localhost","root","","myDB");
if (!$connect_database) {
    die("connect field" . mysqli_connect_error());
}
//sql query to select all information for each course from table "Courses" and assign them in $result variable
$sql = "SELECT Id,CourseName,TotalHours,StartDate,EndtDate,Institution,Url,image,Notes FROM Courses";
$result = mysqli_query($connect_database, $sql);
//close database "myDB" connection
mysqli_close($connect_database);

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
    <title>Courses Information</title>
    <link rel="stylesheet" href="../CSS/MyStyle.css">
</head>

<body>
    <nav class="Navbar">
        <ul class="list">
            <li class="not_active"><a href="../PHP/Home.php">Personal Information</a></li>
            <li class="active"><a href="../PHP/ViewCourses.php">Courses Information</a></li>
            <li class="not_active"><a href="../PHP/ViewExperience.php">Experience Information</a></li>
            <li class="not_active"><a href="../PHP/AddCourse.php">Add Course</a></li>
            <li class="not_active"><a href="../PHP/AddExperience.php">Add Experience</a></li>
        </ul>
        <img src="../Images/1.jpeg">
    </nav>
    <div class="container">
        <h1 class="title">All Courses Information</h1>
        <br>
        <table>
            <thead>
                <tr>
                    <th rowspan="2">#</th>
                    <th rowspan="2">Course Name</th>
                    <th rowspan="2">Total Hours</th>
                    <th colspan="2">Date</th>
                    <th rowspan="2">Institution</th>
                    <th rowspan="2">Attachment</th>
                    <th rowspan="2">Notes</th>
                </tr>
                <tr>
                    <th>From</th>
                    <th>To</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                if(mysqli_num_rows($result) > 0){                   
                    $even = 0;
                    while($row = mysqli_fetch_assoc($result)){
                        if($even %2 == 0)
                            {echo  "<tr class=\"colorful_row\">";}
                        else
                            {echo "<tr>";}
                        echo "  
                                    <td class=\"id\">" . $row['Id'] . "</td>
                                    <td>" . $row['CourseName'] . "</td>
                                    <td class=\"toCenterSmall\">" . $row['TotalHours'] . "</td>
                                    <td class=\"toCenter\">" . formatDate($row['StartDate']) . "</td>
                                    <td class=\"toCenter\">" . formatDate($row['EndtDate']) . "</td>
                                    <td class=\"toCenter\">" . $row['Institution'] . "</td>
                                    <td class=\"toCenterSmall\">  <a href=\"../PHP/Course_View.php?id=$row[Id]\">View</a> </td>
                                    <td class=\"notes\">" . $row['Notes'] . "</td>
                                </tr>
                            ";
                            $even++;
                    }
                }
                
                ?>
            </tbody>
        </table>
    </div>
</body>

</html>
