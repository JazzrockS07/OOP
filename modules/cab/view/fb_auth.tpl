<div class="body-page">
    <div class="reg">Регистрация через facebook</div><br>
	<?php if (!isset($message2)) { ?>
    <?php if(!isset($_SESSION['regok'])) { ?>

        <div class="regist-align">
            <?php if (isset($message)) echo $message; ?>
        </div>

        <form action="" method="post" class="reg-form">
            <table class="reg-table">
                <tr>
                    <td>Логин *</td>
                    <td><input id="regist-login" type="text" name="login" value="<?php if(isset($_POST['login'])) { echo hc($_POST['login']);} elseif(isset($data->first_name,$data->id)) {echo hc($data->first_name.$data->id);}  ?>"></td>
                    <td><?php if(isset($errors['login'])) echo $errors['login']; ?></td>
                </tr>
                <tr>
                    <td>Пароль *</td>
                    <td><input type="password" name="password" value="<?php if(isset($_POST['password'])) echo hc($_POST['password']); ?>"></td>
                    <td><?php if(isset($errors['password'])) echo $errors['password']; ?></td>
                </tr>
                <tr>
                    <td>Email *</td>
                    <td><input type="text" name="email" value="<?php if(isset($_POST['email'])) {echo hc($_POST['email']);} elseif(isset($data->email)) {echo hc($data->email);} ?>"></td>
                    <td><?php if(isset($errors['email'])) echo $errors['email']; ?></td>
                </tr>
                <tr>
                    <td>Возраст</td>
                    <td><input type="text" name="age" value="<?php if(isset($_POST['age'])) echo hc($_POST['age']); ?>"></td>
                    <td></td>
                </tr>
            </table>
            <p>* поля, обязательные для заполнения</p><br>
            <input type="hidden" name="fb_id" value="<?php if(isset($_POST['fb_id'])) {echo hc($_POST['fb_id']);} elseif(isset($data->id)) {echo hc($data->id);} ?>">
            <input type="hidden" name="fb_name" value="<?php if(isset($_POST['fb_name'])) {echo hc($_POST['fb_name']);} elseif(isset($data->first_name)) {echo hc($data->first_name);} ?>">
            <input type="hidden" name="fb_email" value="<?php if(isset($_POST['fb_email'])) {echo hc($_POST['fb_email']);} elseif(isset($data->email)) {echo hc($data->email);} ?>">
            <input type="submit" name="sendreg" value="Зарегистрироваться">
        </form>
    <?php } else { unset($_SESSION['regok']); ?>
        <div class="reg-text">Вы успешно зарегистрировались, для входа в кабинет авторизуйтесь пожалуйста</div>
    <?php } ?>
	<?php } else { ?>
		<div class="reg-text"><?php echo $message2; ?></div>
	<?php } ?>
</div>
