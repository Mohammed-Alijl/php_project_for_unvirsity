<?php

$connect_database = mysqli_connect("localhost", "root", "", "myDB"); //create connect to database "myDB"
if (!$connect_database) {
    die("connect field" . mysqli_connect_error());
}

// define variables and set to empty values
$ex_catagory = $ex_title = $startMonth  = $institution = $descripiton = "";
$ex_catagory_err = $ex_title_err = $startMonth_err = $institution_err = $description_err = "";


//function to Verification data from hacking
function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

//collect information from add experience form and Verification from input if it's data come from POST request:
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    //collect Experience Category and it's Required
    if (empty($_POST['experienceCategory'])) {
        $ex_catagory_err = "* Experience Category is Required";
    } else {
        $ex_catagory = test_input($_POST['experienceCategory']);
    }

    //collect Experience Title and it's Required
    if (empty($_POST['experienceTitle'])) {
        $ex_title_err = "* Experience Title is Required";
    } else {
        $ex_title = test_input($_POST['experienceTitle']);
    }

    //collect Start Month and it's Required
    if (empty($_POST['startMonth'])) {
        $startMonth_err = "* Start Month is Required";
    } else {
        $startMonth = test_input($_POST['startMonth']);
    }

    //collect End Month and it's not Required
    if(empty($_POST['endMonth'])){
        $endMonth ="until present";
    } else{
        $endMonth = test_input($_POST['endMonth']);
        if($startMonth > $endMonth){
            $startMonth="";
            $startMonth_err = "* start date can't be after end date !!";
        }
    }
    

    //collect Institution and it's Required
    if (empty($_POST['ex_institution'])) {
        $institution_err = "* Institution is Required";
    } else {
        $institution = test_input($_POST['ex_institution']);
    }

    //collect desciption and it's Required
    if (empty($_POST['description'])) {
        $description_err = "* Description is Required";
    } else {
        $descripiton = test_input($_POST['description']);
    }

    //sql qurey to insert record into 'Experiences' table
    if (!empty($ex_catagory) && !empty($ex_title) && !empty($startMonth) && !empty($institution) && !empty($descripiton)) {
            $sql = "INSERT INTO Experiences(ExperiencesCategory, ExperiencesTitle, StartMonth, EndtMonth, Institution, Description) VALUES (\"$ex_catagory\", \"$ex_title\", \"$startMonth\", \"$endMonth\", \"$institution\", \"$descripiton\")";
            mysqli_query($connect_database, $sql);
            $description_err = "Experience inserted successfully";
    }

    mysqli_close($connect_database); //close database "myDB" connection
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Experience</title>
    <link rel="stylesheet" href="../CSS/MyStyle.css">
</head>

<body>
    <nav class="Navbar">
        <ul class="list">
            <li class="not_active"><a href="../PHP/Home.php">Personal Information</a></li>
            <li class="not_active"><a href="../PHP/ViewCourses.php">Courses Information</a></li>
            <li class="not_active"><a href="../PHP/ViewExperience.php">Experience Information</a></li>
            <li class="not_active"><a href="../PHP/AddCourse.php">Add Course</a></li>
            <li class="active"><a href="../PHP/AddExperience.php">Add Experience</a></li>
        </ul>
        <img src="../Images/1.jpeg">
    </nav>
    <section class="Add-Experience">
        <div class="container">
            <div class="content">
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                    <div class="group">
                        <label for="experienceCategory">Experience Category</label>
                        <select name="experienceCategory" id="experienceCategory">
                            <option value="" selected></option>
                            <option value="Job">Job</option>
                            <option value="Freelancer">Freelancer</option>
                            <option value="Volunteer">Volunteer</option>
                            <option value="Self-Learning">Self-Learning</option>
                            <option value="other">other</option>
                        </select>
                        <span class="error"><?php echo $ex_catagory_err; ?></span>
                    </div>
                    <div class="group">
                        <label for="experienceTitle">Experience Title</label>
                        <input type="text" name="experienceTitle" id="experienceTitle" value="<?php echo $ex_title ?>" style="margin-left: 40px;">
                        <span class="error"><?php echo $ex_title_err; ?></span>
                    </div>
                    <div class="group">
                        <label for="startMonth">Start Month:</label>
                        <input type="month" name="startMonth" id="startMonth" value="<?php echo $startMonth ?>" style="margin-left: 60px;">
                        <span class="error"><?php echo $startMonth_err; ?></span>
                    </div>
                    <div class="group">
                        <label for="">End Month:</label>
                        <input type="month" name="endMonth" value="<?php echo $endMonth ?>" style="margin-left: 66px;">
                    </div>
                    <div class="group">
                        <label for="ex_institution">Institution:</label>
                        <input type="text" name="ex_institution" id="ex_institution" value="<?php echo $institution ?>" style="margin-left: 67px;">
                        <span class="error"><?php echo $institution_err; ?></span>
                    </div>
                    <div class="group">
                        <label for="description">Description</label>
                        <textarea name="description" id="description" cols="60" rows="6" style="border-radius: 5px;resize: none;margin-left: -30px;"><?php echo $descripiton ?></textarea>
                    </div>
                    <div class="group-btn">
                        <input type="submit" class="btn btn-green" name="submit" value="submit">
                        <input type="reset" class="btn btn-red" value="reset">
                        <span class="error"><?php echo $description_err; ?></span>
                    </div>
                </form>
                <div class="img">
                    <img src="../images/book.png" style="margin-top: 12px; height: 92%;width: 450px;">
                </div>
            </div>
        </div>
    </section>
</body>

</html>