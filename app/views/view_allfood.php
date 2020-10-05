
<h2 class="align-center">Список блюд</h2>
<p class="align-center">Здесь представлен список блюд, которые бывали когда-либо кем-либо съедены.</p>
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
				<td>Всего блюд</td>
				<td><?=sizeof($data['food'])?></td>
			</tr>
		</tfoot>
	</table>
</div>

<ul>
	<?
	if(!empty($data['extracosts']))
	{
		for ($i=0,$size=sizeof($data['extracosts']);$i<$size;$i++)
		{
			echo '<li>'.$data['extracosts'][$i]['name'].' - '.$data['extracosts'][$i]['cost'].'₸</li>';
		}
	}	
	?>
</ul>





									
											
												
											
								
