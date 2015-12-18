<?php
 $conn=Mysql_connect("localhost", "root", "") or die("Не удалось подключиться к серверу");
 mysql_select_db ("users") or die("Не удалось выбрать БД");
 mysql_query ("ST NAMES UTF8");
 session_start ();




  if ($_GET['uns'])/*если была нажата кнопка "выйти"
   и методом GET передана переменная 'uns'*/
    {unset ($_SESSION ['log']);
     unset ($_GET ['uns']);}
      /*то уничтожается переменная 'log',
      говорящая о том, авторизирован ли пользователь,
      а также и сама переменная 'uns'*/


  if ($_SESSION ['log'])
    {header ("Location: page1.php");
    exit;}
    //если пользователь аворизирован, то редирект на основную страницу


  if ($_POST['submit'])
    {$login=trim(htmlspecialchars($_POST['login']));
     $password=trim(htmlspecialchars($_POST['password']));

     $_SESSION['login']=$login;

      /*при нажатии 'submit' берутся данные с полей, и логин
	  заносится в сессионную переменную 'login', которая потом,
	  при успешной авторизации, переходит в 'log', */
  



      if ((!empty($login))&&(!empty($password)))//если поля не пустые
     
  	 {

          if ((preg_match ("/[a-zA-Z0-9-_]/", $login))&&(preg_match ("/[a-zA-Z0-9-_]/", $password)))
           //и содержат латинские символы, цифры и тире и подчеркивание

        {
        $query="SELECT password FROM `users` WHERE login='".$login."'";
		   //формируется запрос
        
        $res= mysql_query ($query);
        $row=mysql_fetch_assoc ($res);
		  //берутся из БД все данные по пользователю с таким логином

      	
		   

           if ($row['password']==$password)//и если пароли совпадают
            {header ("Location: page1.php");
            $_SESSION ['log']=$login; /*то редирект на основную страницу, и присваивается 
			  $_SESSION ['log'], говорящая о том, что пользователь авторизировлся*/
            exit;}

            else
             {header ("Location: index.php");
              $_SESSION['empty']='Неверный логин или пароль';
              exit;}

              }

            else
             {header ("Location: index.php");
              $_SESSION['empty']='Вы ввели кирилицу';
              exit;}

            }


      else
      {header ("Location: index.php");
       $_SESSION['empty']='Не все поля заполнены';
        exit;}
        }

     session_destroy();


?>

<html>

<head>
  <title>Форум</title>
</head>

 <body>


    <table border=1 width=100%>
	<td valign=top width=220>

	<form method="post">
 Логин или e-mail:<br />
  <input type="text" name="login" action="">
 <br>
 Пароль:<br />
 <input type="password" name="password" action=""><br />
 <input type="submit" name="submit" value="Войти">
</form>

<a href="reg.php">Регистрация</a>

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
	  Выйти
	</td>
	</table>









</body>
</html>