<?php
include('/admin/includes/config.php');
if(!empty($_POST["catid"])) 
{
 $id=intval($_POST['catid']);
 //echo "<script> alert("hsbn"); </script>";
$query=mysqli_query($con,"SELECT DISTINCT Dist FROM locationtable WHERE State_id=$id and Is_Active=1");
?>
<option value="">Select District</option>
<?php
 while($row=mysqli_fetch_array($query))
 {
  ?>
  <option value="<?php echo htmlentities($row['Dist']); ?>"><?php echo htmlentities($row['Dist']); ?></option>
  <?php
 }
}
?>