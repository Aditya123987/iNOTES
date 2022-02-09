<?php 
$servername="localhost";
$username ="root";
$password="";
$database="crud";
$connection=mysqli_connect($servername,$username,$password,$database);
 //connection to mysql server
 $insert=false;
 $update=false;
 $delete=false;
if(!$connection){
    die("errorfddfdsfsdf " . mysqli_connect_error());
}
  if(isset($_GET['delete'])){
    $sno=$_GET['delete'];
    $sql="DELETE FROM `crud` WHERE `crud`.`sno` = '$sno';";
    $result=mysqli_query($connection,$sql);
    $delete=true;
    header("phptuto/crud.php");
  }
  if($_SERVER['REQUEST_METHOD'] == 'POST'){
    if(isset($_POST['snoEdit'])){
      $sno=$_POST['snoEdit'];
      $name=$_POST['nameEdit'];
      $desc=$_POST['desEdit'];
    $sql="UPDATE `crud` SET `name` = '$name',`des`='$desc' WHERE `crud`.`sno` = $sno";
  $result=mysqli_query($connection,$sql);
  if($result){
    $update=true;
  }else{
     echo '
     <div class="alert alert-success" role="alert">
    Technical Error..Not Submiited..
 </div>';
  }
     
   }
  

    else{
    $name=$_POST['name'];
    $desc=$_POST['des'];
    

  $sql="INSERT INTO `crud` ( `name`, `des`) VALUES ( '$name', '$desc');";
  $result=mysqli_query($connection,$sql);
   if($result){
     $insert=true;
   }else{
      echo '
      <div class="alert alert-success" role="alert">
     Technical Error..Not Submiited..
  </div>';
   }
  }}
?>
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">


 
    <link rel="stylesheet" href="//cdn.datatables.net/1.11.4/css/jquery.dataTables.min.css">
    <title>CRUD App</title>
  </head>
  <body>
  
<!-- Modal -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Task</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="/phptuto/crud.php" method="POST">
          <div class="mb-3">
            <input type="hidden" name="snoEdit" id="snoEdit">
            <label for="exampleInputEmail1" class="form-label">Name Edit</label>
            <input type="name" name="nameEdit" class="form-control" id="nameEdit" aria-describedby="emailHelp">
           
          </div>
          <div class="form-floating">
          <textarea class="form-control" name="desEdit" placeholder="Leave a comment here" id="desEdit" style="height: 100px"></textarea>
          <label for="floatingTextarea2">Description Edit</label>
        </div>
         
          <button type="submit" class="btn btn-primary mt-5">Update Task</button>
        </form>
      </div>
     
    </div>
  </div>
</div>

  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">CRUD</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="#">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">About Us</a>
        </li>
      
        <li class="nav-item">
          <a class="nav-link" href="#">Contact Us</a>
        </li>
      </ul>
     
    </div>
  </div>
</nav>
<?php 
if($insert){
  echo   '<div class="alert alert-success alert-dismissible fade show" role="alert">
 Inserted Successfully...
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
  <span aria-hidden="true">x</span>
</button>
</div>';
}
?>
<?php 
if($delete){
  echo   '<div class="alert alert-success alert-dismissible fade show" role="alert">
Deleted Successfully...
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
  <span aria-hidden="true">x</span>
</button>
</div>';
}
?>
<?php 
if($update){
  echo   '<div class="alert alert-success alert-dismissible fade show" role="alert">
 Updated Successfully...
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
  <span aria-hidden="true">x</span>
</button>
</div>';
}
?>

<div class="container my-5">
<form action="/phptuto/crud.php" method="POST">
  <div class="mb-3">
    <label for="exampleInputEmail1" class="form-label">Task Name</label>
    <input type="name" name="name" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
   
  </div>
  <div class="form-floating">
  <textarea class="form-control" name="des" placeholder="Leave a comment here" id="floatingTextarea2" style="height: 100px"></textarea>
  <label for="floatingTextarea2">Description</label>
</div>
 
  <button type="submit" class="btn btn-primary mt-5">Add Task</button>
</form>
</div>
<div class="container mb-5">

  <table class="table" id="myTable">
  <thead>
    <tr>
      <th scope="col">SNo.</th>
      <th scope="col">Task Name</th>
      <th scope="col">Task Desc</th>
      <th scope="col">Actions</th>
    </tr>
  </thead>
  <tbody>
  <?php
       $sql="SELECT * FROM `crud`";
       $result=mysqli_query($connection,$sql);
       $sno=0;
       while($row=mysqli_fetch_assoc($result)){
           $sno++;
           echo "<tr>
           <th scope='row'>".$sno."</th>
           <td>".$row['name']."</td>
           <td>".$row['des']."</td>
           <td><button type='button' class='btn btn-primary edit' id=".$row['sno'].">Edit</button> <button type='button' class='btn btn-danger delete' id=d".$row['sno'].">Delete</button></td>
         </tr>";
       }
  ?>
    
   
  </tbody>
</table>
</div>

    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->   <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
  
    <script src="//cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"
    integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6"
    crossorigin="anonymous"></script>
       <script>
         
       $(document).ready( function () {
    $('#myTable').DataTable();
} );
</script>
<script >
  edits=document.getElementsByClassName('edit');
  Array.from(edits).forEach((edit)=>{
    edit.addEventListener('click', (e)=>{

      tr=e.target.parentNode.parentNode;
      title=tr.getElementsByTagName("td")[0].innerText;
      description=tr.getElementsByTagName("td")[1].innerText;
      nameEdit.value=title;
      desEdit.value=description;
      snoEdit.value=e.target.id;
      $('#editModal').modal('toggle');
    })
  })

  deletes=document.getElementsByClassName('delete');
  Array.from(deletes).forEach((ele)=>{
   ele.addEventListener('click', (e)=>{

      sno=e.target.id.substr(1,);
      if(confirm("Are u sure?")){
        console.log("yes");
        window.location=`/phptuto/crud.php?delete=${sno}`;
      }else console.log("no");
      
    })
  })
</script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
    -->
  </body>
</html>