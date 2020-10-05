<h2 class="align-center"><?=$data['title']?></h2>

<section>
	<p class="align-center">
	<?
		for($i=0,$size=sizeof($data['modmenu']);$i<$size;$i++)
		{
			echo '<a href="'.$data['modmenu'][$i]['link'].'" class="button">'.$data['modmenu'][$i]['text'].'</a>';
		}
	?>
	</p>
	
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
				for ($i=0,$size=sizeof($data['food']);$i<$size;$i++)
				{
					$id = $data['food'][$i]['id'];
					$checked = ($data['food'][$i]['checked']==1)? 'checked':'';
					
					echo '<tr>';
						echo '<td>'.$data['food'][$i]['type'].'</td>';
						echo '<td><input type="checkbox" id="'.$id.'" name="'.$id.'" '.$checked.'>
							      <label for="'.$id.'">'.$data['food'][$i]['name'].'</label></td>';
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
		<ul class="actions align-center">
			<li><input type="submit" value="Сохранить" class="special"></li>
		</ul>
	</form>
</section>
