<?php
 $conn=Mysql_connect("localhost", "root", "") or die("�� ������� ������������ � �������");
 mysql_select_db ("users") or die("�� ������� ������� ��");
 mysql_query ("ST NAMES UTF8");
 session_start ();




  if ($_GET['uns'])/*���� ���� ������ ������ "�����"
   � ������� GET �������� ���������� 'uns'*/
    {unset ($_SESSION ['log']);
     unset ($_GET ['uns']);}
      /*�� ������������ ���������� 'log',
      ��������� � ���, ������������� �� ������������,
      � ����� � ���� ���������� 'uns'*/


  if ($_SESSION ['log'])
    {header ("Location: page1.php");
    exit;}
    //���� ������������ ������������, �� �������� �� �������� ��������


  if ($_POST['submit'])
    {$login=trim(htmlspecialchars($_POST['login']));
     $password=trim(htmlspecialchars($_POST['password']));

     $_SESSION['login']=$login;

      /*��� ������� 'submit' ������� ������ � �����, � �����
	  ��������� � ���������� ���������� 'login', ������� �����,
	  ��� �������� �����������, ��������� � 'log', */




      if ((!empty($login))&&(!empty($password)))//���� ���� �� ������

  	 {

          if ((preg_match ("/[a-zA-Z0-9-_]/", $login))&&(preg_match ("/[a-zA-Z0-9-_]/", $password)))
           //� �������� ��������� �������, ����� � ���� � �������������

        {
        $query="SELECT password FROM `users` WHERE login='".$login."'";
		   //����������� ������

        $res= mysql_query ($query);
        $row=mysql_fetch_assoc ($res);
		  //������� �� �� ��� ������ �� ������������ � ����� �������




           if ($row['password']==$password)//� ���� ������ ���������
            {header ("Location: page1.php");
            $_SESSION ['log']=$login; /*�� �������� �� �������� ��������, � �������������
			  $_SESSION ['log'], ��������� � ���, ��� ������������ ��������������*/
            exit;}

            else
             {header ("Location: index.php");
              $_SESSION['empty']='�������� ����� ��� ������';
              exit;}

              }

            else
             {header ("Location: index.php");
              $_SESSION['empty']='�� ����� ��������';
              exit;}

            }


      else
      {header ("Location: index.php");
       $_SESSION['empty']='�� ��� ���� ���������';
        exit;}
        }

     session_destroy();


?>

<html>

<head>
  <title>�����</title>
</head>

 <body>


    <table border=1 width=100%>
	<td valign=top width=220>

	<form method="post">
 ����� ��� e-mail:<br />
  <input type="text" name="login" action="">
 <br>
 ������:<br />
 <input type="password" name="password" action=""><br />
 <input type="submit" name="submit" value="�����">
</form>

<a href="reg.php">�����������</a>

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
	  �����
	</td>
	</table>




     <p>��������� ���������</p>





</body>
</html>