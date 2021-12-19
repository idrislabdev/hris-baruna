<?php

class DrawKalenderAkademik
{
	var $startEvent = array();
	var $endEvent = array();
	var $eventName = array();
	var $jan, $feb, $mar, $apr, $may, $jun, $jul, $aug, $sep, $oct, $nov, $dec;
	
	function DrawKalenderAkademik()
	{
		$kabisat = date("Y");
		if($kabisat % 4 == 0)
			$this->feb = 29;
		else
			$this->feb = 28;
		
		$this->jan = 31;
		$this->mar = 31;
		$this->apr = 30;
		$this->may = 31;
		$this->jun = 30;
		$this->jul = 31;
		$this->aug = 31;
		$this->sep = 30;
		$this->oct = 31;
		$this->nov = 30;
		$this->dec = 31;
	}
	
	function setEvent($start, $end, $name)
	{
		$arrStart = explode('-', $start);
		$start = $arrStart[1].'-'.$arrStart[2];
		
		$arrEnd = explode('-', $end);
		$end = $arrEnd[1].'-'.$arrEnd[2];
		
		$this->startEvent[] = $start;
		$this->endEvent[] = $end;
		$this->eventName[] = $name;
	}
	
	// input berupa date yg udah diformat sama konstruktor (MM-DD)
	function getMonth($_date)
	{
		$arrMonth = explode('-', $_date);
		$month = $arrMonth[0];
		
		return $month;
	}
	
	function drawMonthInit($monthDay, $monthNum, $monthName)
	{
		$str  = '	<table border="1">';
		$str .= '		<tr>';
		$str .= '			<td colspan="'.$this->monthDay.'">'.$monthName.'</td>';
		$str .= '		</tr>';
		$str .= '		<tr>';
		
		$dayCount = 1;
		$monthId = $monthNum.'-'.$dayCount;
		for($i = 1; $i <= $this->jan; $i++)
		{
			if($monthId == $this->startEvent)
			$str .= '		<td>'.$i.'</td>';
			
			$dayCount++;
		}
	}
	
	
}


?>