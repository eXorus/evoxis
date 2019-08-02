<?php
defined( '_VALID_CORE_NOTIFICATIONS' ) or die( 'Restricted access' );
require_once('./templates/'.$link_style.'top.php');


function AffDate($date){
 if(!ctype_digit($date))
  $date = strtotime($date);
 if(date('Ymd', $date) == date('Ymd')){
  $diff = time()-$date;
  if($diff < 60){ /* moins de 60 secondes */
   $value= $diff;
   $pluriel = ($value>1) ? 's' : '';
   return 'Il y a '.$value.' seconde'.$pluriel;
  
  }else if($diff < 3600){ /* moins d'une heure */
   $value=round($diff/60, 0);
   $pluriel = ($value>1) ? 's' : '';
   return 'Il y a '.$value.' minute'.$pluriel;
   
  }else if($diff < 10800){ /* moins de 3 heures */
   $value=round($diff/3600, 0);
   $pluriel = ($value>1) ? 's' : '';
   return 'Il y a '.$value.' heure'.$pluriel;
   
  }else /*  plus de 3 heures ont affiche ajourd'hui à HH:MM:SS */
   return 'Aujourd\'hui à '.date('H:i:s', $date);
 }
 else if(date('Ymd', $date) == date('Ymd', strtotime('- 1 DAY')))
  return 'Hier à '.date('H:i:s', $date);
 else if(date('Ymd', $date) == date('Ymd', strtotime('- 2 DAY')))
  return 'Il y a 2 jours à '.date('H:i:s', $date);
 else
  return 'Le '.date('d/m/Y à H:i:s', $date);
}


$icoNew = '<img src="./templates/'.$link_style.'/ico/new.gif" alt="New"/>';


if (!empty($notifMPS)){
	echo '<div class="blocktable">
	<div class="box">
					<div class="inbox">
						<table class="fofotable">
							<thead>
								<tr>
									<th class="ft2" scope="col">Notifications: Messagerie</th>
									<th class="ft4" scope="col"></th>
								</tr>
							</thead>
						<tbody>
	';
	foreach($notifMPS as $notifMP){
		
		$addIcoNew = (empty($notifMP->last_id)) ? $icoNew : '';
		$addLinkPrev = (empty($notifMP->last_id)) ? '' : '#mpid'.$notifMP->last_id;
		
		echo '<tr>
			<td><a href="./index.php?comp=mp_view&amp;dpid='.$notifMP->id.''.$addLinkPrev.'">'.stripslashes(htmlspecialchars($notifMP->title)).'</a> '.$addIcoNew.'</td>
			<td>'.AffDate($notifMP->date).'</td>
			</tr>';
	}
	
	echo '</tbody></table></div></div></div>';
}

if (!empty($notifNEWS)){
	echo '<div class="blocktable">
	<div class="box">
					<div class="inbox">
						<table class="fofotable">
							<thead>
								<tr>
									<th class="ft2" scope="col">Notifications: Evoxis Hebdo</th>
									<th class="ft4" scope="col"></th>
								</tr>
							</thead>
						<tbody>
	';
	foreach($notifNEWS as $notifNEW){
		
		$addIcoNew = (empty($notifNEW->toto)) ? $icoNew : '';
		
		echo '<tr>
			<td><a href="./index.php?comp=forum_topic&amp;select='.$notifNEW->id.'&amp;start=0">'.stripslashes(htmlspecialchars($notifNEW->title)).'</a> '.$addIcoNew.'</td>
			<td>'.format_time_to_delta($notifNEW->dateInterval).'</td>
			</tr>';
	}
	
	echo '</tbody></table></div></div></div>';
}

if (!empty($notifFORUMS)){
	echo '<div class="blocktable">
	<div class="box">
					<div class="inbox">
						<table class="fofotable">
							<thead>
								<tr>
									<th class="ft2" scope="col">Notifications: Forum</th>
									<th class="ft4" scope="col"></th>
								</tr>
							</thead>
						<tbody>
	';
	foreach($notifFORUMS as $notifFORUM){
		
		$addIcoNew = (empty($notifFORUM->toto)) ? $icoNew : '';
		
		echo '<tr>
			<td><a href="./index.php?comp=forum_topic&amp;select='.$notifFORUM->tid.'&amp;start=0">'.stripslashes(htmlspecialchars($notifFORUM->subject)).'</a> '.$addIcoNew.'</td>
			<td>'.format_time_to_delta($notifFORUM->dateInterval).'</td>
			</tr>';
	}
	
	echo '</tbody></table></div></div></div>';
}

if (!empty($notifBACKGROUNDS)){
	echo '<div class="blocktable">
	<div class="box">
					<div class="inbox">
						<table class="fofotable">
							<thead>
								<tr>
									<th class="ft2" scope="col">Notifications: Background</th>
									<th class="ft4" scope="col"></th>
								</tr>
							</thead>
						<tbody>
	';
	foreach($notifBACKGROUNDS as $notifBACKGROUND){
		
		$addIcoNew = (empty($notifBACKGROUND->toto)) ? $icoNew : '';
		
		echo '<tr>
			<td><a href="./index.php?comp=bugtracker_view&amp;select='.$notifBACKGROUND->btid.'">'.stripslashes(htmlspecialchars($notifBACKGROUND->bt_name)).'</a> '.$addIcoNew.'</td>
			<td>'.format_time_to_delta($notifBACKGROUND->dateInterval).'</td>
			</tr>';
	}
	
	echo '</tbody></table></div></div></div>';
}


if (!empty($notifBUGTRACKERS)){
	echo '<div class="blocktable">
	<div class="box">
					<div class="inbox">
						<table class="fofotable">
							<thead>
								<tr>
									<th class="ft2" scope="col">Notifications: BugTracker</th>
									<th class="ft4" scope="col"></th>
								</tr>
							</thead>
						<tbody>
	';
	foreach($notifBUGTRACKERS as $notifBUGTRACKER){
		
		$addIcoNew = (empty($notifBUGTRACKER->toto)) ? $icoNew : '';
		
		echo '<tr>
			<td><a href="./index.php?comp=bugtracker_view&amp;select='.$notifBUGTRACKER->btid.'">'.stripslashes(htmlspecialchars($notifBUGTRACKER->bt_name)).'</a> '.$addIcoNew.'</td>
			<td>'.format_time_to_delta($notifBUGTRACKER->dateInterval).'</td>
			</tr>';
	}
	
	echo '</tbody></table></div></div></div>';
}

?>


			</table>
			
		</div>
		</td>
	</tr>
	<tr>
		<td>
		<div class="box_notif">
			<h5>Forum</h5>
			<ul>
				<li>fofo 1</li>
				<li>fofo 2</li>
				<li>fofo 3</li>				
			</ul>
			
		</div>
		</td>

		<td>
		<div class="box_notif">
			<h5>Bugtracker</h5>
			<table class="data_notif">
			<?php
			if(!empty($bugtrackers)){
				foreach($bugtrackers as $bugtracker){
					$new = (empty($bugtracker->uid)) ? ' class="new"' : '' ;				
					echo '<tr'.$new.'>
						<td><a href="./index.php?comp=bugtracker_view&amp;select='.$bugtracker->btid.'#btcid'.$bugtracker->last_btcid.'">'.stripslashes(htmlspecialchars($bugtracker->bt_name)).'</a></td>
						<td class="date_notif">'.format_time_to_delta($mp->dateInterval).'</td>
						</tr>';
				}
			}
			else{
				echo "Pas de bugtracker";
			}
			?>		
			</table>
			
		</div>
		</td>
	</tr>
</tbody>
</table>

<br /><br /><br /><br /><br /><br />

<?php

echo '<strong>Astuce :</strong> <i>Vous êtes sur la page "Nouveautés", accessible via l\'icône tournante rouge située en haut de page.<br /><br />Cette page est très utile, car elle vous permet en un clin d\'oeil de <strong>découvrir toutes les nouveautés du site</strong> : une nouvelle news, un nouveau commentaire de news, un nouveau message sur le forum, un nouveau sujet sur le forum, un nouveau bug dans le BugTracker, un nouveau commentaire de bug dans le BugTracker, un nouveau Message Privé (MP) reçu.</i>';
if(!empty($printVote)){
		echo '<br /><br /><strong>Pour avoir accès à cette page "Nouveautés" il faut que vous votiez ;) Aidez nous à agrandir la population du serveur !</strong><br /><br />'.$printVote.'<b>Attention : </b>Après avoir voté, il faut <a href="./index.php?comp=notifications">rafraichir la page</a>.';
}
else{
if(
	empty($mps) &&
	empty($forums) &&
	empty($news) &&
	empty($bugtrackers)
){

	echo '<br /><br /><br /><center><strong>Désolé, revenez plus tard, aucune nouveauté pour le moment.</strong></center>';
	
}

//###
//NEWS
//###
if(!empty($news)){
	echo '<h1>News </h1><h4><a href="./index.php?comp=notifications&amp;task=mark&amp;select=news">[ Marquer toutes les news comme lues ]</a></h4>';
	echo "<table class='tableau'>";	
	foreach($news as $new){
	
		if(empty($new->uid)){
			//Jamais Lu
			echo '<tr class="tr"><td class="alignleft2"><a href="./index.php?comp=news_comment&amp;nid='.$new->nid.'&amp;start=0">
		'.stripslashes(htmlspecialchars($new->title)).'</a></td><td width="5%"><img src="./templates/'.$link_style.'/ico/new.gif" alt="New"/></td></tr>';
		}
		else{
			//Déjà Lu
			echo '<tr class="tr"><td class="alignleft2"><a href="./index.php?comp=news_comment&amp;nid='.$new->nid.'&amp;start=0">
		'.stripslashes(htmlspecialchars($new->title)).'</a>&nbsp;</td><td width="5%">	
		<a href="./index.php?comp=news_comment&amp;nid='.$new->nid.'&amp;goto='.$new->last_cid.'#cid'.$new->last_cid.'"><img src="./templates/'.$link_style.'/ico/arrow.gif" title="Aller au dernier commentaire non lu" alt="Aller au dernier message non lu"/></a></td></tr>';		
		}
		
	}
	echo '</table>';
}

//###
//MP
//###
if(!empty($mps)){
	echo '<h1>Messagerie Privée </h1><h4><a href="./index.php?comp=mp_inbox">[ Boîte de réception ]</a></h4>';
	echo "<table class='tableau'>";	
	foreach($mps as $mp){
		echo '<tr class="tr"><td class="alignleft2"><a href="./index.php?comp=mp_view&amp;mpid='.$mp->mpid.'&amp;who=to">'.stripslashes(htmlspecialchars($mp->subject)).'</a>
		de <a href="./index.php?comp=profil&amp;select='.$mp->from.'">'.$mp->sender.'</a> le '.date('d/m à H\hi',$mp->date_sent).'</td><td width="5%"><img src="./templates/'.$link_style.'/ico/new.gif" alt="New"/></td></tr>';
	}
	echo '</table>';
}

//###
//FORUM
//###
if(!empty($forums)){
	$current_board = '';
	
	echo '<h1>Forum</h1><h4><a href="./index.php?comp=notifications&amp;task=mark&amp;select=forum">[ Marquer tout le forum comme lu ]</a></h4>';
	echo "<table class='tableau'>";
	foreach($forums as $forum){
	
		if($current_cat==$forum->cat_name){
			echo '';
		}
		else{
			echo '<tr class="tr"><td class="alignleft3"><ul><li><strong>'.stripslashes(htmlspecialchars($forum->cat_name)).'</strong></li></ul></td></tr>';
			$current_cat=$forum->cat_name;
		}
	
		if(empty($forum->uid)){
			//Jamais Lu
			echo '<tr class="tr"><td class="alignleft2"><a href="./index.php?comp=forum_topic&amp;select='.$forum->tid.'&amp;start=0">
		'.stripslashes(htmlspecialchars($forum->subject)).'</a></td><td width="5%"><a href="./index.php?comp=forum_topic&amp;select='.$forum->tid.'&amp;start=0"></a></td></tr>';
		}
		else{
			//Déjà Lu
			echo '<tr class="tr"><td class="alignleft2"><a href="./index.php?comp=forum_topic&amp;select='.$forum->tid.'&amp;start=0">
		'.stripslashes(htmlspecialchars($forum->subject)).'</a>
		</td><td width="5%"><a href="index.php?comp=forum_topic&amp;select='.$forum->tid.'&amp;goto='.$forum->last_pid.'#pid'.$forum->last_pid.'"><img src="./templates/'.$link_style.'/ico/arrow.gif" title="Aller au dernier message non lu" alt="Aller au dernier message non lu"/></a></td></tr>';		
		}
	}
	echo '</table>';
}

//###
//BUGTRACKERs
//###
if(!empty($bugtrackers)){
	echo '<h1>BugTracker </h1><h4><a href="./index.php?comp=notifications&amp;task=mark&amp;select=bugs">[ Marquer tous les bugs comme lus ]</a></h4>';
	echo "<table class='tableau'>";	
	foreach($bugtrackers as $bugtracker){
	
	
		if(empty($bugtracker->uid)){
			//Jamais Lu
			echo '<tr class="tr"><td class="alignleft2"><a href="./index.php?comp=bugtracker_view&amp;select='.$bugtracker->btid.'">
		'.stripslashes(htmlspecialchars($bugtracker->bt_name)).'</a></td><td width="5%"><img src="./templates/'.$link_style.'/ico/new.gif" alt="New"/></td></tr>';
		}
		else{
			//Déjà Lu
			echo '<tr class="tr"><td class="alignleft2"><a href="./index.php?comp=bugtracker_view&amp;select='.$bugtracker->btid.'">
		'.stripslashes(htmlspecialchars($bugtracker->bt_name)).'</a>&nbsp;</td><td width="5%">
		<a href="./index.php?comp=bugtracker_view&amp;select='.$bugtracker->btid.'#btcid'.$bugtracker->last_btcid.'"><img src="./templates/'.$link_style.'/ico/arrow.gif" title="Aller au dernier commentaire non lu" alt="Aller au dernier message non lu"/></a></td></tr>';		
		}
	}
	echo '</table>';
}
}

require_once('./templates/'.$link_style.'bottom.php');
?>
