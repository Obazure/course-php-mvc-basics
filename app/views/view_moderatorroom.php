<h2 class="align-center">Добро пожаловать в <?=$data['title']?>, <?=$data['username']?></h2>

	
	

<section>
	<p class="align-center">
	<?
		for($i=0,$size=sizeof($data['modmenu']);$i<$size;$i++)
		{
			echo '<a href="'.$data['modmenu'][$i]['link'].'" class="button">'.$data['modmenu'][$i]['text'].'</a>';
		}
	?>
	</p>
	
	<? if (!empty($data['order'])) { ?>
	
	<h4 class="align-center">Дата: <?=$data['time']?></h4>

	<form method="post" action="<?=$data['formpath']?>">
	
	<div class="table-wrapper">
		<table class="alt">
			<thead>
				<tr>
					<th>Заказ/Цена</th>
					<th>Блюда</th>
				</tr>
			</thead>
			<tbody>
				<?
				if(!empty($data['order']))
				{
					$food_select_list_id = [];
					$moneysummary=0;
					for ($i=0,$size=sizeof($data['order']);$i<$size;$i++)
					{
						$id = $data['order'][$i]['hash'];
						$moneysummary+=$data['order'][$i]['amount'];
						
						echo '<tr>';
							echo '<td><input type="radio" id="'.$id.'" name="radio" value="'.$id.'">
							      <label for="'.$id.'">'.$data['order'][$i]['name'].'<br/>'.substr($data['order'][$i]['amount'], 1).'₸</label></td>';
						
							echo '<td>';
								for ($j=0,$jsize = sizeof($data['order'][$i]['food']);$j<$jsize; $j++)
									echo '<label>'.$data['order'][$i]['food'][$j]['name'].'</label>';
							echo '</td>';
						echo '</tr>';
					}
				}	
				?>
			</tbody>
			<tfoot>
				<tr>
					<td><?=substr($moneysummary.'₸',1)?></td>
					<td><?=$data['extra'].'₸'?></td>
				</tr>
			</tfoot>
		</table>
	</div>
	<ul class="actions align-center">
			<li><input type="submit" value="Отменить выбранные заказы" class="special" onclick="if (confirm('Точно удалить?')) {return true;} else {return false;}"></li>
		</ul>
	</form>
	<? } else { echo '	<h3 class="align-center">Заказов на сегодня еще не было.</h3>';}?>
</section>
