<?php 
    include_once 'includes/header.php';
?>

    <div class="header">
        <h2>Home</h2>
    </div>

    <div class="content">

        <?php if (!isset($_SESSION['success'])) header('Location: login.php'); ?>

        <?php if (isset($_SESSION['username'])): ?>
            <p>Welcome <strong><?= $_SESSION['username'] ?></strong></p>
            <div class="">
                <h3>Υποβολή Φόρμας</h3>
                <form action="includes/server.php" enctype="multipart/form-data" method="post">
                    <label for="file">Upload your file:</label>
                    <br/>
                    <input type="file" name="file">
                    <br/>
                    <input type="submit" name="upload" value="Upload File"> 
                </form>
                <h2>Ανεβασμένα αρχεία</h2>
                <h4>(Πατήστε στο αρχείο για κατέβασμα)</h4>
                <?php
                    $sql = "SELECT * FROM users CROSS JOIN uploads on users.id = uploads.user_id";
                    $res = mysqli_query($db, $sql);
                    if (!$res) die();
                    while ($row = mysqli_fetch_array($res)) {
                ?>
                    <p>
                        File:<a download="<?php print_r($row['upload']) ?>" href="uploads/<?php print_r($row['upload']) ?>"><?php print_r($row['upload']) ?></a>
                        User:<?php print_r($row['username']) ?>
                        <a href="index.php?delete=<?php echo $row['upload'] ?>" class="delete">Delete</a>
                    </p>  
                <?php
                    }
                ?>
            </div>
            <p><a href="index.php?logout='1'" class="logout">Logout</a></p>
        <?php endif ?>
        
    </div>

<?php include_once 'includes/footer.php'; ?>