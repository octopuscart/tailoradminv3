<?php
$this->load->view('layout/header');

?>

<div class="login login-with-news-feed">
    <!-- begin news-feed -->
    <div class="news-feed">
        <div class="news-image">
        </div>
        <div class="news-caption">
            <h4 class="caption-title"><i class="fa fa-diamond text-success"></i> <?php echo SEO_TITLE; ?></h4>
            <p>
                <?php echo SEO_DESC; ?>
            </p>
        </div>
    </div>
    <!-- end news-feed -->
    <!-- begin right-content -->
    <div class="right-content">
        <!-- begin login-header -->
        <div class="login-header" >
            <div class="brand">

                <img src="<?php echo SITE_LOGO; ?>" style="height: 70px;">  
                <small><?php echo SITE_NAME; ?> Admin Control Panel </small>
            </div>
            <div class="icon" >
                <i class="fa fa-sign-in"></i>
            </div>
        </div>
        <!-- end login-header -->
        <!-- begin login-content -->
        <div class="login-content">
            <h2>404</h2>
            <p>Page not found.</p>
            <a class="btn btn-default" href="<?php echo site_url();?>">Back</a>
        </div>
        <!-- end login-content -->
    </div>
    <!-- end right-container -->
</div>

<?php
$this->load->view('layout/footer');
?> 