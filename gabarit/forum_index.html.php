<?php
defined( '_VALID_CORE_FORUM_INDEX' ) or die( 'Restricted access' );
require_once('./templates/'.$link_style.'top.php');

if(!empty($boards)){
	$cur_cat = 0;

foreach($boards as $board){		
	//Security
	if($secureObject->verifyAuthorization('FO_FORUM_BOARD_'.$board->bid.'_READ')==TRUE){

		if($board->catid != $cur_cat){
			if($cur_cat != 0){
				echo '</tbody></table></div></div></div>';
			}
			
			echo '
			<div id="cat'.intval($board->catid).'" class="blocktable">
				
				<div class="box">
					<div class="inbox">
						<table class="fofotable">
							<thead>
								<tr>
									<th class="ft2" scope="col">'.stripslashes(htmlspecialchars($board->cat_name)).'</th>
									<th class="ft3" scope="col">Sujets</th>
									<th class="ft3" scope="col">Messages</th>
									<th class="ft4" scope="col"><center>Dernier message</center></th>
								</tr>
							</thead>
						<tbody>
			';
			$cur_cat = $board->catid;
		}
	
		echo '<tr class="tr">
		<td class="ft2">
		<div class="forum_index">&nbsp;</div>
		<a class="section" href="index.php?comp=forum_board&amp;select='.$board->bid.'&amp;start=0">
		'.stripslashes(htmlspecialchars($board->board_name)).'
		</a><br />
		<p class="index_details">'.stripslashes(htmlspecialchars($board->board_description)).'</p>
		<br />
		Tags : ';
		$listags = explode(';', $board->tags);
		foreach($listags as $tag){
			$datatag = explode('|', $tag);
			echo '[<a class="tag" href="index.php?comp=forum_board&amp;select='.$board->bid.'&amp;start=0&filter='.$datatag[0].'&amp;filteraction=add">'.$datatag[1].'</a>] ';
		}
		
		echo ' 
		</td>
		<td class="ft3"><center>'.$board->nb_topics.'</center></td>
		<td class="ft3"><center>'.$board->nb_posts.'</center></td>
		<td class="ft4">
		';
		
		if(!empty($board->post_time)){
			
			$pseudoToPrint = ($board->cat_rp==1) ? (empty($board->guid)) ? 'Anonyme' : '<a href="./index.php?comp=bg_show&amp;guid='.$board->guid.'">'.stripslashes(htmlspecialchars($board->name)).'</a>' : '<a href="./index.php?comp=profil&amp;select='.$board->uid.'">'.stripslashes(htmlspecialchars($board->pseudo)).'</a>';
			
			echo '<center>'.format_time($board->post_time).' 
				<br /> '.$pseudoToPrint.'
				<a href="./index.php?comp=forum_topic&amp;select='.$board->tid.'&amp;goto='.$board->pid.'#pid'.$board->pid.'" onmouseover="Tip(\''.stripslashes(htmlspecialchars(addslashes($board->subject))).'\')" onmouseout="UnTip()"><img src="./templates/'.$link_style.'/ico/last.png" alt="Dernier message" title="'.stripslashes(htmlspecialchars($board->subject)).'"/></a>';
			echo'</center>';
		}
		else{
			echo '<center>Aucun message</center>';
		}
		echo '</td></tr>';
	}
}
	echo '</tbody></table></div></div></div>';
}
else{
	echo 'Vous devez être inscrit et connecté pour pouvoir consulter le forum.';
}

require_once('./templates/'.$link_style.'bottom.php');

?>
