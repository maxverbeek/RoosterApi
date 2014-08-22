<?php

include 'Rooster.php';

if (isset($_GET['student'], $_GET['class'], $_GET['school']))
{
	if (is_int($_GET['student']) && is_int($_GET['school']))
	{
		$rooster = new Rooster($_GET['student'], $_GET['class'], $_GET['school']);
		$table = $rooster->getVertTable();
	}
}

if (!isset($rooster)) $leerlingen = include("Leerlingen.php");


?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Rooster shit</title>
</head>
<body>
	<?php if (isset($rooster)): ?>
		<table>
			<tr>
				<th>Uur</th>
				<th>Maandag</th>
				<th>Dinsdag</th>
				<th>Woensdag</th>
				<th>Donderdag</th>
				<th>Vrijdag</th>
			</tr>

			<?php

			foreach ($table as $uur => $row)
			{
				$uur++;
				echo "<tr>";

				echo "<td>" . $uur . "</td>";

				foreach ($row as $day)
				{
					echo "<td>";
					foreach ($day as $item => $value)
					{
						echo "{$item}: $value<br>";
					}
					echo "</td>";
				}

				echo "</tr>";
			}
			?>
		</table>
	<?php else:
		// display selector for students
	?>
	<form action="#" method="GET">
		<div class="field"><select name="student">
			<?php foreach ($leerlingen as $class => $leerling): ?>
				<optgroup label="<?php echo $class; ?>">
					<?php foreach ($leerling as $id => $individu): ?>
						<option value="<?php echo $id; ?>"><?php echo $individu; ?></option>
					<?php endforeach; ?>
				</optgroup>
			<?php endforeach; ?>
		</select></div>
		<div class="field"><input type="submit"></div>
	</form>

	<?php endif; ?>

</body>
</html>