<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="../../assets/css/loginstyles.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
</head>
<body>
<div class="container">
    <div class="screen">
        <div class="screen__content">
            <h1>Welcome Back</h1>
            <!-- Display Error Message -->
            <?php if (isset($error)): ?>
                <div class="error-message">
                    <?php echo htmlspecialchars($error); ?>
                </div>
            <?php endif; ?>
            <form action="/login" method="POST" class="login" autocomplete="off">
                <div class="login__field">
                    <i class="login__icon fas fa-user"></i>
                    <input type="text" name="username" class="login__input" placeholder="Username" required>
                </div>
                <div class="login__field">
                    <i class="login__icon fas fa-lock"></i>
                    <input type="password" name="password" class="login__input" placeholder="Password" required>
                </div>
                <button type="submit" class="button login__submit">
                    <span class="button__text">Log In</span>
                    <i class="button__icon fas fa-sign-in-alt"></i>
                </button>
            </form>
            
            <!-- Add a "Register" button -->
            <div class="additional-options">
                <p>Don't have an account?</p>
                <a href="/register" class="button register__button">
                    <span class="button__text">Register</span>
                    <i class="button__icon fas fa-user-plus"></i>
                </a>
            </div>
        </div>
    </div>
</div>
</body>
</html>
