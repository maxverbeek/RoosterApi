<?php

class Rooster
{

	protected $days = array(
		"ma" => 0,
		"di" => 1,
		"wo" => 2,
		"do" => 3,
		"vr" => 4,
	);

	public function __construct($leerling, $klas, $school)
	{
		$this->daysInWeek = 5;

		$url = $this->getURL($leerling, $klas, $school, "Leerlingrooster");

		$hours = $this->getHours($this->getXpath($url));

		$hours = $this->groupHours($hours);

		$this->hor_table = $this->toHorTable($hours);
		$this->vert_table = $this->toVertTable($hours);
	}

	public function getDay($day)
	{
		if (!is_int($day))
		{
			$day = $this->days[$day];
		}

		return $this->table[$day];
	}

	public function getTable()
	{
		return $this->hor_table;
	}

	public function getVertTable()
	{
		return $this->vert_table;
	}

	public function getHour($day, $hour)
	{
		if (!is_int($day))
		{
			$day = $this->days[$day];
		}

		return $this->table[$day][$hour -1];
	}

	public function getHTML($url)
	{
		$doc = new DOMDocument();
		@$doc->loadHTMLFile($url); // stfu operator ftw!
		return $doc;
	}

	public function getXpath($url)
	{
		$html = $this->getHTML($url);
		return new DOMXpath($html);
	}

	public function getHours(DOMXpath $xpath)
	{
		$tableCells = $xpath->query("//*[@class=\"tableCell\"]/table");

		$item = 0;

		$hours = [];

		while($node = $tableCells->item($item))
		{
			$hours[] = $node->nodeValue;
			$item++;
		}

		return $hours;
	}

	public function parseHours($hours)
	{


		return $hours;
	}

	public function getURL($leerling, $klas, $school, $type)
	{
		return "http://roosters.gepro-osi.nl/roosters/rooster.php?leerling={$leerling}&type={$type}&afdeling={$klas}&school={$school}";
	}

	public function groupHours(array $hours)
	{
		foreach ($hours as &$hour)
		{

			$hour = explode("&nbsp", $hour);


			foreach ($hour as &$i)
			{
				$i = trim($i);
			}

			$new = array(
				"teacher" => $hour[0],
				"room" => $hour[1],
				"subject" => $hour[2]
			);

			if (preg_match("/(\d+|\.)$/", $new["subject"], $matches))
			{
				$new["cluster"] = $matches[1];
				$new["subject"] = preg_replace("/\s*(?:\d+|\.)/", "", $new["subject"]);
			}

			$new["subject"] = preg_replace("/\s+(.|\s*)*/", "", $new["subject"]);

			$hour = $new;
		}

		return $hours;
	}

	public function toHorTable(array $hours)
	{

		$week = array();

		for ($i = 0; $i < $this->daysInWeek; $i++)
		{
			$week[$i] = array();
		}

		$hoursInOneDay = count($hours) / $this->daysInWeek;

		for ($hour = 0; $hour < $hoursInOneDay; $hour++)
		{
			for ($day = 0; $day < $this->daysInWeek; $day++)
			{
				$week[$day][$hour] = array_shift($hours);
			}
		}

		return $week;
	}

	public function toVertTable(array $hours)
	{

		$week = array();
		$day = array();

		$hoursInDay = count($hours) / $this->daysInWeek;

		foreach ($hours as $index => $hour)
		{
			$day[] = array_shift($hours);

			if (($index + 1) % $this->daysInWeek === 0)
			{
				$week[] = $day;
				$day = array();
			}

		}

		return $week;
	}
}