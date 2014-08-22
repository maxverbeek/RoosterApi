<?php

include 'Rooster.php';

$leerlingen = include("Leerlingen.php");

if (isset($_GET['student'], $_GET['school']))
{
	$student = (int) $_GET['student'];
	$school = (int) $_GET['school'];
	{
		$temp = array();
		foreach ($leerlingen as $klasnaam => $klas)
		{
			if (in_array($student, array_keys($klas)))
			{
				$klasnummer = $klasnaam;
				$klasnummer = preg_replace("/[a-z]$/i", "", $klasnummer);

				$rooster = new Rooster($student, $klasnummer, $school);
				$table = $rooster->getVertTable();
				break;
			}
		}

	}
}


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
		<div class="field">
			<select name="school">
				<option value="962">Zernike College</option>
			</select>
		</div>

		<div class="field"><input type="submit"></div>
	</form>

	<?php endif; ?>

</body>
</html>