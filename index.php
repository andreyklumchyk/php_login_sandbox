<?php

session_start();

// Обработка формы
if (isset($_POST['submit'])) {
  $login = filter_input(INPUT_POST, 'login', FILTER_SANITIZE_STRING);
  $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);

  // Тестовые данные пользователя
  $users = [
    'test' => ['password' => 'test'],
  ];

  // Проверка логина и пароля
  if (isset($users[$login]) && $password === $users[$login]['password']) {
    $_SESSION['logged_in'] = true;
    $_SESSION['login'] = $login;
    $_SESSION['lang'] = $_POST['lang'] ?? 'en';
  } else {
    $error = 'Неверный логин или пароль.';
  }
}

if (isset($_POST['lang'])) {
    $_SESSION['lang'] = $_POST['lang'];
}

// Выбор языка
$lang = $_SESSION['lang'] ?? 'en';
$lang_data = [
  'en' => [
    'title' => 'Login',
    'login' => 'Username',
    'password' => 'Password',
    'remember_me' => 'Remember me',
    'submit' => 'Sign in',
    'profile' => 'Profile',
    'logout' => 'Logout',
    'error' => 'Invalid username or password.',
    'lang_switch' => 'Language:',
  ],
  'ru' => [
    'title' => 'Вход в систему',
    'login' => 'Логин',
    'password' => 'Пароль',
    'remember_me' => 'Запомнить меня',
    'submit' => 'Войти',
    'profile' => 'Профиль',
    'logout' => 'Выход',
    'error' => 'Неверный логин или пароль.',
    'lang_switch' => 'Язык:',
  ],
];

?>

<!DOCTYPE html>
<html lang="<?php echo $lang ?>">
<head>
  <meta charset="UTF-8">
  <title><?php echo $lang_data[$lang]['title'] ?></title>
  <!--link rel="stylesheet" href="style.css"-->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
</head>
<body>

<?php if (isset($_SESSION['logged_in']) && $_SESSION['logged_in']): ?>

  <h1><?php echo $lang_data[$lang]['profile'] ?></h1>
  <p>Привет, <?php echo $_SESSION['login'] ?>!</p>
  <a href="logout.php"><?php echo $lang_data[$lang]['logout'] ?></a>

<?php else: ?>

    <form class="form-inline mb-3" action="index.php" method="post">
    <select name="lang" id="lang" class="form-control mr-sm-2" onchange="submit()">
      <option value="en" <?php echo ($lang === 'en' ? 'selected' : '') ?>>English</option>
      <option value="ru" <?php echo ($lang === 'ru' ? 'selected' : '') ?>>Русский</option>
    </select>
  </form>

  <h1 style="text-align:center"><?php echo $lang_data[$lang]['title'] ?></h1>

  <form class="container" action="index.php" method="post">
    <div class="mb-3">
      <label for="login" class="form-label"><?php echo $lang_data[$lang]['login'] ?></label>
      <input type="text" class="form-control" id="login" name="login" required>
    </div>
    <div class="mb-3">
      <label for="password" class="form-label"><?php echo $lang_data[$lang]['password'] ?></label>
      <input type="password" class="form-control" id="password" name="password" required>
    </div>
    <?php if (isset($error)): ?>
      <p class="error alert alert-danger"><?php echo $error ?></p>
    <?php endif; ?>
    <br/><br/>

    <button type="submit" class="btn btn-primary" name="submit"><?php echo $lang_data[$lang]['submit'] ?></button>


  </form>

<?php endif; ?>

</body>
</html>
