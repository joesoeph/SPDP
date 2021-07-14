<?=doctype()?>

<html lang="en">
<head>
    <title> <?=$Title?> </title>
    <style>
       #preloader {
        position:fixed;
        top:0;
        left:0;
        right:0;
        bottom:0;
        background-color:#ffffff; /* change if the mask should have another color then white */
        z-index:99; /* makes sure it stays on top */
       }

       #load {
        width:320px;
        height:100px;
        position:absolute;
        left:50%; /* centers the loading animation horizontally one the screen */
        top:50%; /* centers the loading animation vertically one the screen */
        background-image:url(assets/img/lo7.gif); /* path to your loading animation */
        background-repeat:no-repeat;
        background-position:center;
        margin:-150px 0 0 -150px; /* is width and height divided by two */
       }
     </style>

    <?php

    echo $Meta;

    if (! empty($AddCss)) {
        foreach ($AddCss as $Val) {
            echo link_css($Val);
        }
    }

    echo $Css;

    echo $JsHeader;

    if (! empty($AddJsHeader)) {
        foreach ($AddJsHeader as $Val) {
            echo link_js($Val);
        }
    }
    ?>

    <script>
    var base_url = "<?=base_url()?>";
    </script>
    <!-- <link rel="shortcut icon" href="<?=base_url('assets/kkp.png')?>"/> -->
</head>

<body>
  <!-- Loading -->
  <div id="preloader">
  <div id="load"></div>
  </div>
<?php
echo '<div class="clearfix"></div>';

echo '<div id="wrapper">';
    if ($SideBar) echo $SideBar;
    if ($Header) echo $Header;

    // echo '
    // <div class="row">
    //   <div class="col-md-12">
    //     <ul class="breadcrumb">
    //       <li>
    //         <a href="#" class="navbar-btn sidebar-toggle" data-toggle="offcanvas" role="button" id="menu-toggle">
    //           <i class="glyphicon glyphicon-align-justify"></i>
    //         </a>
    //       </li>
    //     </ul>
    //   </div>
    // </div>';

    if ($Content) echo $Content;

echo '</div>';

if ($Footer) echo $Footer;
?>

<?php
echo $JsFooter;

if (! empty($AddJsFooter)) {
    foreach ($AddJsFooter as $RowJsFooter) {
        echo link_js($RowJsFooter);
    }
}

?>

<script>
  $(window).load(function() { // makes sure the whole site is loaded
    $("#status").fadeOut(); // will first fade out the loading animation
    $("#preloader").delay(350).fadeOut("slow"); // will fade out the white DIV that covers the website.
  })
  $("#menu-toggle").click(function(e) {
      e.preventDefault();
      $("#wrapper").toggleClass("toggled");
  });

  $(function() {
    $('#kotak').dataTable();
  });

  // $(document).ready(function(){
  //     $(".header").sticky({topSpacing:200});
  // });
</script>

</body>
</html>
