<?php include('includes/db.php'); ?>
<?php include('includes/functions.php'); ?>
<!DOCTYPE html>
<!-- saved from url=(0053)https://getbootstrap.com/docs/4.0/examples/dashboard/ -->
<html lang="fr">
   <?php include('includes/head.php') ?>
   <body>
      <?php include('includes/navbar.php') ?>
      <div class="container-fluid">
         <div class="row">
            <nav class="col-md-3 d-none d-md-block bg-light sidebar">
               <div class="sidebar-sticky" >
                  <?php include('sidebar.php') ?>
               </div>
            </nav>
            <main role="main" class="col-md-9 ml-sm-auto col-lg-9 pt-3 px-4">
               <?php include('main.php') ?>
            </main>
         </div>
         <!-- row -->
      </div>
      <!-- container-fluid -->
      <?php include('includes/footer.php') ?>
   </body>
</html>