<!--------------------------php for the data base---------------------------->
<?php 
$title = "PHP Friend List";

class MyDB extends SQLite3 {
    function __construct() {
       $this->open('friends.db');
    }
 }

 $db = new MyDB();
 if(!$db) {
    echo $db->lastErrorMsg();
    exit();
 } 

 ?>
<!------------------------------------------------------>

<!-------------------------HTML for the outpout and form----------------------------->
<h2>My friends</h2>

<title><?php echo "$title"?></title>
 <form action ='index.php' method='post'>
   Name : <input type='text' name='name' value ='' size='12'><br>
   Surname : <input type='text' name='surname' value ='' size='12'><br> 
   email : <input type='text' name='email' value ='' size='12'><br>
   <input type='checkbox' name='startingWith' value ='TRUE' checked>Only names starting with<br>
   <input name ='action' type='submit' value='Search'> 
   <br> 
</form>

<h2> My Friends Search</h2>
<!------------------------------------------------------>

<!-------------------------PHP for the backend of the form----------------------------->
<?php

$name = $surname = $email = $action = $startingWith = "";

 if (isset($_POST["action"])) {
   $name = $_POST["name"];
   $surname = $_POST["surname"];
   $email = $_POST["email"];
   $action = $_POST["action"];
   $startingWith = $_POST["startingWith"];
 }

 $sql = "select * from friend";

 if($action == "Search"){

   if($startingWith == false){ 
      echo "<p style = 'color : red'>Here there is a warning, but the form do the job</p>";
      $sql .= " WHERE name LIKE '%$name%' AND surname LIKE '%$surname%' AND email LIKE '%$email%' ";
   }
   else{
      if(empty($name)){
         echo "<p style = 'color : red'>if you want to use the 'Only starting search', please complete the input 'Name'</p>"; 
      }
      else{
         $pos = strpos($name, $name);
         $sql .= " WHERE name LIKE '%$name%' AND surname LIKE '%$surname%' AND email LIKE '%$email%' ";
      }
   }
  
 }


 $ret = $db->query($sql);
 $i = $indexToBeRemoved = 0;
 while($row = $ret->fetchArray(SQLITE3_ASSOC) ) {
   $i = $row['id'];
    echo $row['id']  ." ".$row['name'] ." ". $row['surname'] ." [". $row['email'] ."] ". "<button type='submit' name='delete' value ='$i'>Delete</button><br>";
}

if (isset($_POST['delete'])) {
   $indexToBeRemoved = $_POST['delete'];
   $sql = "DELETE FROM friend WHERE $indexToBeRemoved = $i";
   echo $i; 
}

/*if ($action="add"){
   if(empty($name)||empty($surname)||empty($email)){
      echo"<script> alert('pls complete the form to add a new Friend');</script>";
   }
   else{
      $sql =" INSERT INTO friend (name , surname, email) VALUES ($name,$surname,$email)";
   }
}*/

 $db->close();
 ?>
 <!------------------------------------------------------>