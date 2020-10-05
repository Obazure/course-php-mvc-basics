<h2 class="align-center">Список блюд на сегодня</h2>
<p class="align-center"><?=$data['name']?>Укажите что вы хотите на обед:</p>

<section>
	<form method="post" action="<?=$data['formpath']?>">
	



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
				$classadd = $data['food'][$i]['id'];
				$food_select_list_id[] = $classadd;
				
				#'.$data['food'][$i]['checked'].'
				echo '<td>
						<input type="checkbox" id="'.$classadd.'" name="'.$classadd.'" >
						<label for="'.$classadd.'">'.$data['food'][$i]['name'].'</label> 
					</td>';
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
		<ul class="actions align-center">
			<li><input type="submit" value="Узнать расчет" class="special" /></li>
		</ul>
		<input type="hidden" value="<?=implode(',', $food_select_list_id)?>" name="foodlist" />
	</form>
</section>