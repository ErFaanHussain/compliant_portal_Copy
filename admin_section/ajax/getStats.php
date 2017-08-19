<?php
include('../includes/core.inc.php');
if(!logged_in()){
  echo 'not logged in';
}

if(isset($_POST['depttID']) && !empty($_POST['depttID'])){
  $deptId = $_POST['depttID'];
			$sqlQuery1="SELECT COUNT(*) AS countTotal FROM `tbl_compliant` WHERE `DeptID`=".$deptId;
      include("../includes/DBConnection.inc.php");
            $qRes = $con->query($sqlQuery1);
            $total1 = $qRes->fetch_assoc();
                $total = $total1["countTotal"];

			  $sqlQuery2="SELECT COUNT(*) AS countReplied FROM `tbl_compliant` WHERE `status`= 1 AND `DeptID`=".$deptId;
              $qRes2 = $con->query($sqlQuery2);
              $totalReplied = $qRes2->fetch_assoc();
              $replied = $totalReplied["countReplied"];

				$sqlQuery3="SELECT COUNT(*) AS countPending FROM `tbl_compliant` WHERE `status`= 0 AND `DeptID`=".$deptId;
                $qRes3 = $con->query($sqlQuery3);
                $totalPending = $qRes3->fetch_assoc();
                $pending = $totalPending["countPending"];

        $sqlQuery4="SELECT COUNT(*) AS countResolved FROM `tbl_compliant` WHERE `resolvedFlag` ='Y' AND `DeptID`=".$deptId;
                $qRes4 = $con->query($sqlQuery4);
                $totalResolved = $qRes4->fetch_assoc();
                $resolved = $totalResolved["countResolved"];
                
        $sqlQuery5="SELECT COUNT(*) AS countNotResolved FROM `tbl_compliant` WHERE `resolvedFlag` ='N' AND `DeptID`=".$deptId;
                $qRes5 = $con->query($sqlQuery5);
                $totalNotResolved = $qRes5->fetch_assoc();
                $notResolved = $totalNotResolved["countNotResolved"];

                header('Content-Type: application/json');
                $j=json_encode(array('status' => 'success','totalComp' => $total,'repliedComp' => $replied, 'pendingComp' => $pending, 'resolvedComp' => $resolved, 'notResolvedComp' => $notResolved));
                echo $j;
                $con->close();
	}
