
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
		<div class="field half">
			<div class="select-wrapper">
				<select name="user" id="user" required>
					<option value="">-</option>
					<?
						if (!empty($data['users'])){
							for($i=0,$size=sizeof($data['users']);$i<$size;$i++){
								echo '<option value="'.$data['users'][$i]['id'].'">'.$data['users'][$i]['name'].'</option>';
							}	
						}
					?>
				</select>
			</div>
		</div>
		<div class="field half">
			<input type="text" name="money" id="money" value="" placeholder="Начислить (цифры)" required>
		</div>
		<div class="field half">
			<input type="submit" value="Сохранить" class="special">
		</div>
	</form>
</section>
<p class="align-center"><?=$_SESSION['response'];unset($_SESSION['response']);?></p>

<h3 class="align-center">Баланс пользователей</h2>
<div class="table-wrapper">
	<table class="alt">
		<thead>
			<tr>
				<th>Пользователь</th>
				<th>Баланс</th>
			</tr>
		</thead>
		<tbody>
	<?
	if(!empty($data['usersmoney']))
	{
		for ($i=0,$size=sizeof($data['usersmoney']);$i<$size;$i++)
		{
			echo '<tr>';
				echo '<td>'.$data['usersmoney'][$i]['name'].'</td>';
				echo '<td>'.$data['usersmoney'][$i]['SUM(amount)'].'₸</td>';
			echo '</tr>';
		}
	}	
	?>
		</tbody>
		<tfoot>
			<tr>
				<td>Всего пользователей</td>
				<td><?=sizeof($data['usersmoney'])?></td>
			</tr>
		</tfoot>
	</table>
</div>