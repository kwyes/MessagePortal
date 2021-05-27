<?php
  $page = $_GET['page'];
  $roleSys = $_SESSION['staffRoleSys'];
?>
<div class="sidebar" data-active-color="orange" data-background-color="black" data-image="assets/img/sidebar-1.jpg">
    <!--
      Tip 1: You can change the color of active element of the sidebar using: data-active-color="purple | blue | green | orange | red | rose"
      Tip 2: you can also add an image using data-image tag
      Tip 3: you can change the color of the sidebar with data-background-color="white | black"
  -->

    <div class="logo">
        <a href="?page=dashboard" class="simple-text logo-mini">
            MP
        </a>

        <a href="?page=dashboard" class="simple-text logo-normal">
            Message Portal
        </a>
    </div>

    <div class="sidebar-wrapper">

        <ul class="nav">

            <!-- <li class="<?php echo ($page=='dashboard')?" active":"";?>">
                <a href="?page=dashboard">
                    <i class="material-icons">dashboard</i>
                    <p> Dashboard </p>
                </a>
            </li> -->
<!-- 
            <li class="<?php echo ($page=='message2')?" active":"";?>">
                <a href="?page=message2">
                    <i class="material-icons">timeline</i>
                    <p> Message TEST</p>
                </a>
            </li> -->

            <!-- <li class="<?php echo ($page=='message')?" active":"";?>">
                <a href="?page=message">
                    <i class="material-icons">mail_outline</i>
                    <p>Create Messages </p>
                </a>
            </li> -->

            <li class="<?php echo ($page=='list')?" active":"";?>">
                <a href="?page=list">
                    <i class="material-icons-outlined">phone_android</i>
                    <p>App Messages </p>
                </a>
            </li>
            <?php
                if ($roleSys == '99') {
            ?>
            <li class="<?php echo ($page=='email')?" active":"";?>">
                <a href="?page=email">
                    <i class="material-icons-outlined">mail_outline</i>
                    <p>Mass Email </p>
                </a>
            </li>
            <?php
                }
            ?>

        </ul>

    </div>
</div>
