<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo base_url("assets/css/style.css")?>">
    <link rel="stylesheet" href="<?php echo base_url("assets/css/bootstrap.min.css")?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="<?php echo base_url("assets/js/jquery.min.js")?>"></script>
    <script src="<?php echo base_url("assets/js/bootstrap.min.js")?>"></script>
    <title><?php echo $titlePage ?></title>
</head>
<?php if(isset($_GET['error'])) { ?>
    <div class="position-absolute error col-12 d-flex justify-content-evenly m-4" style="z-index: 10">
        <div class="alert alert-danger col-5 text-center" role="alert">
            <?php echo $_GET['error']; ?>
        </div>
    </div>
    <script>
        setInterval(function(){
            $('.alert').css("transform", "translateY(-200%)");
        }, 5000);
    </script>
<?php } ?>
<body>