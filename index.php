<?php
include 'Rooster.php';

$rooster = new Rooster(13899, "sA4", 962);

$table = $rooster->getVertTable();

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Rooster shit</title>
</head>
<body>
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
</body>
</html>