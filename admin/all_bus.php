<?php include_once 'header.php'; ?>
<?php include_once 'footer.php';
require '../helpers/init_conn_db.php';?>
<?php
if(isset($_POST['del_bus']) and isset($_SESSION['adminId'])) {
  $bus_id = $_POST['bus_id'];
  $sql = 'DELETE FROM Bus WHERE bus_id=?';
  $stmt = mysqli_stmt_init($conn);
  if(!mysqli_stmt_prepare($stmt,$sql)) {
      header('Location: ../index.php?error=sqlerror');
      exit();            
  } else {  
    mysqli_stmt_bind_param($stmt,'i',$bus_id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
    // header('Location: all_bus.php');
    echo("<script>location.href = 'all_bus.php';</script>");
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
              >BUS LIST</h1>
            <table class="table table-bordered">
              <thead class="table-dark">
                <tr>
                  <th scope="col">ID</th>
                  <th scope="col">Arrival</th>
                  <th scope="col">Departure</th>
                  <th scope="col">Source</th>
                  <th scope="col">Destination</th>
                  <th scope="col">Travels</th>
                  <th scope="col">Seats</th>
                  <th scope="col">Price</th>
                  <th scope="col">Action</th>
                </tr>
              </thead>
              <tbody>
                
                <?php
                $sql = 'SELECT * FROM Bus ORDER BY bus_id DESC';
                $stmt = mysqli_stmt_init($conn);
                mysqli_stmt_prepare($stmt,$sql);                
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);
                while ($row = mysqli_fetch_assoc($result)) {
                  echo "
                  <tr class='text-center'>                  
                    <td scope='row'>
                      <a href='pass_list.php?bus_id=".$row['bus_id']."'>
                      ".$row['bus_id']." </a> </td>
                    <td>".$row['arrivale']."</td>
                    <td>".$row['departure']."</td>
                    <td>".$row['source']."</td>
                    <td>".$row['Destination']."</td>
                    <td>".$row['travel_name']."</td>
                    <td>".$row['Seats']."</td>
                    <td>RS. ".$row['Price']."</td>
                    
                    <td>
                    <form action='all_bus.php' method='post'>
                      <input name='bus_id' type='hidden' value=".$row['bus_id'].">
                      <button  class='btn' type='submit' name='del_bus'>
                      <i class='text-danger fa fa-trash'></i></button>
                    </form>
                    </td>                  
                  </tr>
                  ";
                  
                }
                ?>

              </tbody>
            </table>

          </div>
        <?php } ?>

    </main>
