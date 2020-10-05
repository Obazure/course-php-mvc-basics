<h2 class="align-center">Добро пожаловать в <?=$data['title']?>, <?=$data['username']?></h2>
<p class="align-center">
	<span class="button special">У вас на счету: <?=$data['currentpayment']?></span>
	<?
	if ($data['currentpayment']<0) echo '<span class="button">У Вас имеется задолженность.</span>';
	?>
</p>

<h3 class="align-center">Список ваших заказов пуст.</h3>
