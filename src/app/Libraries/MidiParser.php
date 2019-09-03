<?php

class MidiParser {

	public function midiToNotesArray($midiFile, $difficultyConfig)
	{
		$midi = new \Midi();
		$midi->importMid($midiFile);
		$xml = $midi->getXml();

		$xml = \simplexml_load_string($xml);

		$difficulties = array();
		$difficultyNotes = array();

		if(is_null($difficultyConfig) || sizeof($difficultyConfig) == 0)
		{
			return null;
		}

		// create difficulty arrays
		foreach($difficultyConfig as $difficulty){
			$difficulties[] = $difficulty['notes'];
			$difficultyNotes[] = array(array(1 => array(), 2 => array(), 3 => array(), 4 => array(), 5 => array()));
		}

		// get ticks per beat and tempo value
		// TODO: this might not be correct, a songs tempo could change during play
		$ticksPerBeat = $xml->TicksPerBeat;

        $setTempoValue = false;
        foreach($xml->Track[0] as $event){
            if(isset($event->SetTempo['Value'])){
                $setTempoValue = $event->SetTempo['Value'];
            }
        }

        if(!$setTempoValue)
        {
        	// TODO: Handle the case of a non available tempo value (ERROR)
        	//die('Midi invalid: no_set_tempo_value');
        	return null;

        }
        else
        {

        	$currentTempoValueAbsolute = -1;
            $oneTick = 60000/(60000000/$setTempoValue*$ticksPerBeat); // duration of one tick in ms
            $notesArray = array();
            $noteValues = array();
            $maxTime = 0;

            $noteTrack = 1;

            if(!isset($xml->Track[$noteTrack]))
            {
            	$eachArray = $xml->Track;
            }
            else
            {
            	$eachArray = $xml->Track[$noteTrack];
            }

            foreach($eachArray->Event as $e){
            	if((int)$e->Absolute > (int)$currentTempoValueAbsolute){
            		foreach($xml->Track[0]->Event as $setTempoEvents){
            			if((int)$setTempoEvents->Absolute >= $e->Absolute){
            				$tempo = $setTempoEvents->SetTempo['Value'];
            				if($tempo > 0){
            					$oneTick = 60000/(60000000/$tempo*$ticksPerBeat);
            					$currentTempoValueAbsolute = (int)$e->Absolute;
            				}
            				break;
            			}
            		}
            	}

                if(isset($e->NoteOn) && $e->NoteOn['Note'] != 0){
		            $time = (($e->Absolute*$oneTick)/1000);

                    if($time >= $maxTime) $maxTime = $time;
                    if(!in_array($e->NoteOn['Note'], $noteValues) && strval($e->NoteOn['Note'])){
                        array_push($noteValues, strval($e->NoteOn['Note']));
                    }
                    $notesArray[] = array('time'=>$time, 'note'=>strval($e->NoteOn['Note']), 'type' => 'on');

                    if(in_array($e->NoteOn['Note'], $difficulties[0])){
                    	$tmp = array_flip($difficulties[0]);
	                    $difficultyNotes[0][] = array('time' => $time, 'note' => strval($e->NoteOn['Note']), 'type' => 'on', 'string' => $tmp[strval($e->NoteOn['Note'])]+1);
                    }elseif(in_array($e->NoteOn['Note'], $difficulties[1])){
                    	$tmp = array_flip($difficulties[1]);
	                    $difficultyNotes[1][] = array('time' => $time, 'note' => strval($e->NoteOn['Note']), 'type' => 'on', 'string' => $tmp[strval($e->NoteOn['Note'])]+1);
                    }elseif(in_array($e->NoteOn['Note'], $difficulties[2])){
                    	$tmp = array_flip($difficulties[2]);
	                    $difficultyNotes[2][] = array('time' => $time, 'note' => strval($e->NoteOn['Note']), 'type' => 'on', 'string' => $tmp[strval($e->NoteOn['Note'])]+1);
                    }elseif(in_array($e->NoteOn['Note'], $difficulties[3])){
                    	$tmp = array_flip($difficulties[3]);
	                    $difficultyNotes[3][] = array('time' => $time, 'note' => strval($e->NoteOn['Note']), 'type' => 'on', 'string' => $tmp[strval($e->NoteOn['Note'])]+1);
                    }
                }elseif(isset($e->NoteOff) && $e->NoteOff['Note'] != 0){
	                $time = (($e->Absolute*$oneTick)/1000);

                    if($time >= $maxTime) $maxTime = $time;
                    if(!in_array($e->NoteOff['Note'], $noteValues) && strval($e->NoteOff['Note'])){
                        array_push($noteValues, strval($e->NoteOff['Note']));
                    }
                    $notesArray[] = array('time'=>$time, 'note'=>strval($e->NoteOff['Note']), 'type' => 'off');

                    if(in_array($e->NoteOff['Note'], $difficulties[0])){
                    	$tmp = array_flip($difficulties[0]);
	                    $difficultyNotes[0][] = array('time' => $time, 'note' => strval($e->NoteOff['Note']), 'type' => 'off', 'string' => $tmp[strval($e->NoteOff['Note'])]+1);
                    }elseif(in_array($e->NoteOff['Note'], $difficulties[1])){
                    	$tmp = array_flip($difficulties[1]);
	                    $difficultyNotes[1][] = array('time' => $time, 'note' => strval($e->NoteOff['Note']), 'type' => 'off', 'string' => $tmp[strval($e->NoteOff['Note'])]+1);
                    }elseif(in_array($e->NoteOff['Note'], $difficulties[2])){
                    	$tmp = array_flip($difficulties[2]);
	                    $difficultyNotes[2][] = array('time' => $time, 'note' => strval($e->NoteOff['Note']), 'type' => 'off', 'string' => $tmp[strval($e->NoteOff['Note'])]+1);
                    }elseif(in_array($e->NoteOff['Note'], $difficulties[3])){
                    	$tmp = array_flip($difficulties[3]);
	                    $difficultyNotes[3][] = array('time' => $time, 'note' => strval($e->NoteOff['Note']), 'type' => 'off', 'string' => $tmp[strval($e->NoteOff['Note'])]+1);
                    }
                }
            }

            $bpm = 60000000/$setTempoValue;

			$possibleNotes = array();
			$checkNotes = array();
			foreach($notesArray as $key=>$note){
				if(!in_array($note['note'], $possibleNotes)){
					$possibleNotes[] = $note['note'];
				}
			}
			sort($possibleNotes);
			for($i = 0; $i < 5; $i++){
				$checkNotes[$i] = strval(array_pop($possibleNotes));
			}
			$checkNotes = array_flip(array_reverse($checkNotes));

			$finalNotesArray = array('difficulties' => array(
				1 => array(1 => array(), 2 => array(), 3 => array(), 4 => array(), 5 => array()),
				2 => array(1 => array(), 2 => array(), 3 => array(), 4 => array(), 5 => array()),
				3 => array(1 => array(), 2 => array(), 3 => array(), 4 => array(), 5 => array()),
				4 => array(1 => array(), 2 => array(), 3 => array(), 4 => array(), 5 => array()),
				5 => array(1 => array(), 2 => array(), 3 => array(), 4 => array(), 5 => array()),
			));

			foreach($difficultyNotes as $difficultyId => $notes)
			{
				foreach($notes as $i => $note)
				{
					if(!is_null($note) && isset($note['type']))
					{
						if($note['type'] == 'on')
						{
							$finalNotesArray['difficulties'][$difficultyId][$note['string']][] = array(
								'start' => $note['time'],
								'type' => 'short',
								'duration' => 0,
								'end' => 0
							);
						}
						elseif($note['type'] == 'off')
						{
							$tmp = $finalNotesArray['difficulties'][$difficultyId][$note['string']];
							$index = sizeof($tmp)-1;
							$start = $finalNotesArray['difficulties'][$difficultyId][$note['string']][$index]['start'];
							$end = $note['time'];
							$duration = $end - $start;
							$type = $duration >= 0.5 ? 'long' : 'short';
							$finalNotesArray['difficulties'][$difficultyId][$note['string']][$index]['end'] = $end;
							$finalNotesArray['difficulties'][$difficultyId][$note['string']][$index]['duration'] = $duration;
							$finalNotesArray['difficulties'][$difficultyId][$note['string']][$index]['type'] = $type;

						}
					}
				}
			}

			return $finalNotesArray;
        }
	}
}