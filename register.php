<?php require_once 'config.php';
if (!empty($_SESSION['customer_id'])) redirect('customer/dashboard.php');
$error='';
if ($_SERVER['REQUEST_METHOD']==='POST') { verify_csrf(); $name=trim($_POST['name']??''); $email=strtolower(trim($_POST['email']??'')); $phone=trim($_POST['phone']??''); $pass=$_POST['password']??'';
 if ($name==='' || !filter_var($email,FILTER_VALIDATE_EMAIL) || strlen($pass)<8) $error='Enter a name, valid email and password of at least 8 characters.';
 else { try { $s=db()->prepare('INSERT INTO customers(name,email,phone,password_hash) VALUES(?,?,?,?)'); $s->execute([$name,$email,$phone,password_hash($pass,PASSWORD_DEFAULT)]); $_SESSION['customer_id']=(int)db()->lastInsertId(); flash('Account created. Welcome!'); redirect('customer/dashboard.php'); } catch(PDOException $ex) { $error=$ex->getCode()==='23000'?'An account with this email already exists.':'Could not create account. Please try again.'; } }
}
page_start('Create account'); if($error) echo '<div class="alert error">'.e($error).'</div>'; ?>
<form method="post" class="form panel"><input type="hidden" name="csrf" value="<?=e(csrf_token())?>"><label>Full name<input name="name" required maxlength="100" value="<?=e($_POST['name']??'')?>"></label><label>Email<input type="email" name="email" required maxlength="190" value="<?=e($_POST['email']??'')?>"></label><label>Phone (optional)<input name="phone" maxlength="30"></label><label>Password<input type="password" name="password" required minlength="8"></label><button class="btn">Create account</button><p>Already registered? <a href="login.php">Sign in</a></p></form>
<?php page_end(); ?>
