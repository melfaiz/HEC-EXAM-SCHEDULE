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





function exams_list($bdd,$list_day,$month,$year){

    $date = $year."-".$month."-".$list_day;
    $query = "SELECT * FROM schedule 
    LEFT JOIN cours_aa
    ON cours_aa.code_cours = schedule.code_cours
    WHERE schedule.date='$date' 

    ";
    $req   = $bdd->query($query);
    
    
    $list = [];

    $i = 0;
    if ($req->rowCount()) {

        while ($tuple = $req->fetch()) {

            $exam = [];

            $exam['intitule'] = $tuple['intitule'];
            $exam['comment'] = $tuple['comment'];
            $exam['heure'] = $tuple['heure_debut'];
            $exam['duree'] = $tuple['duree'];

            $list[$tuple['code_cours']] = $exam;

            $i = $i+1;

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

          


            $list = exams_list($bdd,$list_day,$month,$year);

            $calendar .= '<table class="table table-sm table-striped">
            <tbody>';
            
           
            foreach ($list as $code => $array) {
                 
                $exam = $array;                
               
                $calendar.= '<tr>';
    
                    $calendar .= '<td>'. $code.'</td>';
                   
                    $calendar .= '<td>'. shorten_text($exam['intitule']).'</td>';

                    $calendar .=  '<td><a href="" data-toggle="modal" data-target="#'. $code .'">'. comment_icon() .'</a></td>';

                    $calendar .=  '<td><a href="delete.php?code_cours='.$code.'">'. delete_icon() .'</a></td>';

                    $myDateTime = DateTime::createFromFormat('H:i:s', $exam['heure']);
                    $time = $myDateTime->format('H:i');
                    
                    $calendar .= '
                    <div class="modal fade" id="'. $code .'" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                      <div class="modal-dialog" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h4 class="modal-title" id="exampleModalLabel">'. $code . ' : '.$exam['intitule']  .'</h4>
                          </div>

                          <div class="modal-body">
                          
                          <p> <h5>Heure: </h5><h6>'. $time .' </h6></p>
                          <p> <h5>Commentaires: </h5><h6>'. $exam['comment'] .' </h6></p>


                          <form>

                        </form>


                        </div>



                        </div>
                      </div>
                    </div>';
    
                    
    
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

function delete_icon(){
    return '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 12 16" width="12" height="16"><path fill-rule="evenodd" d="M11 2H9c0-.55-.45-1-1-1H5c-.55 0-1 .45-1 1H2c-.55 0-1 .45-1 1v1c0 .55.45 1 1 1v9c0 .55.45 1 1 1h7c.55 0 1-.45 1-1V5c.55 0 1-.45 1-1V3c0-.55-.45-1-1-1zm-1 12H3V5h1v8h1V5h1v8h1V5h1v8h1V5h1v9zm1-10H2V3h9v1z"></path></svg>';
}

function comment_icon(){
    return '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 12 16" width="12" height="16"><path fill-rule="evenodd" d="M6 5H2V4h4v1zM2 8h7V7H2v1zm0 2h7V9H2v1zm0 2h7v-1H2v1zm10-7.5V14c0 .55-.45 1-1 1H1c-.55 0-1-.45-1-1V2c0-.55.45-1 1-1h7.5L12 4.5zM11 5L8 2H1v12h10V5z"></path></svg>';
}

function shorten_text($text){

    if (strlen($text) < 20) {
        return $text;
    }else{
        return substr($text,0,20)."..." ;
    }


}


function append_exam($bdd,$cours_aa,$date,$heure,$duree,$comment){

    $sql = "INSERT INTO schedule (code_cours, date,heure_debut,duree,comment) VALUES (?,?,?,?,?)";

    $stmt= $bdd->prepare($sql);

    $stmt->execute([$cours_aa, $date,$heure,$duree,$comment]);

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
                echo "<tr data-partim='true' id='".$tuple['code_cours']."' draggable='true' ondragstart='drag(event)' data-toggle='tooltip' data-placement='right' title=' Programme: ".$tuple['programme_long']."'>";
                echo "<td>" .$tuple['code_cours']."</td>";
                echo "<td>" .$tuple['intitule']."</td></tr>";
                $id++;
                
                if($tuple['meanwhile_id_cours_aa']!=0){
                    $meanwhile=$tuple['meanwhile_id_cours_aa'];
                    $query_meanwhile="SELECT * FROM cours_aa WHERE id_cours_aa='$meanwhile'";
                    $req_meanwhile=$bdd->query($query_meanwhile);
                    if($req_meanwhile->rowCount()){
                        while ($tuple_meanwhile=$req_meanwhile->fetch()){
                            echo "<tr data-toggle='tooltip'  data-placement='right' title=' Programme: ".$tuple['programme_long']."'>";
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