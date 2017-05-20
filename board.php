<html>
<head><title>Message Board</title></head>
<body>
<form method="get" action="board.php">
    <input type="submit" name="out" value="logout"/>
</form>
<form action =board.php method=POST>
<input type="text" id="newm" name="newm"/>
<input type="submit" name="submit" value="new post"/>
</form>
<?php
 session_start();
error_reporting(E_ALL);


ini_set('display_errors','On');
try {
  $dbh = new PDO("mysql:host=127.0.0.1:3306;dbname=board","root","",array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
 // print_r($dbh);
  if(isset($_GET['out'])){
    session_destroy();
    header('Location: login.php');
    exit();
  }
  if(isset($_POST['uname']) && isset($_POST['pass'])){
    $get = 'SELECT username,password from USERS where username="'.$_POST['uname'].'"';
    $res = $dbh->query($get,PDO::FETCH_ASSOC);
    $res = $res->fetchAll();
    if($res[0]['password']== md5($_POST['pass'])){
     
      $_SESSION["postedbyw"] = $res[0]['username'];
    }
    else{
      header('Location: login.php');
    exit();
    }
    //echo md5('12345');
  }
  if(isset( $_SESSION['postedbyw'])){
  if(isset($_POST["newm"])){
  $insert = 'INSERT INTO POSTS VALUES(:id,:replyto,:postedby,now(),:message)';
  $sth = $dbh->prepare($insert, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
  $sth->execute(array(':id' => uniqid(), ':replyto' => null, ':postedby'=> $_SESSION['postedbyw'],':message'=> $_POST['newm']));
  }

   if(isset($_GET["replyto"])){
   $uuid = uniqid();
   $insert = 'INSERT INTO POSTS VALUES(:id,:replyto,:postedby,now(),:message)';
   $sth = $dbh->prepare($insert, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
   $sth->execute(array(':id' => $uuid, ':replyto' => null, ':postedby'=> $_SESSION['postedbyw'],':message'=> $_GET['reply']));
   $update = 'UPDATE posts SET replyto=:replyid where id=:uid';
   $sth = $dbh->prepare($update, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
   $sth->execute(array(':replyid' =>$_GET['replyto'] , ':uid'=>$uuid));
   }
  
    //$dbh->beginTransaction();
  //$dbh->exec('delete from users where username="smith"');
  // $dbh->exec('insert into users values("smith","' . md5("mypass") . '","John Smith","smith@cse.uta.edu")')
  //       or die(print_r($dbh->errorInfo(), true));
  // $dbh->commit();

   $sql = 'select * from posts inner join users where posts.postedby = users.username order by datetime DESC';
  
 //  $stmt->execute();
   print "<pre>";
  foreach ($dbh->query($sql) as $row)  {
    // print_r($row);
     echo '<form>';
     echo '<input type=hidden name="replyto" value="'.$row['id'].'"/>';
     print'<b>Message Id: </b>'.$row['id']."\n";
     if($row['replyto']!=null)
      print'<b>Replied to Message with message Id: </b>'.$row['replyto']."\n";
     print'<b>Username: </b>'.$row['username']."\n".'<b>Full Name: </b>'.$row['fullname']."\n";
     print'<b>Date and Time: </b>'.$row['datetime']."\n";
     print'<b>Message: </b>'.$row['message']."\n";
     echo '<input type="text" id="reply" name="reply"/>';
     echo '<button type="submit" formaction="board.php">Reply</button></form>';
     print "\n\n\n\n";
  }
   print "</pre>";
 }
 else{
  header('Location: login.php');
    exit();
 }
 } 
catch (PDOException $e) {
  print "Error!: " . $e->getMessage() . "<br/>";
  die();
}
?>

</body>

</html>
