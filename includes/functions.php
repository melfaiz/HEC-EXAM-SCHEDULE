<?php

include('db.php');


function liste_cours_aa($bdd, $niveau, $annee, $bloc)
{   
    

    $query = "SELECT cours_aa.intitule as nom_cours , cours_aa.code_cours as code , programme_aa.niveau as niveau , programme_aa.programme_en as programme , cours_aa.meanwhile_id_cours_AA as meanwhile_id_cours_AA 
    FROM cours_aa,programme_aa
    WHERE (cours_aa.id_cours_AA,programme_aa.id_programme_AA) IN (

        SELECT id_cours_AA , id_programme_AA
        FROM cours_aa_pgm
        WHERE bloc = $bloc


    ) 
    
    AND jour_HD = 'jour'
    AND id_faculte = 'G' 
    AND niveau = '$niveau' 
    AND programme_aa.AA = $annee
    AND flag_pas_organise = 0

    ORDER BY nom_cours ASC
    ";
$req   = $bdd->query($query);

if ($req->rowCount()) {

echo "
<div class='table-responsive '>
    <table class='table table-striped table-sm sortable '>";


echo "<tbody>";
$id=0;
while ($tuple = $req->fetch()) {
    
    echo "<tr id='".$tuple['code']."' draggable='true' ondragstart='drag(event)' data-toggle='tooltip' data-placement='right' title=' Programme: ".$tuple['programme']."'>";
    echo "<td>" . $tuple['code'] . "</td>";
    
    echo "<td>" . $tuple['nom_cours'] . "</td> ";
    
    $id++;
    
}


echo "
        </tbody>
    </table>
</div>";



}
}





function exam($bdd,$list_day,$month,$year){

    $date = $year."-".$month."-".$list_day;
    $query = "SELECT * FROM schedule 
    LEFT JOIN cours_aa
    ON cours_aa.code_cours = schedule.code_cours

    WHERE schedule.date='$date' 

    ";
    $req   = $bdd->query($query);
    
    $list = [];

    if ($req->rowCount()) {
        
       
        while ($tuple = $req->fetch(PDO::FETCH_ASSOC)) {
            
            $des = $tuple['intitule'];
            $list[$tuple['code_cours']] = $des;
   
            
        }

    }

    return $list;
}


/* draws a calendar */
function draw_calendar($bdd,$month,$year){

	/* draw table */
	$calendar = '<table cellpadding="0" cellspacing="0" class="calendar">';

	/* table headings */
	$headings = array('Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday');
	$calendar.= '<tr class="calendar-row"><td class="calendar-day-head">'.implode('</td><td class="calendar-day-head">',$headings).'</td></tr>';

	/* days and weeks vars now ... */
	$running_day = date('w',mktime(0,0,0,$month,1,$year));
	$days_in_month = date('t',mktime(0,0,0,$month,1,$year));
	$days_in_this_week = 1;
	$day_counter = 0;
	$dates_array = array();

	/* row for week one */
	$calendar.= '<tr class="calendar-row">';

	/* print "blank" days until the first of the current week */
	for($x = 0; $x < $running_day; $x++):
		$calendar.= '<td class="calendar-day-np"> </td>';
		$days_in_this_week++;
	endfor;



	/* keep going with days.... */
    for($list_day = 1; $list_day <= $days_in_month; $list_day++):
        $date = $year. "-" .$month ."-".$list_day;
        
		$calendar.= '<td class="calendar-day" ondrop="drop(event,\'' . $date . '\')" ondragover="allowDrop(event)"  >';
			/* add in the day number */
            $calendar.= '<div class="day-number">'.$list_day.'</div>';
            // $calendar.= '<div class="day-number">'.$date.'</div>';
          
            $exams_list = exam($bdd,$list_day,$month,$year);


            $calendar .= '<table class="table table-sm table-striped">
            <tbody>';

            foreach ($exams_list as $key => $value) {

                
                $calendar.= '<tr>';

                    $calendar .= '<td>'.$key.'</td>';
                    $calendar .= '<td>'.$value.'</td>';
                    
                    $calendar .= '<td><a href="delete.php?code_cours='.$key.'">
                    <svg class="bi bi-x-circle-fill" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" d="M16 8A8 8 0 110 8a8 8 0 0116 0zm-4.146-3.146a.5.5 0 00-.708-.708L8 7.293 4.854 4.146a.5.5 0 10-.708.708L7.293 8l-3.147 3.146a.5.5 0 00.708.708L8 8.707l3.146 3.147a.5.5 0 00.708-.708L8.707 8l3.147-3.146z" clip-rule="evenodd"/>
                    </svg>
                    </a></td>';

                $calendar.= '</tr>';



            }

            $calendar.= '  </tbody>
            </table>';
            
           



        $calendar.= '</td>';
        


		if($running_day == 6):
			$calendar.= '</tr>';
			if(($day_counter+1) != $days_in_month):
				$calendar.= '<tr class="calendar-row">';
			endif;
			$running_day = -1;
			$days_in_this_week = 0;
		endif;
		$days_in_this_week++; $running_day++; $day_counter++;
	endfor;

	/* finish the rest of the days in the week */
	if($days_in_this_week < 8):
		for($x = 1; $x <= (8 - $days_in_this_week); $x++):
			$calendar.= '<td class="calendar-day-np"> </td>';
		endfor;
	endif;

	/* final row */
	$calendar.= '</tr>';

	/* end the table */
	$calendar.= '</table>';
	
	/* all done, return result */
	return $calendar;
}


function append_exam($bdd,$cours_aa,$date){

    $sql = "INSERT INTO schedule (code_cours, date) VALUES (?,?)";

    $stmt= $bdd->prepare($sql);

    $stmt->execute([$cours_aa, $date]);

    $sql = "UPDATE cours_aa SET exam = 1 WHERE code_cours='$cours_aa'";

    $stmt= $bdd->prepare($sql);

    $stmt->execute();


}

function delete_exam($bdd,$cours){

    $sql = "DELETE FROM schedule WHERE code_cours='$cours'";

    $stmt= $bdd->prepare($sql);

    $stmt->execute();

    $sql = "UPDATE cours_aa SET exam = 0 WHERE code_cours='$cours'";

    $stmt= $bdd->prepare($sql);

    $stmt->execute();



}


function liste_programme_aa($bdd, $annee, $bloc,$session,$programme)
{

    if($session=="Janvier"){
        $session = "('Q1')";
    }else if($session=="Juin"){
        $session = "('TA','Q2')";
    }else if ($session=="Septembre") {
        $session = "('TA','Q1','Q2')";
    }

    try {

        $query = "SELECT * FROM programme_aa, cours_aa, cours_aa_pgm WHERE cours_aa.exam = 0 AND
        cours_aa.aa = '$annee' AND programme_aa.programme_long = '$programme' AND programme_aa.id_faculte = 'G' AND programme_aa.jour_HD='jour' AND cours_aa_pgm.bloc='$bloc' AND programme_aa.id_programme_aa=cours_aa_pgm.id_programme_aa AND cours_aa_pgm.id_cours_aa=cours_aa.id_cours_aa AND ( cours_aa.quadri IN $session or cours_aa.quadri  IS NULL )
        ORDER BY programme_aa.programme_en, cours_aa.id_cours_aa " ;
    
        $req   = $bdd->query($query);
        
        if ($req->rowCount()) {
            echo "
            <div class='table-responsive'>
                <table class='table table-striped table-sm'>";
            echo "
            <thead>
                <tr>

                    <th>Code cours</th>
                    <th>Nom du cours</th>
                </tr>
            </thead>";
            echo "<tbody>";
            $id=1;
            while ($tuple = $req->fetch()) {
                echo "<tr id='".$tuple['code_cours']."' draggable='true' ondragstart='drag(event)' data-toggle='tooltip' data-placement='right' title=' Programme: ".$tuple['programme_long']."'>";
                echo "<td>" .$tuple['code_cours']."</td>";
                echo "<td>" .$tuple['intitule']."</td></tr>";
                $id++;
                
                if($tuple['meanwhile_id_cours_aa']!=0){
                    $meanwhile=$tuple['meanwhile_id_cours_aa'];
                    $query_meanwhile="SELECT * FROM cours_aa WHERE id_cours_aa='$meanwhile'";
                    $req_meanwhile=$bdd->query($query_meanwhile);
                    if($req_meanwhile->rowCount()){
                        while ($tuple_meanwhile=$req_meanwhile->fetch()){
                            echo "<tr data-toggle='tooltip' data-placement='right' title=' Programme: ".$tuple['programme_long']."'>";
                            echo "<td style='color: red;'>Liaison: </td>";
                            echo "<td style='color: red;'>".$tuple_meanwhile['intitule']."</td></tr>";
                        }
                    }
                }
                
                if($tuple['flag_partimes']==1){
                    $cours_partim=$tuple['id_cours_aa'];
                    $query_partim="SELECT cours_aa_partim.id_partim FROM cours_aa_partim WHERE cours_aa_partim.id_cours_aa='$cours_partim'";
                    $req_partim=$bdd->query($query_partim);
                    if($req_partim->rowCount()){
                        while ($tuple_partim=$req_partim->fetch()){
                            $partim_id=$tuple_partim['id_partim'];
                            $query_partim_intitule="SELECT partim_aa.partim FROM partim_aa WHERE partim_aa.id_partim_aa='$partim_id'";
                            $req_partim_intitule=$bdd->query($query_partim_intitule);
                            if($req_partim_intitule->rowCount()){
                                while ($tuple_partim_intitule=$req_partim_intitule->fetch()){
                                    echo "<tr data-toggle='tooltip' data-placement='right' title=' Programme: ".$tuple['programme_long']."'>";
                                    echo "<td style='color: red;'>Partim: </td>";
                                    echo "<td style='color: red;'>".$tuple_partim_intitule['partim']."</td></tr>";
                                }
                            }
                        }
                    }
                }
            }
            echo "
                    </tbody>
                </table>
            </div>";  
        }

    } catch (\Throwable $th) {
        //throw $th;
    }
    

}
?>