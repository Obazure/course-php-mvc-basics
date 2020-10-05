<h2 class="align-center">ваш обед</h2>
<p class="align-center">Подтвердите заказ. После подстверждения данную сумму необходимо будет оплатить.</p>

<section>
	
	

<div class="table-wrapper">
	<table class="alt">
		<thead>
			<tr>
				<th>Тип</th>
				<th>Блюдо</th>
				<th>Цена</th>
			</tr>
		</thead>
		<tbody>
	<?
	if(!empty($data['food']))
	{
		$food_select_list_id = [];
		for ($i=0,$size=sizeof($data['food']);$i<$size;$i++)
		{
			echo '<tr>';
				echo '<td>'.$data['food'][$i]['type'].'</td>';
				echo '<td>'.$data['food'][$i]['name'].'</td>';
				echo '<td>'.$data['food'][$i]['cost'].'₸</td>';
			echo '</tr>';
		}
		
	}
	if(!empty($data['extracosts']))
	{
		for ($i=0,$size=sizeof($data['extracosts']);$i<$size;$i++)
		{
			echo '<tr>';
			echo '<td colspan="1"></td>';
			echo '<td>'.$data['extracosts'][$i]['name'].'</td>';
			echo '<td>'.$data['extracosts'][$i]['cost'].'₸</td>';
			echo '</tr>';
		}
	}
	?>
		</tbody>
		<tfoot>
			<tr>
				<td colspan="1"></td>
				<td>Итого</td>
				<td><?=$data['cost']?>₸</td>
			</tr>
		</tfoot>
	</table>
</div>
<blockquote>Текущее состояние вашего счета: <?=$data['currentAccount']?>₸. <?=$data['extramsg']?></blockquote>
	<form method="post" action="<?=$data['formpath']?>">
		<ul class="actions align-center">
			<li><input type="submit" value="Подтвердить" class="special" /></li>
		</ul>
		<input type="hidden" value="<?=implode(',', $food_select_list_id)?>" name="foodlist" />
	</form>
</section>
