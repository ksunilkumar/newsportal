<?php 
session_start();
include('includes/config.php');
//Genrating CSRF Token
if (empty($_SESSION['token'])) {
 $_SESSION['token'] = bin2hex(random_bytes(32));
}

if(isset($_POST['submit']))
{
  //Verifying CSRF Token
if (!empty($_POST['csrftoken'])) {
    if (hash_equals($_SESSION['token'], $_POST['csrftoken'])) {
$name=$_POST['name'];
$email=$_POST['email'];
$comment=$_POST['comment'];
$postid=intval($_GET['nid']);
$st1='0';
$query=mysqli_query($con,"insert into tblcomments(postId,name,email,comment,status) values('$postid','$name','$email','$comment','$st1')");
if($query):
  echo "<script>alert('comment successfully submit. Comment will be display after admin review ');</script>";
  unset($_SESSION['token']);
else :
 echo "<script>alert('Something went wrong. Please try again.');</script>";  

endif;

}
}
}
?>

<!DOCTYPE html>
<html lang="en">

  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>News Portal | Home Page</title>

    <!-- Bootstrap core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/modern-business.css" rel="stylesheet">

    <!-- Mobile Specific Metas -->
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

<!-- Bootstrap  -->
<link rel="stylesheet" type="text/css" href="stylesheets/bootstrap.css" >

<!-- Theme Style -->
<link rel="stylesheet" type="text/css" href="stylesheets/style.css">

  <!-- Colors -->
  <link rel="stylesheet" type="text/css" href="stylesheets/colors/color1.css" id="colors">

<!-- Animation Style -->
<link rel="stylesheet" type="text/css" href="stylesheets/animate.css">

<!-- Google Fonts -->
<link href='http://fonts.googleapis.com/css?family=Roboto:300,400,500,700' rel='stylesheet' type='text/css'>
<link href='http://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700' rel='stylesheet' type='text/css'>

<!-- Favicon and touch icons  -->
<link href="icon/apple-touch-icon-144-precomposed.png" rel="apple-touch-icon-precomposed" sizes="144x144">
<link href="icon/apple-touch-icon-114-precomposed.png" rel="apple-touch-icon-precomposed" sizes="114x114">
<link href="icon/apple-touch-icon-72-precomposed.png" rel="apple-touch-icon-precomposed" sizes="72x72">
<link href="icon/apple-touch-icon-57-precomposed.png" rel="apple-touch-icon-precomposed">
<link href="icon/favicon.png" rel="shortcut icon">

  </head>

  <body>

    <!-- Navigation -->
   <?php include('includes/header.php');?>

    <!-- Page Content -->
    <div class="container">


     
      <div class="row" style="margin-top: 4%">

        <!-- Blog Entries Column -->
        <div class="col-md-8">

          <!-- Blog Post -->
<?php
$pid=intval($_GET['nid']);
 $query=mysqli_query($con,"select tblposts.PostTitle as posttitle,tblposts.PostImage,tblcategory.CategoryName as category,tblcategory.id as cid,tblsubcategory.Subcategory as subcategory,tblposts.PostDetails as postdetails,tblposts.PostingDate as postingdate,tblposts.PostUrl as url from tblposts left join tblcategory on tblcategory.id=tblposts.CategoryId left join  tblsubcategory on  tblsubcategory.SubCategoryId=tblposts.SubCategoryId where tblposts.id='$pid'");
while ($row=mysqli_fetch_array($query)) {
?>

	<!-- Main -->
	<section id="main">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<div class="post-wrap posts post-single">
           <div class="col-md-11">
           <div class="card mb-4" style="margin-top: -6%">
						<article class="post">
              <div class="head-post">
								<h2><?php echo htmlentities($row['posttitle']);?></h2>
								<div class="meta">
                <?php
                //$author_id=$_SESSION['login'];
                //$ret=mysqli_query($con,"select FullName from  tbladmin where AdminUserName=$author_id and Is_Active=1");
               // if($result=mysqli_fetch_array($ret)){
                //  $author = $result['FullName'];
                //}
                //else
                   $author = null;

                ?>
									<span class="author">By : <?php echo htmlentities($author);?></span>
                  <span class="author">Category : <a href="category.php?catid=<?php echo htmlentities($row['cid'])?>"><?php echo htmlentities($row['category']);?></a><span class="author">
                  <span class="time"> Published on : <?php echo htmlentities($row['postingdate']);?></span>
								</div>
							</div><!-- /.head-post -->
              <div class="body-post">
								<div class="share-post">
                <?php  
                  if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')   
                      $url = "https://";   
                  else  
                      $url = "http://";   
                  // Append the host(domain name, ip) to the URL.   
                  $url.= $_SERVER['HTTP_HOST'];   
                  
                  // Append the requested resource location to the URL   
                  $url.= $_SERVER['REQUEST_URI'];    
                    
                 // echo $url;  
                ?>   
									<ul>
										<li class="count-share"><span class="numb">23</span><span>shares</span></li>
										<li class="email"><a href="https://plus.google.com/share?u=<?php echo htmlentities($url); ?>">Email</a></li>
										<li class="facebook"><a href="http://www.facebook.com/sharer.php?u=<?php echo htmlentities($url); ?>">Facebook</a></li>
										<li class="twitter"><a href="">Twitter</a></li>
										<li class="more"><a href="">More</a></li>
									</ul>
								</div><!-- /.share-post -->
                <div class="main-post">
									<div class="entry-post">
                  <img class="img-fluid rounded" src="admin/postimages/<?php echo htmlentities($row['PostImage']);?>" alt="<?php echo htmlentities($row['posttitle']);?>">
                  <p class="card-text"><?php 
                    $pt=$row['postdetails'];
                     echo  (substr($pt,0));?></p>
                  </div>
                </div>  <!--  details end -->
                <div class="help-post">
										<div class="helpful">
											<a class="like" href="#">I found this helpful </a>
											<a class="dislike" href="#">I did not find this helpful</a>
										</div>
										<div class="tags">
											<a href="#">Startups</a>
											<a href="#">Technology</a>
											<a href="#">Millions of dollars</a>
											<a href="#">Paul Graham</a>
										</div>
									</div><!-- /.help-post -->
            </div>
           </div>
           </div> 
          </div>
        </div>
      </div>
    </div>
  </section>          

<?php } ?>
       

      

     

        </div>

        <!-- Sidebar Widgets Column -->
      <?php include('includes/sidebar.php');?>
      </div>
      <!-- /.row -->
<!---Comment Section --->

 <div class="row" style="margin-top: -8%">
   <div class="col-md-8">
<div class="card my-4">
            <h5 class="card-header">Leave a Comment:</h5>
            <div class="card-body">
              <form name="Comment" method="post">
      <input type="hidden" name="csrftoken" value="<?php echo htmlentities($_SESSION['token']); ?>" />
 <div class="form-group">
<input type="text" name="name" class="form-control" placeholder="Enter your fullname" required>
</div>

 <div class="form-group">
 <input type="email" name="email" class="form-control" placeholder="Enter your Valid email" required>
 </div>


                <div class="form-group">
                  <textarea class="form-control" name="comment" rows="3" placeholder="Comment" required></textarea>
                </div>
                <button type="submit" class="btn btn-primary" name="submit">Submit</button>
              </form>
            </div>
          </div>

  <!---Comment Display Section --->

 <?php 
 $sts=1;
 $query=mysqli_query($con,"select name,comment,postingDate from  tblcomments where postId='$pid' and status='$sts'");
while ($row=mysqli_fetch_array($query)) {
?>
<div class="media mb-4">
            <img class="d-flex mr-3 rounded-circle" src="images/usericon.png" alt="">
            <div class="media-body">
              <h5 class="mt-0"><?php echo htmlentities($row['name']);?> <br />
                  <span style="font-size:11px;"><b>at</b> <?php echo htmlentities($row['postingDate']);?></span>
            </h5>
           
             <?php echo htmlentities($row['comment']);?>            </div>
          </div>
<?php } ?>

        </div>
      </div>
    </div>

  
      <?php include('includes/footer.php');?>


    <!-- Bootstrap core JavaScript -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  </body>

</html>
