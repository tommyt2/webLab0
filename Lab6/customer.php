<!DOCTYPE html>
<html>
	<head>
		<title>Fruit Store</title>
		<link href="http://selab.hanyang.ac.kr/courses/cse326/2015/problems/pResources/gradestore.css" type="text/css" rel="stylesheet" />
	</head>

	<body>
		<?php
			$name =$_POST['name'];
			$id = $_POST['id'];
			$fruits=$_POST['fruits'];
			$qty=$_POST['qty'];
			$creditCard=$_POST['credit'];
			$cc=$_POST['cc'];
		?>
		
		
		<?php
		# Ex 4 : 
		# Check the existance of each parameter using the PHP function 'isset'.
		# Check the blankness of an element in $_POST by comparing it to the empty string.
		# (can also use the element itself as a Boolean test!)
		if (!isset($_POST["name"])
                      ||!isset($_POST["id"])
                      ||!isset($_POST["fruits"])
                      ||!isset($_POST["qty"])
                      ||!isset($_POST["credit"])
					  ||!isset($_POST["cc"])
                      ||$_POST["name"] == ""
                      ||$_POST["id"] == ""
                      ||$_POST["fruits"] == ""
					  ||$_POST["qty"] == ""
                      ||$_POST["credit"] == ""
                      ||$_POST["cc"] == ""
                      ){
		?>

		<!-- Ex 4 : 
			Display the below error message : --> 
			<h1>Sorry</h1>
			<p>You didn't fill out the form completely.<a href="http://localhost/fruitstore/fruitstore/fruitstore.html">Try again?</a></p>
		

		<?php
		# Ex 5 : 
		# Check if the name is composed of alphabets, dash(-), ora single white space.
		}elseif(!preg_match("/^[a-zA-Z]+[a-zA-Z(\s)?(-)?]+(-)?(\s)?[a-zA-Z(\s)?(-)?]+[a-zA-Z]+$/", $name) ){
		?>

		<!-- Ex 5 : 
			Display the below error message : --> 
			<h1>Sorry</h1>
			<p>You didn't provide a valid name. <a href="http://localhost/fruitstore/fruitstore/fruitstore.html">Try again?</a></p>
		

		<?php
		# Ex 5 : 
		# Check if the credit card number is composed of exactly 16 digits.
		# Check if the Visa card starts with 4 and MasterCard starts with 5. 
		}elseif( !preg_match("/^[0-9]{16}$/", $creditCard) ){
		?>

		<!-- Ex 5 : 
			Display the below error message : --> 
			<h1>Sorry</h1>
			<p>You didn't provide a valid credit card number. <a href="http://localhost/fruitstore/fruitstore/fruitstore.html">Try again?</a></p>
		
		<?php
		}elseif($cc=="Visa" &&!preg_match("/^4/", $_POST['credit']) ){ ?>
			<h1>Sorry</h1>
			<p>You didn't provide a valid Visa credit card number. <a href="http://localhost/fruitstore/fruitstore/fruitstore.html">Try again?</a></p>
		
		<?php 
		}elseif($cc=="MasterCard" && !preg_match("/^5/", $_POST['credit']) ){  ?>
			<h1>Sorry</h1>
			<p>You didn't provide a valid MasterCard credit card number. <a href="http://localhost/fruitstore/fruitstore/fruitstore.html">Try again?</a></p>
		<?php
		# if all the validation and check are passed 
		} else {
		?>

		<h1>Thanks!</h1>
		<p>Your information has been recorded.</p>
		
		<!-- Ex 2: display submitted data -->
		<ul> 
			<li>Name: <?=$name?></li>
			<li>Membership Number: <?=$id?></li>
			<li>Options: <?=processCheckbox($_POST['type'])?></li>
			<li>Fruits: <?=$fruits?> - <?=$qty?></li>
			<li>Credit <?=$creditCard?> (<?=$cc?>) </li>
		</ul>
		
		<!-- Ex 3 : -->
			<p>This is the sold fruits count list:</p> 
		<?php
			$filename = "customers.txt";
			/* Ex 3: 
			 * Save the submitted data to the file 'customers.txt' in the format of : "name;membershipnumber;fruit;number".
			 * For example, "Scott Lee;20110115238;apple;3"
			 */
			$data[] = $_POST['name'];
			$data[] = $_POST['id'];
			$data[] = $_POST['fruits'];
			$data[] = $_POST['qty'];
			$insert = implode(";", $data);
			file_put_contents($filename,$insert."\r\n",FILE_APPEND);
			 
		?>
		
		<!-- Ex 3: list the number of fruit sold in a file "customers.txt".
			Create unordered list to show the number of fruit sold -->
		<ul>
		<?php 
		$fruitcounts = soldFruitCount($filename);
		foreach($fruitcounts as $countfruit) { $temp = explode(" ", $countfruit); ?>
		<li><?=$temp[0]?>=><?= $temp[1] ?></li>
		<?php
		}
		?>
		</ul>
		
		<?php
		 }
		?>
		<?php
			/* Ex 3 :
			* Get the fruits species and the number from "customers.txt"
			* 
			* The function parses the content in the file, find the species of fruits and count them.
			* The return value should be an key-value array
			* For example, array("Melon"=>2, "Apple"=>10, "Orange" => 21, "Strawberry" => 8)
			*/
			function soldFruitCount($filename) { 
				$insert=array();
				$data=file($filename);
				
				foreach($data as $data1){
					$temp=explode(";", $data1);
					$arraydata=array_slice($temp, 2);
					$insert[]=implode(" ",$arraydata);
				}
				return $insert;
			}
			
			function processCheckbox($typename){
				$temp=implode(", ",$typename);
				return $temp;
			}
		?>
		
	</body>
</html>
