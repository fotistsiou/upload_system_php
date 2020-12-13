<?php 
    include('server.php'); 
    include('header.php');
?>
    <div class="header">
        <h2>Login</h2>
    </div>

    <form class="gener" action="login.php" method="post">
        <?php include('errors.php'); ?>
        <div class="input-group">
            <label>Username</label>
            <input type="text" name="username">
        </div>
        <div class="input-group">
            <label>Password</label>
            <input type="password" name="password">
        </div>
        <div class="input-group">
            <button type="submit" name="login" class="btn">Login</button>
        </div>
        <p>
            Not yet a member? <a href="register.php">Sign up</a>
        </p>
    </form>

<?php include('footer.php'); ?>