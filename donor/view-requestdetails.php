<?php  
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['pgasoid']==0)) {
  header('location:logout.php');
  } else{

    if(isset($_POST['submit']))
  {
    
    $frid=$_GET['frid'];
    $status=$_POST['status'];
    $donormsg=$_POST['donaremark']; 
  
   $query=mysqli_query($con, "update  tblfoodrequests set status='$status',donorRemark='$donormsg' where id='$frid'");
    if ($query) {
  
    echo '<script>alert("Request Status Has been updated.")</script>';
    echo "<script type='text/javascript'> document.location ='all-requests.php'; </script>";
  }
  else
    {
       echo '<script>alert("Something Went Wrong. Please try again.")</script>';
    }

  
}

?>


<!DOCTYPE html>
<head>
<title>Food Waste Management System|| Food Requests</title>

<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
<!-- bootstrap-css -->
<link rel="stylesheet" href="css/bootstrap.min.css" >
<!-- //bootstrap-css -->
<!-- Custom CSS -->
<link href="css/style.css" rel='stylesheet' type='text/css' />
<link href="css/style-responsive.css" rel="stylesheet"/>
<!-- font CSS -->
<link href='//fonts.googleapis.com/css?family=Roboto:400,100,100italic,300,300italic,400italic,500,500italic,700,700italic,900,900italic' rel='stylesheet' type='text/css'>
<!-- font-awesome icons -->
<link rel="stylesheet" href="css/font.css" type="text/css"/>
<link href="css/font-awesome.css" rel="stylesheet"> 
<!-- //font-awesome icons -->
<script src="js/jquery2.0.3.min.js"></script>
</head>
<body>
<section id="container">
<!--header start-->
<?php include_once('includes/header.php');?>
<!--header end-->
<!--sidebar start-->
<?php include_once('includes/sidebar.php');?>
<!--sidebar end-->
<!--main content start-->
<section id="main-content">
	<section class="wrapper">
		<div class="table-agile-info">
 <div class="panel panel-default">
    <p style="font-size:16px; color:red" align="center"> <?php if($msg){
    echo $msg;
  }  ?> </p>
    <div class="panel-heading">
 Food Details
    </div>
    <div>
<?php
        
$fid=$_GET['frid'];   
  $donarid=$_SESSION['pgasoid'];
$ret=mysqli_query($con,"select tblfoodrequests.requestNumber,tblfoodrequests.requestDate,tblfoodrequests.mobileNumber,tblfoodrequests.message,tblfoodrequests.status,tblfoodrequests.donorRemark,tblfoodrequests.requestCompletionDate,tblfoodrequests.fullName,
tblfood.ID,tblfood.foodId,tblfood.ContactPerson,tblfood.CPMobNumber,tblfood.CreationDate,tblfood.FoodItems,tblfood.StateName,tblfood.CityName,tblfood.Description,tblfood.PickupDate,tblfood.PickupAddress,tblfood.Image,tblfood.UpdationDate,tbldonor.FullName,tbldonor.MobileNumber,tbldonor.Email from 
tblfoodrequests
join tblfood  on tblfood.ID=tblfoodrequests.foodId
join tbldonor on tblfood.DonorID=tbldonor.ID
 where  tblfoodrequests.id='$fid'");
while ($row=mysqli_fetch_array($ret)) {
?>

      <table border="1" class="table table-bordered mg-b-0">
    <tr align="center">
<td colspan="4" style="font-size:20px;color:blue">
 View Request Details of #<?php  echo $row['requestNumber'];?></td></tr>    
  <tr>
    <th>Register By </th>
    <td><?php  echo $row['FullName'];?></td>
    <th>Registred Mobile Number</th>
    <td><?php  echo $row['MobileNumber'];?></td>
  </tr>
<tr>
    <th>Registred Email</th>
    <td><?php  echo $row['Email'];?></td>
    <th>Contact Person</th>
    <td><?php  echo $row['ContactPerson'];?></td>
  </tr>

  <tr>
    <th>Contact Person Moible Number</th>
    <td><?php  echo $row['CPMobNumber'];?></td>
    <th>State Name</th>
    <td><?php echo $row['StateName']; ?></td>
  </tr>


<tr>
<th>City Name</th>
<td>
<?php echo $row['CityName']; ?>
  </td>

<th>Description</th>
<td>
<?php echo $row['Description']; ?>
  </td>
  </tr>
  <tr>
<th>Pick Up Date</th>
<td>
<?php echo $row['PickupDate']; ?>
  </td>
<th>Pick Up Address</th>
<td>
<?php echo $row['PickupAddress']; ?>
  </td>
  </tr>
  <tr>
<th>Image</th>
<td>
<img src="../donor/images/<?php echo $row['Image']; ?>" width="200" height="200">
  </td>

    <th>Status</th>
    <td> <?php  
if($row['status']==""){
echo "Not Confirmed Yet";
}else{
echo $row['status'];}
;?></td>
<tr>
  <th colspan="4" style="text-align:center;color:red;font-size:20px;">Requested By</th>
</tr>
<tr>
<th>Requested By</th>
<td><?php echo $row['fullName']; ?></td>
<th>Requester Mobile No.</th>
<td><?php echo $row['mobileNumber']; ?></td>
</tr>

<tr>
<th>Message</th>
<td><?php echo $row['message']; ?></td>
<th>Request Date</th>
<td><?php echo $row['requestDate']; ?></td>
</tr>
<?php if($row['donorRemark']!=''): ?>
<tr>
<th>Donar Remark</th>
<td><?php echo $row['donorRemark']; ?></td>
<th>Remark Date</th>
<td><?php echo $row['requestCompletionDate']; ?></td>
</tr>
<?php endif; ?>

</tr>
  </table>
  <table border="1" class="table table-bordered mg-b-0">
<?php if($row['status']==""){ ?>
<form method="post" name="submit">

  <tr>
    <th>Status :</th>
    <td>
   <select name="status" class="form-control wd-450" required="true" >
    <option value="">Select</option>
     <option value="Food Take Away/ Request Completed">Food Take Away/ Request Completed</option>
     <option value="Request Rejected">Request Rejected</option>
   </select></td>
  </tr>
  <tr>
    <th>Remark :</th>
    <td><textarea class="form-control" required name="donaremark"></textarea></td>
  </tr>


  <tr align="center">
    <td colspan="2"><button type="submit" name="submit" class="btn btn-primary">Update</button></td>
  </tr>
  </form>
<?php }  ?>



</table>
     <?php } ?>       
            
          
    </div>
  </div>
</div>
</section>
 <!-- footer -->
		 <?php include_once('includes/footer.php');?>  
  <!-- / footer -->
</section>

<!--main content end-->
</section>
<script src="js/bootstrap.js"></script>
<script src="js/jquery.dcjqaccordion.2.7.js"></script>
<script src="js/scripts.js"></script>
<script src="js/jquery.slimscroll.js"></script>
<script src="js/jquery.nicescroll.js"></script>
<!--[if lte IE 8]><script language="javascript" type="text/javascript" src="js/flot-chart/excanvas.min.js"></script><![endif]-->
<script src="js/jquery.scrollTo.js"></script>
</body>
</html>

<?php }  ?>