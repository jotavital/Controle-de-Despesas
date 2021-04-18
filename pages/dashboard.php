<?php
    include("../connections/loginVerify.php");
    $title = "Dashboard";
    include("../include/header.php");
    setTitulo($title);
?>

<body>
    <div class="col-12 d-flex justify-content-center">
        <a class="mt-3 btn btn-outline-danger" href="../connections/logout.php" role="button">Logout</a>
    </div>
</body>

<?php
    include("../include/footer.php");
?>