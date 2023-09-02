<?php include_once 'header.php'; ?>
<?php include_once 'footer.php';
require '../helpers/init_conn_db.php'; ?>
<?php
if (isset($_POST['del_tikcet']) && isset($_SESSION['adminId'])) {
    $ticket_id = $_POST['ticket_id'];
    $sql = 'DELETE FROM ticket WHERE ticket_id=?';
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header('Location: ../index.php?error=sqlerror');
        exit();
    } else {
        mysqli_stmt_bind_param($stmt, 'i', $ticket_id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
        // header('Location: booking.php');
        echo ("<script>location.href = 'booking.php';</script>");
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
    <?php if (isset($_SESSION['adminId'])) { ?>
        <div class="container-md mt-2">
            <h1 class="display-4 text-center text-secondary">Booking Details</h1>
            <table class="table table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">Booking ID</th>
                        <th scope="col">User Name</th>
                        <th scope="col">Phone No</th>
                        <th scope="col">Seat No</th>
                        <th scope="col">Departure</th>
                        <th scope="col">Price</th>
                        <th scope="col">Action</th>

                    </tr>
                </thead>
                <tbody>

                    <?php
                    $cnt = 1;
                    $sql = 'SELECT t.ticket_id,u.username, p.mobile, t.seat_no, b.departure, t.cost
                    FROM passenger_profile p
                    INNER JOIN ticket t ON p.passenger_id = t.passenger_id
                    INNER JOIN bus b ON t.bus_id = b.bus_id
                    INNER JOIN users u ON t.user_id = u.user_id';

                    $stmt = mysqli_stmt_init($conn);
                    mysqli_stmt_prepare($stmt, $sql);
                    mysqli_stmt_execute($stmt);
                    $result = mysqli_stmt_get_result($stmt);
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "
                  <tr class='text-center'>                  
                    <td scope='row'>" . $cnt . " </a> </td>
                    <td>" . $row['ticket_id'] . "</td>
                    <td>" . $row['username'] . "</td>
                    <td>" . $row['mobile'] . "</td>
                    <td>" . $row['seat_no'] . "</td>
                    <td>" . $row['departure'] . "</td>
                    <td>" . $row['cost'] . "</td>
                    
                    <td>
                    <form action='booking.php' method='post'>
                      <input name='ticket_id' type='hidden' value=" . $row['ticket_id'] . ">
                      <button  class='btn' type='submit' name='del_tikcet'>
                      <i class='text-danger fa fa-trash'></i></button>
                    </form>
                    </td>                  
                  </tr>
                  ";
                        $cnt++;
                    }
                    ?>

                </tbody>
            </table>

        </div>
    <?php } ?>

</main>