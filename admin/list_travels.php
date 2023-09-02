<?php include_once 'header.php'; ?>
<?php include_once 'footer.php';
require '../helpers/init_conn_db.php';?>
<?php
if(isset($_POST['del_travels']) and isset($_SESSION['adminId'])) {
  $travels_id = $_POST['travels_id'];
  $sql = 'DELETE FROM travels WHERE travels_id=?';
  $stmt = mysqli_stmt_init($conn);
  if(!mysqli_stmt_prepare($stmt,$sql)) {
      header('Location: ../index.php?error=sqlerror');
      exit();            
  } else {  
    mysqli_stmt_bind_param($stmt,'i',$travels_id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
    // header('Location: list_travels.php');
    echo("<script>location.href = 'list_travels.php';</script>");
    exit();
  }
}
?>

<style>
table {
  background-color: white;
}
h1 {
  margin-top: 20px;
  margin-bottom: 20px;
  font-family: 'product sans';  
  font-size: 45px !important; 
  font-weight: lighter;
}
a:hover {
  text-decoration: none;
}
body {
  /* background-color: #B0E2FF; */
  background-color: #efefef;
}
th {
  font-size: 22px;
  /* font-weight: lighter; */
  /* font-family: 'Courier New', Courier, monospace; */
}
td {
  margin-top: 10px !important;
  font-size: 16px;
  font-weight: bold;
  font-family: 'Assistant', sans-serif !important;
}
</style>
    <main>
        <?php if(isset($_SESSION['adminId'])) { ?>
          <div class="container-md mt-2">
            <h1 class="display-4 text-center text-secondary"
              >Travels LIST</h1>
            <table class="table table-bordered">
              <thead class="table-dark">
                <tr>
                  <th scope="col">#</th>
                  <th scope="col">Name</th>
                  <th scope="col">Seats</th>
                  <th scope="col">Action</th>

                </tr>
              </thead>
              <tbody>
                
                <?php
                $cnt=1;
                $sql = 'SELECT * FROM travels ORDER BY travels_id ASC';
                $stmt = mysqli_stmt_init($conn);
                mysqli_stmt_prepare($stmt,$sql);                
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);
                while ($row = mysqli_fetch_assoc($result)) {
                  echo "
                  <tr class='text-center'>                  
                    <td scope='row'>".$cnt." </a> </td>
                    <td>".$row['name']."</td>
                    <td>".$row['seats']."</td>
                    <td>
                    <form action='list_travels.php' method='post'>
                      <input name='travels_id' type='hidden' value=".$row['travels_id'].">
                      <button  class='btn' type='submit' name='del_travels'>
                      <i class='text-danger fa fa-trash'></i></button>
                    </form>
                    </td>                  
                  </tr>
                  ";
               $cnt++; }
                ?>

              </tbody>
            </table>

          </div>
        <?php } ?>

    </main>
