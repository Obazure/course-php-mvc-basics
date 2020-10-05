<h2 class="align-center">Добро пожаловать в <?=$data['title']?>, <?=$data['username']?></h2>
<p class="align-center">
	<span class="button special">У вас на счету: <?=$data['currentpayment']?></span>
	<?
	if ($data['currentpayment']<0) echo '<span class="button">У Вас имеется задолженность.</span>';
	?>
</p>

<section>
	<p class="align-center">
	<?
		if (!empty($data['prevorder'])){
			echo '<a href="'.$data['prevorder'].'" class="button">Предыдущий заказ</a>';
		}
		if (!empty($data['nextorder'])){
			echo '<a href="'.$data['nextorder'].'" class="button">Следующий заказ</a>';
		}
	?>
	</p>
	
	<h4 class="align-center">Дата: <?=$data['time']?></h4>

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
				?>
			</tbody>
			<tfoot>
				<tr>
					<td colspan="1"></td>
					<td>Итого</td>
					<td><?=substr($data['cost'],1)?>₸</td>
				</tr>
			</tfoot>
		</table>
	</div>
</section>

<!-- 
<p class="align-center">
	<a href="#" class="button special <?=$data['disabled']?>" >Удалить заказ</a>
</p> -->