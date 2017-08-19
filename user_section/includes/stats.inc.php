<?php 
function getStats($param){
  include("DBConnection.inc.php");

  if($param == 'total'){
      $sqlQuery1="SELECT COUNT(*) AS countTotal FROM `tbl_compliant`";
            $qRes = $con->query($sqlQuery1);
            $total = $qRes->fetch_assoc();
            return $total["countTotal"];
  }elseif($param == 'replied'){
        $sqlQuery2="SELECT COUNT(*) AS countReplied FROM `tbl_compliant` WHERE `status`=1";
              $qRes2 = $con->query($sqlQuery2);
              $totalReplied = $qRes2->fetch_assoc();
              return $totalReplied["countReplied"];
  }elseif($param == 'pending'){
        $sqlQuery3="SELECT COUNT(*) AS countPending FROM `tbl_compliant` WHERE `status`=0";
                $qRes3 = $con->query($sqlQuery3);
                $totalPending = $qRes3->fetch_assoc();
                return $totalPending["countPending"];
  }
  elseif($param == 'resolved'){
        $sqlQuery4="SELECT COUNT(*) AS countResolved FROM `tbl_compliant` WHERE `resolvedFlag` ='Y'";
                $qRes4 = $con->query($sqlQuery4);
                $totalResolved = $qRes4->fetch_assoc();
                return $totalResolved["countResolved"];
  }
  elseif($param == 'notResolved'){
        $sqlQuery5="SELECT COUNT(*) AS countNotResolved FROM `tbl_compliant` WHERE `resolvedFlag` ='N'";
                $qRes5 = $con->query($sqlQuery5);
                $totalNotResolved = $qRes5->fetch_assoc();
                return $totalNotResolved["countNotResolved"];
  }
  $con->close();
}
?>