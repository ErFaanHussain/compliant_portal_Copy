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
	}else{
				$sqlQuery3="SELECT COUNT(*) AS countPending FROM `tbl_compliant` WHERE `status`=0";
                $qRes3 = $con->query($sqlQuery3);
                $totalPending = $qRes3->fetch_assoc();
                return $totalPending["countPending"];
	}
}

?>