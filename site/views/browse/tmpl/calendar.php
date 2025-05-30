<?php
/**
 * @package    hubzero-cms
 * @copyright  Copyright (c) 2005-2020 The Regents of the University of California.
 * @license    http://opensource.org/licenses/MIT MIT
 */

// No direct access
defined('_HZEXEC_') or die();

$database = App::get('db');

$gid = User::get('gid', 0);

$startday = ((!_CAL_CONF_STARDAY) || (_CAL_CONF_STARDAY > 1)) ? 0 : _CAL_CONF_STARDAY;

$date = new \Hubzero\Utility\Date('now', Config::get('offset'));
$timeWithOffset = $date->toLocal('U');


$to_day = date("Y-m-d", $timeWithOffset);

$day_name = array(
	Lang::txt('EVENTS_CAL_LANG_SUNDAYSHORT'),
	Lang::txt('EVENTS_CAL_LANG_MONDAYSHORT'),
	Lang::txt('EVENTS_CAL_LANG_TUESDAYSHORT'),
	Lang::txt('EVENTS_CAL_LANG_WEDNESDAYSHORT'),
	Lang::txt('EVENTS_CAL_LANG_THURSDAYSHORT'),
	Lang::txt('EVENTS_CAL_LANG_FRIDAYSHORT'),
	Lang::txt('EVENTS_CAL_LANG_SATURDAYSHORT')
);

$time  = mktime(0, 0, 0, intval($this->month), 1, intval($this->year) );
$ptime = mktime(0, 0, 0, ($this->month-1), 1, intval($this->year) );
$ntime = mktime(0, 0, 0, ($this->month+1), 1, intval($this->year) );

// This month
$cal_year  = date("Y", $time);
$cal_month = date("m", $time);
$calmonth  = date("n", $time);

$this_date = new \Components\Events\Helpers\EventsDate();
$this_date->setDate( $this->year, $this->month, $this->day );

$prev_month = clone($this_date);
$prev_month->addMonths( -1 );
$next_month = clone($this_date);
$next_month->addMonths( +1 );
$sql = "SELECT MIN(publish_up) min, MAX(publish_down) max FROM `#__events` as e
				WHERE `scope`='event'
				AND `state`=1
				AND `approved`=1";
$database->setQuery($sql);
$rows = $database->loadObjectList();
$first_event_time = new DateTime($rows[0]->min ? $rows[0]->min : '');
$last_event_time = new DateTime($rows[0]->max ? $rows[0]->max : '');
$this_datetime = new DateTime($this->year . '-' . $this->month . '-01');

//check for events before the first of this month
if ($this_datetime > $first_event_time) {
	$prev = Route::url( 'index.php?option='.$this->option.'&'. $prev_month->toDateURL($this->task) );
	$prev_text = Lang::txt('EVENTS_CAL_LANG_PREVIOUSMONTH');
} else {
	$prev = "javascript:void(0);";
	$prev_text = Lang::txt('EVENTS_CAL_LANG_NO_EVENTFOR') . ' ' . Lang::txt('EVENTS_CAL_LANG_PREVIOUSMONTH');
}
//get a DateTime for one month after currently viewed and disable URL if required
$this_datetime->add(new DateInterval("P1M"));
if ($this_datetime <= $last_event_time) {
	$next = Route::url( 'index.php?option='.$this->option.'&'. $next_month->toDateURL($this->task) );
	$next_text = Lang::txt('EVENTS_CAL_LANG_NEXTMONTH');
} else {
	$next = "javascript:void(0);";
	$next_text = Lang::txt('EVENTS_CAL_LANG_NO_EVENTFOR') . ' ' . Lang::txt('EVENTS_CAL_LANG_NEXTMONTH');
}

$content  = '<table class="ecalendar">'."\n";
$content .= ' <caption>';
if ($this->shownav) {
	$content .= '<a class="prv" href="'.$prev.'" title="'.$prev_text.'">&lsaquo;</a> <a class="nxt" href="'.$next.'" title="'.$next_text.'">&rsaquo;</a> ';
}
$content .= \Components\Events\Helpers\Html::getMonthName($cal_month).'</caption>'."\n";
$content .= ' <thead>'."\n";
$content .= '  <tr>'."\n";
for ($i=0; $i<7; $i++)
{
	$content.='   <th scope="col">'.$day_name[($i+$startday)%7].'</th>'."\n";
}
$content .= '  </tr>'."\n";
$content .= ' </thead>'."\n";
$content .= ' <tbody>'."\n";
$content .= '  <tr>'."\n";

// dmcd May 7/04 fix to fill in end days out of month correctly
$dayOfWeek = $startday;
$start = (date("w", mktime(0, 0, 0, $cal_month, 1, $cal_year))-$startday+7)%7;
$d = date("t", mktime(0, 0, 0, $cal_month, 0, $cal_year))-$start + 1;
$kownt = 0;

for ($a=$start; $a>0; $a--)
{
	$content .= '   <td';
	if ($a == $start) {
		$content .= ' class="weekend"';
	}
	$content .= '>&nbsp;</td>'."\n";
	$dayOfWeek++;
	$kownt++;
}

$monthHasEvent = false;
//$eventCheck = new EventsRepeat;
$lastDayOfMonth = date("t", mktime(0, 0, 0, $cal_month, 1, $cal_year));
$rd = 0;
for ($d=1; $d<=$lastDayOfMonth; $d++)
{
	$do = ($d<10) ? "0$d" : "$d";
	$selected_date = "$cal_year-$cal_month-$do";

	$sql = "SELECT * FROM `#__events` as e
	        WHERE `scope`='event'
			AND `state`=1
			AND `approved`=1
			AND ((`publish_up` >= '$selected_date 00:00:00' AND `publish_up` <= '$selected_date 23:59:59')
			OR (`publish_down` >= '$selected_date 00:00:00' AND `publish_down` <= '$selected_date 23:59:59')
			OR (`publish_up` <= '$selected_date 00:00:00' AND `publish_down` >= '$selected_date 23:59:59'))
			ORDER BY publish_up ASC";

	/*
	$sql = "SELECT #__events.* FROM #__events, #__categories as b"
		. "\n WHERE #__events.catid = b.id AND b.access <= $gid AND #__events.access <= $gid"
		. "\n AND ((publish_up >= '$selected_date 00:00:00' AND publish_up <= '$selected_date 23:59:59')"
		. "\n OR (publish_down >= '$selected_date 00:00:00' AND publish_down <= '$selected_date 23:59:59')"
		. "\n OR (publish_up <= '$selected_date 00:00:00' AND publish_down >= '$selected_date 23:59:59')) AND state='1'"
		. "\n ORDER BY publish_up ASC";
	*/
	$database->setQuery($sql);
	$rows = $database->loadObjectList();


	$class = ($selected_date == $to_day) ? 'today' : '';
	if ($d == $this->day) {
		//$class .= ' selected';
	}

	$hasevents = (count($rows) > 0) ? true : false;
	//for ($r = 0; $r < count($rows); $r++)
	//{
	//	if ($eventCheck->EventsRepeat($rows[$r], $cal_year, $cal_month, $do)) {
	//		$hasevents = true;
	//		//$class = ($selected_date == $to_day) ? 'today' : 'withevents';
	//		break;
	//	}
	//}
	if ((($dayOfWeek)%7 == $startday) || ((1 + $dayOfWeek)%7 == $startday)) {
		$class .= ' weekend';
	}
	// Only adds link if event scheduled that day
	$content .= '   <td';
	$content .= ($class) ? ' class="'.$class.'">' : '>';
	if ($hasevents) {
		$content .= '<a class="mod_events_daylink" href="'.Route::url('index.php?option='.$this->option.'&year='.$cal_year.'&month='.$cal_month.'&day='.$do).'">'.$d.'</a>';
	} else {
		$content .= $d;
	}
	$content .= '</td>'."\n";
	$rd++;

	// Check if Next week row
	if ((1 + $dayOfWeek++)%7 == $startday) {
		$content .= '  </tr>'."\n";
		$content .= '  <tr>'."\n";
		$rd = ($rd >= 7) ? 0 : $rd;
	}
}

for ($d=$rd; $d<=6; $d++)
{
	$content .= '   <td';
	if ($d == 6) {
		$content .= ' class="weekend"';
	}
	$content .= '>&nbsp;</td>'."\n";
}

$content .= '  </tr>'."\n";
$content .= ' </tbody>'."\n";
$content .= '</table>'."\n";

echo $content;
