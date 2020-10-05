<!DOCTYPE HTML>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no"/>
  <title>Teach Me | <?=$data['title']?></title>

	<link rel="icon" type="image/png" href="/assets/images/logo.png">

  <!-- CSS  -->
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link href="/assets/css/materialize.css" type="text/css" rel="stylesheet" media="screen,projection"/>
  <link href="/assets/css/style.css" type="text/css" rel="stylesheet" media="screen,projection"/>
  
</head>
<body>
  <nav class="white" role="navigation">
    <div class="nav-wrapper container">
      <a id="logo-container" href="/home" class="brand-logo">Teach Me</a>
      <ul class="right hide-on-med-and-down">
        <?
            if(!empty($data['navbar'])){
                for ($i=0,$size=sizeof($data['navbar']);$i<$size;$i++)
                    echo '<li><a href="'.$data['navbar'][$i]['link'].'">'.$data['navbar'][$i]['text'].'</a></li>';
            }
        ?>
      </ul>

      <ul id="nav-mobile" class="side-nav">
        <?
            if(!empty($data['navbar'])){
                for ($i=0,$size=sizeof($data['navbar']);$i<$size;$i++)
                    echo '<li><a href="'.$data['navbar'][$i]['link'].'">'.$data['navbar'][$i]['text'].'</a></li>';
            }
        ?>
      </ul>
      <a href="#" data-activates="nav-mobile" class="button-collapse"><i class="material-icons">menu</i></a>
    </div>
  </nav>

  <? include 'app/views/'.$content_view; ?>

  <footer class="page-footer teal">
    <div class="container">
      <div class="row">
        <div class="col l6 s12">
          <h5 class="white-text">Teach Me</h5>
          <p class="grey-text text-lighten-4">
          Платформа связи ученика и учителя, с предоставлением свободы выбора репетиторов молодым поколением.</p>


        </div>
        <div class="col l3 s12">
          <h5 class="white-text">Навигация</h5>
          <ul>
          <?
            if(!empty($data['navbar'])){
                for ($i=0,$size=sizeof($data['navbar']);$i<$size;$i++)
                    echo '<li><a class="white-text" href="'.$data['navbar'][$i]['link'].'">'.$data['navbar'][$i]['text'].'</a></li>';
            }
        ?>
          </ul>
        </div>
      </div>
    </div>
    <div class="footer-copyright">
      <div class="container">
      Разработано <a class="brown-text text-lighten-3" href="http://cdx.kz">LOTF | Legends of the future</a>
      </div>
    </div>
  </footer>


  <!--  Scripts-->
  <script src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
  <script src="/assets/js/materialize.js"></script>
  <script src="/assets/js/init.js"></script>

  </body>
</html>