<?php
 $conn=Mysql_connect("localhost", "root", "") or die("Ќе удалось подключитьс€ к серверу");
 mysql_select_db ("users") or die("Ќе удалось выбрать Ѕƒ");
 mysql_query ("ST NAMES UTF8");
 session_start ();




  if ($_GET['uns'])/*если была нажата кнопка "выйти"
   и методом GET передана переменна€ 'uns'*/
    {unset ($_SESSION ['log']);
     unset ($_GET ['uns']);}
      /*то уничтожаетс€ переменна€ 'log',
      говор€ща€ о том, авторизирован ли пользователь,
      а также и сама переменна€ 'uns'*/


  if ($_SESSION ['log'])
    {header ("Location: page1.php");
    exit;}
    //если пользователь аворизирован, то редирект на основную страницу


  if ($_POST['submit'])
    {$login=trim(htmlspecialchars($_POST['login']));
     $password=trim(htmlspecialchars($_POST['password']));

     $_SESSION['login']=$login;

      /*при нажатии 'submit' берутс€ данные с полей, и логин
	  заноситс€ в сессионную переменную 'login', котора€ потом,
	  при успешной авторизации, переходит в 'log', */




      if ((!empty($login))&&(!empty($password)))//если пол€ не пустые

  	 {

          if ((preg_match ("/[a-zA-Z0-9-_]/", $login))&&(preg_match ("/[a-zA-Z0-9-_]/", $password)))
           //и содержат латинские символы, цифры и тире и подчеркивание

        {
        $query="SELECT password FROM `users` WHERE login='".$login."'";
		   //формируетс€ запрос

        $res= mysql_query ($query);
        $row=mysql_fetch_assoc ($res);
		  //берутс€ из Ѕƒ все данные по пользователю с таким логином




           if ($row['password']==$password)//и если пароли совпадают
            {header ("Location: page1.php");
            $_SESSION ['log']=$login; /*то редирект на основную страницу, и присваиваетс€
			  $_SESSION ['log'], говор€ща€ о том, что пользователь авторизировлс€*/
            exit;}

            else
             {header ("Location: index.php");
              $_SESSION['empty']='Ќеверный логин или пароль';
              exit;}

              }

            else
             {header ("Location: index.php");
              $_SESSION['empty']='¬ы ввели кирилицу';
              exit;}

            }


      else
      {header ("Location: index.php");
       $_SESSION['empty']='Ќе все пол€ заполнены';
        exit;}
        }

     session_destroy();


?>

<html>

<head>
  <title>‘орум</title>
</head>

 <body>


    <table border=1 width=100%>
	<td valign=top width=220>

	<form method="post">
 Ћогин или e-mail:<br />
  <input type="text" name="login" action="">
 <br>
 ѕароль:<br />
 <input type="password" name="password" action=""><br />
 <input type="submit" name="submit" value="¬ойти">
</form>

<a href="reg.php">–егистраци€</a>

<br>

<?php
  echo $_SESSION['empty'];

?>

	</td>
	<td>
	<?php
     include ("page.php");
	?>
	</td>
	<td valign=top>
	  ¬ыйти
	</td>
	</table>




     <p>последние изменени€</p>





</body>
</html>