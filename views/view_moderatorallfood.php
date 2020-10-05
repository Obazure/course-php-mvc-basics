
<h2 class="align-center">Список блюд</h2>

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
		<input type="hidden" name="foodid" id="foodid" value="<?=$data['formfood']['id']?>" required>
		<div class="field half">
			<input type="text" name="name" id="name" value="<?=$data['formfood']['name']?>" placeholder="Наименование" required>
		</div>
		<div class="field half">
			<input type="text" name="cost" id="cost" value="<?=$data['formfood']['cost']?>" placeholder="Цена" required>
		</div>
		<div class="field half">
			<div class="select-wrapper">
				<select name="foodtype" id="foodtype" required>
					<option value="">-</option>
					<?
						if (!empty($data['foodtypes'])){
							
							for($i=0,$size=sizeof($data['foodtypes']);$i<$size;$i++){
								$selected =($data['formfood']['type']==$data['foodtypes'][$i]['id'])? 'selected="selected"':'';
								
								echo '<option value="'.$data['foodtypes'][$i]['id'].'" '.$selected.'>';
								echo $data['foodtypes'][$i]['name'];
								echo '</option>';
							}	
						}
					?>
				</select>
			</div>
		</div>
		<div class="field half">
			<input type="submit" value="Сохранить" class="special">
		</div>
	</form>
</section>

<section>
	<form method="post" action="<?=$data['formpath']?>">
		<div class="table-wrapper">
			<table class="alt">
				<thead>
					<tr>
						<th>Тип</th>
						<th>Блюдо</th>
						<th>Цена</th>
						<th><span class="icon fa-pencil-square-o fa-x5"></span></th>
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
						echo '<td><a href="/moderator/allfood/edit/'.$data['food'][$i]['id'].'" class="icon fa-pencil-square-o fa-x5"></a></td>';
					/* <ul class="icons" style="margin:0px;"><li><a href="/moderator/allfood/edit/'.$data['food'][$i]['id'].'" class="icon fa-pencil-square-o fa-x2"></a></li></ul> */
					echo '</tr>';
				}
			}	
			?>
				</tbody>
				<tfoot>
					<tr>
						<td colspan="1"></td>
						<td colspan="2">Всего блюд</td>
						<td><?=sizeof($data['food'])?></td>
						
					</tr>
				</tfoot>
			</table>
		</div>
	</form>

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
</section>





									
											
												
											
								
