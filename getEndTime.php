<?php

function getEndTime($start, $timeNeed) {
	$pDay = date('Y-m-d', strtotime($start));
	$pN = date('w', strtotime($pDay));
	$startTime = date('H:i:s', strtotime($start));
	$jumpDay = false;
	$secu = 0;
	do {
		/* Open this day */
		if (!empty(OPENING_TIME[$pN])) {
			for ($i=0; $i < sizeof(OPENING_TIME[$pN]); $i++) { 
				$opening = OPENING_TIME[$pN][$i][0];
				$closing = OPENING_TIME[$pN][$i][1];
				/* Modification faite en dehors des heures d'ouvertures */
				if (empty($diff) && $startTime < $opening) {
					$pTime = date('H:i:s', strtotime($pDay.' '.$opening.' '.$timeNeed));
				}
				elseif (empty($pTime) && $jumpDay) {
					$pTime = date('H:i:s', strtotime($pDay.' '.$opening.' '.$timeNeed));
				}
				else if (empty($pTime) && $startTime >= $closing) {
					if (empty(OPENING_TIME[$pN][$i+1])) {
						$jumpDay = true;
						break;
					} else {
						continue;
					}
				}
				else if (!empty($diff)) {
					$pTime = date('H:i:s', strtotime($pDay.' '.$opening.' '.$diff));
				}
				else {
					$pTime = date('H:i:s', strtotime($pDay.' '.$startTime.' '.$timeNeed));
				}

				if ($pTime > $closing) {
					$d = new DateTime($pDay.' '.$pTime);
					$diff = $d->diff(new DateTime(date($pDay.' '.$closing)))->format(" + %h hours + %i min + %s sec");
				} else {
					$output = date('Y-m-d H:i:s', strtotime($pDay.' '.$pTime));
					break 2;
				}
			}
		}
		/* Closed this day */
		else {
			$jumpDay = true;
		}
		$pDay = date('Y-m-d', strtotime($pDay.' + 1 day'));
		$pN = (int)date('w', strtotime($pDay));
		$secu++;
	} while ( empty($output) && $secu < 100 );
	if ($secu == 100) {
		die('ERROR : infinite loop');
	}

	return $output;
}