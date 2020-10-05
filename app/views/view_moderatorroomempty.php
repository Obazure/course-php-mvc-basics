<h4 class="align-center">Дата: <?=$data['time']?></h4>

<table border="1">
	
		<tr>
			<th>Заказ/Цена</th>
			<th>Блюда</th>
		</tr>
	
	
		<?
		if(!empty($data['order']))
		{
			$food_select_list_id = [];
			$moneysummary=0;
			for ($i=0,$size=sizeof($data['order']);$i<$size;$i++)
			{
				echo '<tr>';
					echo '<td>'.$data['order'][$i]['name'].' <br/>'.
								substr($data['order'][$i]['amount'], 1).'₸</td>';
								$moneysummary+=$data['order'][$i]['amount'];
					echo '<td>';
					for ($j=0,$jsize = sizeof($data['order'][$i]['food']);$j<$jsize; $j++)
						echo $data['order'][$i]['food'][$j]['name'].'<br/>';
					echo '</td>';
				echo '</tr>';
			}
		}	
		?>
	
		<tr>
			<td><?=substr($moneysummary.'₸',1)?></td>
			<td><?=$size?></td>
		</tr>
	
</table>
