<?php
	/*
		Script d'extraction de données tabulées à partir des informations contenus dans le fichier PDF des aides à la presse 2012 fourni par le ministère de la culture et de la communication.
		Licence : pas sûr que ça en mérite une, faites en ce que vous voulez
		Version : 0.1, seule et unique
	*/
	$metadata = simplexml_load_file("aides.xml");
	$i = 0;
	$current_id = 1;

	$fh = fopen("aides.csv", "w");
	
	foreach ($metadata->page as $page)
	{
		$i++;
		$lines = array();
		foreach($page->text as $text)
		{
			$attrs = $text->attributes();
			$tmp_line = new stdClass();
			$tmp_line->{'text'} = strip_tags($text->asxml());
			$tmp_line->{'top'} = intval($attrs["top"]);
			$tmp_line->{'left'} = intval($attrs["left"]);
			if ( ($tmp_line->{'left'} < 60) and (intval($attrs["width"]) > 20) )
			{
				// On est dans le cas des lignes > 100, regroupées au sein d'un même groupe car trop proches
				$zone = strip_tags($text->asxml(), "<b>");
				$tmp_line->{'text'} = preg_replace("/^<b>(.*)<\/b>.*$/", "$1", $zone);
				$tmp_line_titre = new stdClass();
				$tmp_line_titre->{'text'} = preg_replace("/^.*<\/b>(.*)$/", "$1", $zone);
				$tmp_line_titre->{'left'} = 84;
				$tmp_line_titre->{'top'} = $tmp_line->{'top'};
				array_push($lines, $tmp_line_titre);
			}

			array_push($lines, $tmp_line);
		}
		usort($lines, 'sort_page');

		// On va vérifier les cas où on n'a qu'un pixel de différence, lié à des petits décalages
		$tmp_top = -1;
		foreach($lines as $line)
		{
			if ($line->{'top'} == ($tmp_top + 1))
			{
				$line->{'top'} = $tmp_top;
			}
			$tmp_top = $line->{'top'};
		}
		usort($lines, 'sort_page');

		$tmp_prev = "";
		while ($line = array_shift($lines))
		{
			if ($line->{'text'} == $current_id)
			{
				// On est sur l'id
				$tmp_line = array();
				for ($i = 0; $i <= 12; $i++)
				{
					$tmp_line[$i] = "";
				}
				$tmp_line[0] = $current_id;
				$current_top = $line->{'top'};
				reset($lines);
				while ($lines[0]->{'top'} == $current_top)
				{
					$zone = array_shift($lines);
					$l = $zone->{'left'};
					$txt = $zone->{'text'};
					if ( ($l > 80) and ($l < 295) )
					{
						$tmp_line[1] = $txt; # titre
					}
					elseif ( ($l >= 295) and ($l < 395) )
					{
						$tmp_line[2] = $txt; # famille
					}
					elseif ( ($l >= 395) and ($l < 480) )
					{
						$tmp_line[3] = $txt; # total des aides en €
					}
					elseif ( ($l >= 480) and ($l < 550) )
					{
						$tmp_line[4] = $txt; # dont postale
					}
					elseif ( ($l >= 550) and ($l < 630) )
					{
						$tmp_line[5] = $txt; # dont aide aux tiers
					}
					elseif ( ($l >= 630) and ($l < 705) )
					{
						$tmp_line[6] = $txt; # dont aides directes
					}
					elseif ( ($l >= 705) and ($l < 785) )
					{
						$tmp_line[7] = $txt; # diffusion / an
					}
					elseif ( ($l >= 785) and ($l < 885) )
					{
						$tmp_line[8] = $txt; # aides totales par exemplaires
					}
					elseif ( ($l >= 885) and ($l < 965) )
					{
						$tmp_line[9] = $txt; # aides postales par exemplaire
					}
					elseif ( ($l >= 965) and ($l < 1055) )
					{
						$tmp_line[10] = $txt; # aides aux tiers par exemplaires
					}
					elseif ( ($l >= 1055) and ($l < 1160) )
					{
						$tmp_line[11] = $txt; # aides directes par exemplaire
					}
//					print "\t".$zone->{'left'}." = ".$zone->{"text"}."\n";
					reset($lines);
				}

				if ($tmp_line[1] == "")
				{
					$line = array_shift($lines);
					$titre = $tmp_prev->{'text'}." ".$line->{'text'};
					$tmp_line[1] = $titre;
				}
				fputs($fh, join($tmp_line, "\t")."\n");
				$current_id++;
			}
			else
			{
				$tmp_prev = $line;
			}
		}
	}

	function sort_page($t1, $t2) {
		$a_t = $t1->{"top"};
		$b_t = $t2->{"top"};

		$a_l = $t1->{"left"};
		$b_l = $t2->{"left"};

		if ($a_t == $b_t) {
			if ($a_l == $b_l)
			{
				return 0;
			}
			else
			{
				return ($a_l < $b_l) ? -1 : 1;
			}
		}
    return ($a_t < $b_t) ? -1 : 1;
	}

?>
