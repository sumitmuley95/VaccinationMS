<?php 
session_start();
error_reporting(0);
//DB connection
include_once('includes/config.php');

if(isset($_POST['submit'])) {
    // Getting post values
    $fname = $_POST['fullname'];
    $mnumber = $_POST['mobilenumber'];
    $email = $_POST['email'];  // Capture email
    $dob = $_POST['dob'];
    $govtid = $_POST['govtissuedid'];
    $govtidnumber = $_POST['govtidnumber'];
    $address = $_POST['address'];
    $state = $_POST['state'];
    $testtype = $_POST['testtype'];
    $timeslot = $_POST['birthdaytime'];
    $orderno = mt_rand(100000000, 999999999);

    // Query to insert into tblpatients (with Email)
    $query = "INSERT INTO tblpatients(FullName, MobileNumber, Email, DateOfBirth, GovtIssuedId, GovtIssuedIdNo, FullAddress, State) 
              VALUES('$fname', '$mnumber', '$email', '$dob', '$govtid', '$govtidnumber', '$address', '$state');";

    // Query to insert into tbltestrecord
    $query .= "INSERT INTO tbltestrecord(PatientMobileNumber, TestType, TestTimeSlot, OrderNumber) 
               VALUES('$mnumber', '$testtype', '$timeslot', '$orderno');";

    // Execute the queries
    $result = mysqli_multi_query($con, $query);
    
    if ($result) {
        echo '<script>alert("Your test request submitted successfully. Order number is "+"'.$orderno.'")</script>';
        echo "<script>window.location.href='new-user-testing.php'</script>";
    } else {
        echo "<script>alert('Something went wrong. Please try again.');</script>";  
        echo "<script>window.location.href='new-user-testing.php'</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Vaccination Management System | New User Testing</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    
    <style type="text/css">
    label{
        font-size:16px;
        font-weight:bold;
        color:#000;
    }
    </style>
    
    <script>
    function mobileAvailability() {
        $("#loaderIcon").show();
        jQuery.ajax({
            url: "check_availability.php",
            data: 'mobnumber=' + $("#mobilenumber").val(),
            type: "POST",
            success: function(data) {
                $("#mobile-availability-status").html(data);
                $("#loaderIcon").hide();
            },
            error: function() {}
        });
    }
    </script>

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <?php include_once('includes/sidebar.php');?>

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <?php include_once('includes/topbar.php');?>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <h1 class="h3 mb-4 text-gray-800">User Details</h1>

                    <form name="newtesting" method="post">
                        <div class="row">

                            <div class="col-lg-6">

                                <!-- Basic Card Example -->
                                <div class="card shadow mb-4">
                                    <div class="card-header py-3">
                                        <h6 class="m-0 font-weight-bold text-primary">Personal Information</h6>
                                    </div>
                                    <div class="card-body">
                                    <div class="form-group">
        <label>Full Name</label>
        <input type="text" class="form-control" id="fullname" name="fullname" placeholder="Enter your full name..." pattern="[A-Za-z ]+" title="Letters and spaces only" required="true" oninput="this.value = this.value.replace(/[^A-Za-z ]/g, '')">
    </div>
                                        <div class="form-group">
                                            <label>Mobile Number</label>
                                            <input type="text" class="form-control" id="mobilenumber" name="mobilenumber" placeholder="Please enter your mobile number" pattern="[0-9]{10}" maxlength="10" minlength="10" title="10 numeric characters only" required="true" onBlur="mobileAvailability()" oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                                            <span id="mobile-availability-status" style="font-size:12px;"></span>
                                        </div>
                                        <!-- Added Email Field -->
                                        <div class="form-group">
                                            <label>Email</label>
                                            <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email" required="true">
                                        </div>
                                        <div class="form-group">
                                            <label>DOB</label>
                                            <input type="date" class="form-control" id="dob" name="dob" required="true">
                                        </div>
                                        <div class="form-group">
                                            <label>Any Govt Issued ID</label>
                                            <input type="text" class="form-control" id="govtissuedid" name="govtissuedid" placeholder="Pancard / Driving License / Voter id / any other" required="true">
                                        </div>
                                        <div class="form-group">
                                            <label>Aadhaar ID Number</label>
                                            <input type="text" class="form-control" id="govtidnumber" name="govtidnumber" placeholder="Enter Aadhaar ID Number" required="true" maxlength="12" minlength="12" pattern="\d{12}" title="Aadhaar ID must be exactly 12 digits" oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                                        </div>
                                        <div class="form-group">
                                            <label>Address</label>
                                            <textarea class="form-control" id="address" name="address" required="true" placeholder="Enter your full address here"></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label>State</label>
                                            <select class="form-control" id="state" name="state" required="true">
                                                <option value="">Select</option>
                                                <option value="Andhra Pradesh">ANDHRA PRADESH</option>
                                                <option value="Arunachal Pradesh">ARUNACHAL PRADESH</option>
                                                <option value="Assam">ASSAM</option>
                                                <option value="Bihar">BIHAR</option>
                                                <option value="Chattisgarh">CHATTISGARH</option>
                                                <option value="Goa">GOA</option>
                                                <option value="Gujrat">GUJRAT</option>
                                                <option value="Himachal Pradesh">HIMACHAL PRADESH</option>
                                                <option value="Jharkhand">JHARKHAND</option>
                                                <option value="Karnataka">KARNATAKA</option>
                                                <option value="Kerala">KERALA</option>
                                                <option value="Madhya Pradesh">MADHYA PRADESH</option>
                                                <option value="Maharashtra">MAHARASHTRA</option>
                                                <option value="Manipur">MANIPUR</option>
                                                <option value="Mizoram">MIZORAM</option>
                                                <option value="Nagaland">NAGALAND</option>
                                                <option value="Odisha">ODISHA</option>
                                                <option value="Punjab">PUNJAB</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="card shadow mb-4">
                                    <div class="card-header py-3">
                                        <h6 class="m-0 font-weight-bold text-primary">Testing Information</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label>Test Type</label>
                                            <select class="form-control" id="testtype" name="testtype" required="true">
                                                <option value="">Select</option>
                                                <option value="BCG">BCG</option>
                                                <option value="DPT">DPT</option>
                                                <option value="OPV">OPV</option>
                                                <option value="Hepatitis B">Hepatitis B</option>
                                                <option value="Measles and Rubella">Measles and Rubella</option>
                                                <option value="Pentavalent Vaccine">Pentavalent Vaccine</option>
                                                <option value="Rotavirus Vaccine">Rotavirus Vaccine</option>
                                                <option value="Influenza Vaccine">Influenza Vaccine</option>
                                                <option value="COVID-19 Vaccine">COVID-19 Vaccine</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
    <label>Test Time Slot</label>
    <input type="datetime-local" class="form-control" id="birthdaytime" name="birthdaytime" required="true" min="">
</div>

<script>
    // Set the minimum date to the current date and time
    const currentDateTime = new Date().toISOString().slice(0, 16); // Get the current date and time in the correct format
    document.getElementById("birthdaytime").min = currentDateTime;
</script>

                                        <div class="form-group">
                                            <button type="submit" class="btn btn-primary btn-user btn-block" name="submit">Submit</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <!-- End of Main Content -->

            </div>
            <!-- End of Content Wrapper -->

        </div>
        <!-- End of Page Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

</body>

</html>
