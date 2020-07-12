<?php
  require "header.php";
  require 'includes/dbh.inc.php';

  $sql = "SELECT * FROM seasons";
  $stmt = mysqli_stmt_init($conn);
  if(!mysqli_stmt_prepare($stmt, $sql)) {
    header("Location: manageleague.php?error=sqlerror");
    exit();
  }
  mysqli_stmt_execute($stmt);
  $season_result = mysqli_stmt_get_result($stmt);
  $season_rows = mysqli_fetch_array($season_result);
  mysqli_stmt_close($stmt);

  $sql = "SELECT * FROM tracks";
  $stmt = mysqli_stmt_init($conn);
  if(!mysqli_stmt_prepare($stmt, $sql)) {
    header("Location: manageleague.php?error=sqlerror");
    exit();
  }
  mysqli_stmt_execute($stmt);
  $tracks_result = mysqli_stmt_get_result($stmt);
  $tracks_rows = mysqli_fetch_all($tracks_result);
  mysqli_stmt_close($stmt);

 ?>

 <main>
   <div class="container">
       <form>
         <?php
         for ($i=0; $i < $season_rows['rounds']; $i++) {
           $round = $i + 1;
           echo "
           <div class=\"row\">
           <label id=\"round".$round."\" class=\"col-lg-3\">Round ".$round.":<span class=\"col-lg-6\"><select id=\"tracks\" name=\"round".$round."\">";
           foreach ($tracks_rows as $key => $value) {
             echo "<option value=\"".$value[0]."\">".$value[1]."</option>";
           }
           echo "</select></span></label><span class=\"col-lg-3\"></span></div>";
         }
         ?>
       </form>
     </div>
   </div>
 </main>

 <?php
   require "footer.php";
  ?>
