<div id="index-banner" class="parallax-container">
    <div class="section no-pad-bot">
      <div class="container">
        <br><br>
        <div class="row">
        <div class="col s6">
        	<h3 class="header center teal-text text-lighten-2">Войти / Регистрация</h3>        
			<div class="row">
				<form class="col s12" action="<?=$data['formpath']?>" method="post">
			      <div class="row">
			        <div class="input-field col s12 black-text ">
			          <i class="material-icons prefix">contacts</i>
			          <input id="email" type="email" name="email" maxlength="80" required class="validate">
			          <label for="email">Email</label>
			        </div>
			      </div>
			      <div class="row">
			        <div class="input-field col s12 black-text ">
			        <i class="material-icons prefix">dialpad</i>
			          <input id="password" type="password" name="password" required class="validate"
			          	pattern="[A-Za-z-0-9]{6,80}" title="Минмиум 6 EN букв или цифр">
			          <label for="password">Пароль</label>
			        </div>
			      </div> 
			      <div class="row">
			      	<div class="text-center center">
			      		<input type="submit" name="enter" value="Войти" class="waves-effect waves-light btn"/></li>
			      	</div>
			      </div>
			    </form>
			  </div>
		  </div>
		  </div>
      </div>
    </div>
    <div class="parallax"><img src="/assets/images/background1.jpg" alt="<?=$data['title']?>"></div>
  </div>
 