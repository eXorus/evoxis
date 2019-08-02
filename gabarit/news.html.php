<?php
defined( '_VALID_CORE_NEWS' ) or die( 'Restricted access' );
require_once('./templates/'.$link_style.'top.php');

if(!empty($topics)){
	foreach($topics as $topic){
		echo '
			<div class="topic_top"></div>
			<div class="topic_middle">
				<h2>
					<a href="./index.php?comp=forum_topic&amp;select='.$topic->tid.'">'.stripslashes(htmlspecialchars($topic->subject)).'</a>
				</h2>
			<h4>par '.$topic->s_name.' <br />le '.$topic->s_time.'</h4>
			<div class="newscontenu">';
			
		echo stripslashes(nl2br(parse_bbcode_smiley(htmlspecialchars($topic->body)))).'<br />';
		
		if(!empty($topic->post_last_edit_time)){
			echo '<h9>Modifié : '.$topic->post_last_edit_time.' par '.$topic->post_last_edit_uid.'</h9>';
		}
		echo '</div><div align="right" style="margin-right:35px;"><a href="index.php?comp=forum_topic&amp;select='.$topic->tid.'"><img src="./templates/'.$link_style.'/ico/suite.gif" title="Suite et commentaire(s)" alt="Suite et commentaire(s)"/></a></div></div><div class="topic_bottom"></div>';
	}
	echo '<p style="margin-top:3em; text-align:center; margin-right:20px;"><a href="index.php?comp=forum_board&amp;select=22">[ Archives des news >>> ]</a></p>';
}
else{
	echo "Aucune news pour le moment";
}

require_once('./templates/'.$link_style.'bottom.php');
?>
