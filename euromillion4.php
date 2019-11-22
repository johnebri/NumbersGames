<!DOCTYPE html>
<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">


<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>

	<title>Euromillion 4 Matches</title>
	<style type="text/css" media="all">
		span{
		
			margin: 2px;
			width: 50px;
			padding: 2px;
			background: #B7D1B2;
			display: inline-block;
			border: solid thin black;
			text-align: center;
		}

		.rowNo{
			background: #DDE923;
			font-size: 10px;
			width: 100px;
		}

		.odd {
			background: #E2A7A7;
		}

		.outputSn {
			background: #D5DCFE;
			border-radius: 80px;
		}		
	</style>

		<script language="javascript" type="text/javascript">
			function printDiv(divID) {
				//Get the HTML of div
				var divElements = document.getElementById(divID).innerHTML;
				//Get the HTML of whole page
				var oldPage = document.body.innerHTML;

				//Reset the page's HTML with div's HTML only
				document.body.innerHTML = 
				"<html><head><title></title></head><body><br><br><br>" + divElements + "</body>";

				//Print Page
				window.print();

				//Restore orignal HTML
				document.body.innerHTML = oldPage;
			}
		</script>
</head>
<body>

<div class="container" style="margin-top: 20px;">
	<div class="row">
		<a href="#" onclick="javascript:printDiv('printablediv')">
			<button class="btn btn-primary">Print</button>
		</a>
		<a href="index.php">
			<button class="btn btn-default">Home</a>
		</a>
		<a href="euromillion.php">
			<button class="btn btn-default">Euromillion 3 Matches</a>
		</a>
	</div>
</div>

<?php
	include('functions/connection.php');
	$con = connect();

	$sn = 1;
	$outputSn = 1;

	$rowArr = array();

	// get all the numbers in db in an array
	$query = 'SELECT * FROM euromillion';
	$res = mysqli_query($con, $query) or die(mysqli_error($con));
	
	while($row = mysqli_fetch_assoc($res)) {
		$rowArr[$sn] = array( $row["n1"], $row["n2"], $row["n3"], $row["n4"], $row["n5"] );
		$sn++;
	}

	$rowCount = 1;

	echo '<div id="printablediv">';
	echo '<h2>Euromillion Four Matches as at 25-10-2019</h2>';

	// loop though the array
	for($x=1; $x<=count($rowArr); $x++) {

		$curRow = $rowCount;
		$startRow = $rowCount + 1;
		$dupFound = 0;
		
		for($m=0; $m<count($rowArr[$rowCount]); $m++) {
		    
		    for($n=$m+1; $n<count($rowArr[$rowCount])-$n; $n++) {
		        if($rowArr[$rowCount][$m] == $rowArr[$rowCount][$n]) {
		            // there is a duplicate
		            $dupFound = 1;
		            // echo '<p>Duplicate found</p>';
		           break;
		        }
		    }
		   if($dupFound == 1) {
		       break;
		   } 
		}
		
	
    
    // start if condition for duplicate found here
    if($dupFound == 0) 
    {
        

		for($i=$startRow; $i<=count($rowArr); $i++) {

			$matchCount = 0;
			
			
			for ($a=0; $a<5; $a++) {
			    $seenBreak = 0;
				for ($b=0; $b<5; $b++) {

					if($rowArr[$rowCount][$a] == $rowArr[$i][$b]) {
						$matchCount++;
						$seenBreak = 1;
						break;
					} 
				}
			}

			 if ($matchCount ==4) {
				echo '<span class="outputSn">'.$outputSn.'</span><br>';
				// there was an odd number, get it now
				//move array to temp array
				$tempArr1 = array();
				$tempArr1 = $rowArr[$rowCount];
				$tempArr2 = $rowArr[$rowCount];
    
                // look for the strange numbers
                // first strange no in the top row
				for ($a=0; $a<5; $a++) {
					if(    $rowArr[$rowCount][$a] == $rowArr[$i][0]
						|| $rowArr[$rowCount][$a] == $rowArr[$i][1]
						|| $rowArr[$rowCount][$a] == $rowArr[$i][2]
						|| $rowArr[$rowCount][$a] == $rowArr[$i][3]
						|| $rowArr[$rowCount][$a] == $rowArr[$i][4]
					) {
						
					} else {
						$strangeNo11 = $rowArr[$rowCount][$a];
					}
				}
				
				// get the strange numbers in the bottom row
				// get the first strange no in the bottom row
				for ($a=0; $a<5; $a++) {
					if(    $rowArr[$i][$a] == $rowArr[$rowCount][0]
						|| $rowArr[$i][$a] == $rowArr[$rowCount][1]
						|| $rowArr[$i][$a] == $rowArr[$rowCount][2]
						|| $rowArr[$i][$a] == $rowArr[$rowCount][3]
						|| $rowArr[$i][$a] == $rowArr[$rowCount][4]
					) {
						
					} else {
						$strangeNo21 = $rowArr[$i][$a];
					}
				}
				
				echo '<span class="rowNo">Row=>'.$rowCount. '</span>' ;
				sort($rowArr[$rowCount]);

				foreach($rowArr[$rowCount] as $val) {
					// skip the odd number
					if($val == $strangeNo11 || $val==$strangeNo12) {
						continue;
					}

					echo '<span>'.$val.'</span>';
				}
				echo '=><span class="odd">'.$strangeNo11.'</span>';
				echo '<br>';

				echo '<span class="rowNo"> Row=>'.$i. '</span>' ;
				sort($rowArr[$i]);
				foreach($rowArr[$i] as $val) {
					// skip the odd number
					if($val == $strangeNo21 || $val==$strangeNo22) {
						continue;
					}

					echo '<span>'.$val.'</span>';
				}
				echo '=><span class="odd">'.$strangeNo21.'</span>';

				echo '<hr><br>';
				$outputSn++;

			}
			
			
			
			/*else if ($matchCount == 5) {
				echo '<span class="outputSn">'.$outputSn.'</span><br>';
				// no strage numbers, all the same
				// echo '<h5>Five numbers matched</h5>';
				echo '<span class="rowNo"> Row=>'.$rowCount. '</span>' ;
				sort($rowArr[$rowCount]);
				foreach($rowArr[$rowCount] as $val) {
					echo '<span>'.$val.'</span>';
				}

				echo '<br>';

				echo '<span class="rowNo"> Row=>'.$i. '</span>' ;
				sort($rowArr[$i]);
				foreach($rowArr[$i] as $val) {
					echo '<span>'.$val.'</span>';
				}

				echo '<br>';
				echo '<br><hr><br>';
				$outputSn++;
			}*/ 
		}
		
	
    }	
	// end if condition for duplicate found here
		
		$rowCount++;	

	}

	echo '</div>';	

?>
			

						
</body>
</html>