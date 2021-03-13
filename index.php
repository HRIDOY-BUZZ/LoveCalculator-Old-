<?php
  include('db.php');
  if(isset($_POST['submit']))
    {  
      if(isset($_POST['name1']) && isset($_POST['name2']))
        {
          $name1 = $_POST['name1'];
          $name2 = $_POST['name2'];

          $arr = array(strtolower($name1), "loves" , strtolower($name2));

          $full = join("",$arr);

          unset($arr);

          $count = array();

          for($i = 0; $i < strlen($full); $i++)
          {
            if($full[$i]=='-' || $full[$i]==')' || $full[$i]=='(' || $full[$i]==' ')
            {
              continue;
            }
            if($full[$i]!='0')
              $count[$i] = 1;
            for($j = $i+1; $j < strlen($full); $j++)
            {
              if($full[$i]==$full[$j] && $full[$j]!='0')
              {
                $count[$i] = $count[$i] + 1;
                $full[$j] = '0';
              }
            }
          }
          unset($full);
          $cnt = array_values($count);
          unset($count);
          //echo var_dump($cnt);
          $s = sizeof($cnt);
          //echo "<br>";
          while($s>2)
          {
            $temp = array();
            $j=$s-1;
            for ($i=0; $i < ($s/2); $i++)
            { 
              if($j <= $i)
              {
                $temp[$i] = $cnt[$i];
              }
              else
              {
                $temp[$i] = $cnt[$i] + $cnt[$j];
              }
              $j--;
            }
            $cnt = array_values($temp);
            $s = sizeof($cnt);
            unset($temp);
            //echo "<br>";
            //var_dump($cnt);
          }
          //echo "<br>";
          //var_dump($cnt);
          //echo "<br>";

          $a = strval($cnt[0]);
          $b = strval($cnt[1]);
          $arr = array($a, $b);
          $full = join("",$arr);
          $temp = "";
          //echo $full;
          if(strlen($full)==4)
          {
            $temp[0] = strval(intval($full[0])+intval($full[3]));
            $temp[1] = strval(intval($full[1])+intval($full[2]));
          }
          else if(strlen($full)==3 && $full != '100')
          {
            $temp[0] = strval(intval($full[0])+intval($full[2]));
            $temp[1] = $full[1];
          } 
          else
          {
            $temp = $full;
          }
          //echo $temp;
          //echo "<br>";

            //$ip = getHostByName(getHostName());

          if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
                $ip = $_SERVER['HTTP_CLIENT_IP'];
          } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
                $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
          } else {
                $ip = $_SERVER['REMOTE_ADDR'];
          }

          $str = $name1 . " Loves " . $name2 . ": ";
          $result = $temp;
          $per = '%';

          $sql="INSERT INTO  lovers(name1, name2, percentage, ip) VALUES(:name1,:name2,:percentage, :ip)";
          $query = $dbh->prepare($sql);
          $query->bindParam(':name1',$name1,PDO::PARAM_STR);
          $query->bindParam(':name2',$name2,PDO::PARAM_STR);
          $query->bindParam(':percentage',$result,PDO::PARAM_STR);
          $query->bindParam(':ip',$ip,PDO::PARAM_STR);
          $query->execute();

        }
    }
  else
  {
    $str = "Find Love Strength!";
    $result = "";
    $per = "";
    $ip = "";
  }
?>
<!DOCTYPE html>
<html>
    <head>
       <meta charset="utf-8">
        <title>BUZZ Love Calculator</title>

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <link rel="stylesheet" href="css/style.css">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    </head>
    <body>
        <div class="container_head">
              <h1 class="title"><u>LOVE CALCULATOR</u></h1>
              <h5 class="desc"><i>Test the Strength of Your Love</i></h5>
        </div>
        <div class="container_main">
          <form method="post">
              <table class="center">
                <tr>
                  <td class="tdPaddingh">Your<br>Name</td>
                  <td class="tdPadding2"> <input type="text" name="name1" required="1" id="name1" value="<?php if(isset($_POST['name1'])) echo $_POST['name1']; ?>"></td>
                </tr>
                <tr>
                  <td class="tdPadding">Partner's<br>Name</td>
                  <td class="tdPadding2">  <input type="text" name="name2" required="1" id="name2" value="<?php if(isset($_POST['name2'])) echo $_POST['name2']; ?>"></td>
                </tr>
                <tr>
                  <td>
                  </td>
                  <td class="tdPaddings">
                      <input type="submit" class="myButton" style="padding: 0px 0px" name="submit" id="submit">
                  </td>
                </tr>
              </table>
          </form>
          <p style="text-align: center;"><?php echo "<br>".$str.$result.$per; ?></p>
        </div>

        <footer>
          <div style="text-align: center; padding:5%;">
            <p class="cp-text">
              <b>BUZZ LOVE CALCULATOR v2.0</b><br>
                © Copyright 2020 <i>HRIDOY-BUZZ</i>. All rights reserved.
            </p>
          </div>
        </footer>

        
        
        <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
        </body>
</html>