<!-- =============================================== -->
<!-- =                                             = -->
<!-- =                Keyners                    = -->
<!-- =                                             = -->
<!-- =          http://keyners.com/                = -->
<!-- =============================================== -->


<!DOCTYPE html>
<!--[if lt IE 7 ]><html class="ie ie6" lang="en"> <![endif]-->
<!--[if IE 7 ]><html class="ie ie7" lang="en"> <![endif]-->
<!--[if IE 8 ]><html class="ie ie8" lang="en"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--><html lang="en"> <!--<![endif]-->
<head>

  <!-- Basic Page Needs
  ================================================== -->
  <meta charset="utf-8">
  <title><?php echo $titre; ?></title>
  <meta name="description" content="">
  <meta name="author" content=" Made by Keyners">
    <meta http-equiv="X-UA-Compatible" content="IE=9" />


  <!-- Mobile Specific Metas
  ================================================== -->
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

  <!-- PT Sans -->
  <link href='http://fonts.googleapis.com/css?family=Open+Sans:400italic,400,300,600&subset=latin,latin-ext' rel='stylesheet' type='text/css'>

  <!-- Crete Roung -->
  <link href='http://fonts.googleapis.com/css?family=Crete+Round&subset=latin,latin-ext' rel='stylesheet' type='text/css'>

  <!-- CSS
  ================================================== -->
  <?php foreach($css as $url): ?>
    <link rel="stylesheet" type="text/css" media="screen" href="<?php echo $url; ?>" />
  <?php endforeach; ?>
  <!--[if lt IE 9]>
    <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
  <![endif]-->

  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.js"></script>
  <script type="text/javascript" src="<?= base_url('assets/js/validate.js'); ?>"></script>
  <script type="text/javascript" src="<?= base_url('assets/js/fancybox/jquery.fancybox-1.3.4.pack.js'); ?>"></script>
  <link rel="stylesheet" type="text/css" href="<?= base_url('assets/js/fancybox/jquery.fancybox-1.3.4.css'); ?>" media="screen" />
  <script type="text/javascript">
    $(document).ready(function() {
        $("a[rel=example_group]").fancybox({
        'transitionIn'    : 'none',
        'transitionOut'   : 'none',
        'titlePosition'   : 'over',
        'titleFormat'   : function(title, currentArray, currentIndex, currentOpts) {
          return '<span id="fancybox-title-over">Image ' + (currentIndex + 1) + ' / ' + currentArray.length + (title.length ? ' &nbsp; ' + title : '') + '</span>';
        }
      });
    });
  </script>

</head>
<body>


  <header>      
    <nav>
      <div class='container'>
        <div class='five columns logo'>
          <a href="<?= base_url(''); ?>"><img src='<?= base_url('assets/images/logo/videocban.png'); ?>'></a>
        </div>

        <div class='eleven columns'>
          <ul class='mainMenu'>
            <li><a href="<?= base_url('video/search'); ?>"><img src='<?= base_url('assets/images/nav/rechercher.png'); ?>'></a></li>
            <?php if($this->session->id >= 1):?>
              <li><a href="<?= base_url('user/edit'); ?>"><img src='<?= base_url('assets/images/nav/profil.png'); ?>'></a></li>
            <?php endif; ?>
            <li><a href="<?php if($this->session->id >= 1) { echo base_url('auth/logout'); } else { echo base_url('auth/connect'); } ?>"><img src='<?= base_url('assets/images/nav/onoff.png'); ?>'></a></li>
            <?php if($this->session->id >= 1):?>            
              <li><a href="<?= base_url('video/add'); ?>"><img src='<?= base_url('assets/images/nav/add.png'); ?>'></a></li>
            <?php endif; ?>
            <li><a href="<?= base_url('donations'); ?>"><img src='<?= base_url('assets/images/nav/dons2.png'); ?>'></a></li>
          </ul>
        </div>
      </div>
    </nav>

    
  </header>
  <?php if (!empty($errors) || $this->session->flashdata('error') || $this->session->flashdata('success')): ?>
    <div class="container">
      <?php if (!empty($errors)): ?>
        <div class="alert alert-danger">
          <p>Certains champs n'ont pas été remplis correctement :</p>
          <ul>
            <?php foreach ($errors as $error): ?>
              <li><?php echo $error; ?></li>
            <?php endforeach; ?>
          </ul>
        </div>
      <?php endif; ?>
      <?php if ($this->session->flashdata('error')): ?>
        <div class="alert alert-danger">
          <?php echo $this->session->flashdata('error'); ?>
        </div>
      <?php endif; ?>
      <?php if ($this->session->flashdata('success')): ?>
        <div class="alert alert-success">
          <?php echo $this->session->flashdata('success'); ?>
        </div>
      <?php endif; ?>
    </div>
  <?php endif; ?>
    <section class='gray'>
    <div class='container'>
        <?php echo $output; ?>
    </div>
  </section>

  <footer>
    <div class='container'>
      
      <div class='eight columns'>
        <h5>Liens</h5>
        <p>
         <?= afficherMenu(); ?>
        </p>
      </div>

      <div class='four columns social'>
        <h5>Social media</h5>
        <a href='#'><img src='<?= base_url('assets/images/social/facebook.png'); ?>'></a>
        <a href='#'><img src='<?= base_url('assets/images/social/twitter.png'); ?>'></a>
      </div>

      <div class='four columns'>
        <h5>Contacts</h5>
        <p>Adresse mail : <a href='mailto:<?= EMAIL_WEBMASTER ?>'><?= EMAIL_WEBMASTER ?></a></p>
      </div>


    <a id='top' href='#'>&uarr;</a> 
    </div>
  </footer>
  <script type="text/javascript"> 
    var form = $('form');
  
    $(document).ready(function(){
        form.validate({
          ignore: "",
              rules: {
                'message': {
                      required: true,                  
                  },
                'name': {
                      required: true,                  
                  },
                  'mail': {
                      required: true,
                      email: true
                  }                     
              },
              errorPlacement: function(error, element){}

        });
      });     
  </script>


  <script type="text/javascript">
    var toper = $('a#top');


    $(window).scroll(function(){
            if ($(this).scrollTop() > 100) {
                toper.fadeIn( 200 );
            } else {
                toper.fadeOut( 200 );
            }
        });

         toper.click(function(){
          $('html, body').animate({scrollTop:0}, 500);            
          return false;
      }); 
  </script>


</body>
</html>