<!DOCTYPE html>
<html>
<head>
    <title>Course list</title>
    <meta charset="utf-8" />
    <link href="courses.css" type="text/css" rel="stylesheet" />
</head>
<body>
<div id="header">
    <h1>Courses at CSE</h1>
<!-- Ex. 1: File of Courses -->
    <?php
		$filename="courses.tsv";
		$lines=file($filename);
	?>
	
	<p>
        Course list has <?=count($lines)?> total courses
        and
        size of <?= filesize($filename)?> bytes.
    </p>
	
</div>
<div class="article">
    <div class="section">
        <h2>Today's Courses</h2>
<!-- Ex. 2: Today’s Courses & Ex 6: Query Parameters -->
        <?php
		$numberofCourses=3;
		
            function getCoursesByNumber($listOfCourses, $numberOfCourses){
                $resultArray = array();
//                implement here.
				shuffle($listOfCourses);
				foreach ($listOfCourses as $course) {
					$resultArray[] = $course;
					if (count($resultArray) == $numberOfCourses) break; 
				}
                return $resultArray;
            }
			
			if(isset($_GET["number_of_course"])){
				$todaysCourses=getCoursesbyNumber($lines,$_GET["number_of_course"]);
			}else{
				$todaysCourses=getCoursesbyNumber($lines,3);
			}
        ?>
		
		<ol> <?php foreach($todaysCourses as $todaycourse){ $temp = explode("\t", $todaycourse); ?>
        	<li><?=$temp[0]?> - <?= $temp[1] ?></li>
        	<?php } ?>
		</ol>
		
    </div>
    <div class="section">
        <h2>Searching Courses</h2>
<!-- Ex. 3: Searching Courses & Ex 6: Query Parameters -->
        
		<?php
		$startCharacter="E";
		
            function getCoursesByCharacter($listOfCourses, $startCharacter){
                $resultArray = array();
//                implement here.

				foreach($listOfCourses as $course){
				$temp=explode("\t", $course);
					if (substr($temp[0],0,1)  == $startCharacter) {
						$resultArray[] = $course; 
					}
				}
                return $resultArray;
            }
			
			if (isset($_GET["character"])) {
				$searchedCourses = getCoursesByCharacter($lines, $_GET["character"]);
			}
			else {
				$searchedCourses = getCoursesByCharacter($lines,$startCharacter);
			}
        ?>
		
		<p>Words that started by <strong>'<?=$startCharacter?>'</strong> are followings : </p>
		
		<ol>	
			<?php foreach ($searchedCourses as $searchCourse) { $temp = explode("\t", $searchCourse); ?>
        		<li><?= $temp[0] ?> - <?= $temp[1] ?></li>
        	<?php } ?>
    	</ol>
		
    </div>
    <div class="section">
        <h2>List of Courses</h2>
<!-- Ex. 4: List of Courses & Ex 6: Query Parameters -->
        <?php
			$orderby=[0,1];
			
            function getCoursesByOrder($listOfCourses, $orderby){
                $resultArray = $listOfCourses;
//                implement here.		
			if($orderby==0){
				sort($resultArray);
				print"All of courses ordered by <strong>alphabet order</strong> are followings :";
			}else if($orderby==1){
				rsort($resultArray);
				print"All of courses ordered by <strong>alphabet reverse order</strong> are followings :";
			}
			
                return $resultArray;
          }
			
        ?>
		
		<?php
			if (isset($_GET["orderby"])) {
				$orderedCourses = getCoursesByOrder($lines, $_GET["orderby"]);
			}
			else {
				$orderedCourses = getCoursesByOrder($lines,$orderby[0]);
			}
		?>	
	
		
		<ol>	
			<?php foreach ($orderedCourses as $orderedCourse) { $temp = explode("\t", $orderedCourse); ?>
        		<li><?= $temp[0] ?> - <?= $temp[1] ?></li>
        	<?php } ?>
    	</ol>
	
    </div>
    <div class="section">
	
        <h2>Adding Courses</h2>
<!-- Ex. 5: Adding Courses & Ex 6: Query Parameters -->
		<?php
		$result=" ";
	
		if(isset($_GET["new_course"],$_GET["code_of_course"])){
			$newCourse=$_GET["new_course"];
			$codeOfCourse=$_GET["code_of_course"];
			$result = $newCourse . "	" . $codeOfCourse ."\n";
			file_put_contents("courses.tsv", $result, FILE_APPEND);
			print "Adding a course is success!";
			}else{
			print "Input course or code of the course doesn't exist.";
		}
	
		?>
		
		
        <p></p>
    </div>
</div>
<div id="footer">
    <a href="http://validator.w3.org/check/referer">
        <img src="http://selab.hanyang.ac.kr/courses/cse326/2015/problems/images/w3c-html.png" alt="Valid HTML5" />
    </a>
    <a href="http://jigsaw.w3.org/css-validator/check/referer">
        <img src="http://selab.hanyang.ac.kr/courses/cse326/2015/problems/images/w3c-css.png" alt="Valid CSS" />
    </a>
</div>
</body>
</html>