<?php
//create connect to database "myDB"
$connect_database = mysqli_connect("localhost", "root", "", "myDB"); //create connect to database "myDB"
if (!$connect_database) {
    die("connect field" . mysqli_connect_error());
}
// define variables and set to empty values
$course_name_err = $number_of_hours_err = $start_date_err = $end_date_err = $institution_err = $url_err = $file_err = "";
$course_name = $number_of_hours = $start_date = $end_date = $institution = $attachment_resourse = $notes = "";


//function to Verification data from hack
function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

//collect information from add course form and Verification from input if it's data come from POST request: 
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST['course_name'])) {
        $course_name_err = "* Course Name is Required";
    } else {
        $course_name = test_input($_POST['course_name']);
    }

    if (empty($_POST['numberOfHours'])) {
        $number_of_hours_err = "* Number of Hours is Required";
    } else {
        $number_of_hours = test_input($_POST['numberOfHours']);
    }

    if (empty($_POST['courseStartDate'])) {
        $start_date_err = "* Start Date is Required";
    } else {
        $start_date = test_input($_POST['courseStartDate']);
    }

    if (empty($_POST['courseEndDate'])) {
        $end_date_err = "* End Date is Required";
    }else {
        $end_date = test_input($_POST['courseEndDate']);
        if($end_date < $start_date){
            $end_date="";
            $end_date_err="* start date can't be after end date";
        }
    }

    if (empty($_POST['course_institution'])) {
        $institution_err = "* Institution is Required";
    } else {
        $institution = test_input($_POST['course_institution']);
    }
    $notes = test_input($_POST['notes']);
    $attachment = test_input($_POST['attachment']);
    if ($attachment == "Url") {
        if (empty($_POST['Url']))
            $file_err = "* URL is Required";
        else
            $attachment_resourse = test_input($_POST['Url']);

        //sql query to insert a new course in table "Courses"
        if (!empty($course_name) && !empty($number_of_hours) && !empty($start_date) && !empty($end_date) && !empty($institution) && !empty($attachment_resourse)) {
        $sql = "INSERT INTO Courses(CourseName, TotalHours, StartDate, EndtDate, Institution, $attachment, Notes) VALUES (\"$course_name\", $number_of_hours, \"$start_date\", \"$end_date\", \"$institution\", \"$attachment_resourse\", \"$notes\")";
        mysqli_query($connect_database, $sql);
    } 
    } else
        if(isset($_POST["submit"])){ 
            $sql = '';
            if(!empty($_FILES["image"]["name"])) { 
                if ($_FILES["image"]["size"] < 500000){
                // Get file info 
                $fileName = basename($_FILES["image"]["name"]); 
                $fileType = pathinfo($fileName, PATHINFO_EXTENSION); 
                
                // Allow certain file formats 
                $allowTypes = array('jpg','png','jpeg','gif'); 
                if(in_array($fileType, $allowTypes)){ 
                    $image = $_FILES['image']['tmp_name']; 
                    $attachment_resourse = addslashes(file_get_contents($image)); 
                    // Insert record into table "courses" 
                    if (!empty($course_name) && !empty($number_of_hours) && !empty($start_date) && !empty($end_date) && !empty($institution) && !empty($attachment_resourse)) {
                        $sql = "INSERT INTO Courses(CourseName, TotalHours, StartDate, EndtDate, Institution, $attachment, FileName, Notes) VALUES (\"$course_name\", $number_of_hours, \"$start_date\", \"$end_date\", \"$institution\", \"$attachment_resourse\", \"$fileName\", \"$notes\")";
                        mysqli_query($connect_database, $sql);
                    } 
                
                    if($sql){  
                        $file_err = "Course inserted successfully."; 
                    }else{ 
                        $file_err = "File upload failed, please try again."; 
                    }  
                }else{ 
                    $file_err = 'Sorry, only JPG, JPEG, PNG, & GIF files are allowed to upload'; 
                }
            }else{
                $file_err = "Sorry, your file is too large";
            } 
            }else{ 
                $file_err = '* File is Required'; 
            } 
        }         
    
}
mysqli_close($connect_database); //close database "myDB" connection
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Course</title>
    <link rel="stylesheet" href="../CSS/MyStyle.css">
</head>

<body>
    <nav class="Navbar">
        <ul class="list">
            <li class="not_active"><a href="../PHP/Home.php">Personal Information</a></li>
            <li class="not_active"><a href="../PHP/ViewCourses.php">Courses Information</a></li>
            <li class="not_active"><a href="../PHP/ViewExperience.php">Experience Information</a></li>
            <li class="active"><a href="../PHP/AddCourse.php">Add Course</a></li>
            <li class="not_active"><a href="../PHP/AddExperience.php">Add Experience</a></li>
        </ul>
        <img src="../Images/1.jpeg">
    </nav>
    <section class="Add-Course">
        <div class="container">
            <div class="content">
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" enctype="multipart/form-data">
                    <div class="group">
                        <label for="course_name">Course Name:</label>
                        <input type="text" name="course_name" id="course_name">
                        <span class="error"><?php echo $course_name_err; ?></span>
                    </div>
                    <div class="group">
                        <label for="numberOfHours">Number of Hours:</label>
                        <input type="number" min="1" name="numberOfHours" id="numberOfHours" style="margin-left: 21px;">
                        <span class="error"><?php echo $number_of_hours_err; ?></span>
                    </div>
                    <div class="group">
                        <label for="courseStartDate">Start Date:</label>
                        <input type="date" name="courseStartDate" id="courseStartDate" style="margin-left: 67px;">
                        <span class="error"><?php echo $start_date_err; ?></span>
                    </div>
                    <div class="group">
                        <label for="courseEndDate">End Date:</label>
                        <input type="date" name="courseEndDate" id="courseEndDate" style="margin-left: 73px;">
                        <span class="error"><?php echo $end_date_err; ?></span>
                    </div>
                    <div class="group">
                        <label for="institution">Institution:</label>
                        <input type="text" name="course_institution" id="institution" style="margin-left: 67px;">
                        <span class="error"><?php echo $institution_err; ?></span>
                    </div>
                    <div class="group">
                        <label>Attachment:</label>
                        <input type="radio" name="attachment" value="image" checked class="choice1"> <span class="choice">File</span>
                        <input type="radio" name="attachment" value="Url" class="choice2"> <span class="choice">URL</span>
                    </div>
                    <div class="group disabled" id="url">
                        <label for="url" >URL:</label>
                        <input type="url" name="Url" id="url" style="margin-left: 110px;">
                        <span class="error"><?php echo $url_err; ?></span>
                    </div>
                    <div class="group" id="file">
                        <label for="file" >File:</label>
                        <input type="file" name="image" style="margin-left: 110px;" accept="image/png, image/jpeg">
                        <span class="error"><?php echo $file_err; ?></span>
                    </div>
                    <div class="group">
                        <label for="notes">Notes:</label>
                        <textarea name="notes" id="notes" cols="30" rows="7" style="border-radius: 12px;resize: none;"></textarea>
                    </div>
                    <div class="group-btn">
                        <input type="submit" class="btn btn-green" name="submit" value="submit">
                        <input type="reset" class="btn btn-red" value="reset">
                    </div>
                </form>
                <div class="img">
                    <img src="../images/school.png" style="margin-top: 20px;height: 93%;width: 620px;">
                </div>
            </div>
        </div>
    </section>










    <script src="../js/jquery.js"></script>
    <!-- custom-->
    <script >
        $(document).ready(function(){
$(".choice2").click(function(){
    $("#url").removeClass("disabled");
    $("#file").addClass("disabled");
})
$(".choice1").click(function(){
    $("#file").removeClass("disabled");
    $("#url").addClass("disabled");
})
});
    </script>
</body>

</html>