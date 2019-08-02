<div id="Shoutbox">
<form name="shoutbox" action="">
	<div id="ShoutContent"></div>	
	<input type="text" name="ShoutText"  id="ShoutText" value="" maxlength="255" onmouseover="this.focus();" />	
	<input type="submit" id="ShoutSend" value="Ok" onclick="Send();return false;" />
<script type="text/javascript">
function bbcode(bbdebut, bbfin)
{
	var input = window.document.shoutbox.ShoutText;
	input.focus();
	/* pour IE (toujous un cas appar lui ;) )*/
	if(typeof document.selection != 'undefined')
	{
		var range = document.selection.createRange();
		var insText = range.text;
		range.text = bbdebut + insText + bbfin;
		range = document.selection.createRange();
		if (insText.length == 0)
		{
		range.move('character', -bbfin.length);
		}
		else
		{
		range.moveStart('character', bbdebut.length + insText.length + bbfin.length);
		}
		range.select();
	}
	/* pour les navigateurs plus récents que IE comme Firefox... */
	else if(typeof input.selectionStart != 'undefined')
	{
		var start = input.selectionStart;
		var end = input.selectionEnd;
		var insText = input.value.substring(start, end);
		input.value = input.value.substr(0, start) + bbdebut + insText + bbfin + input.value.substr(end);
		var pos;
		if (insText.length == 0)
		{
		pos = start + bbdebut.length;
		}
		else
		{
		pos = start + bbdebut.length + insText.length + bbfin.length;
		}
		input.selectionStart = pos;
		input.selectionEnd = pos;
	}
	/* pour les autres navigateurs comme Netscape... */
	else
	{
		var pos;
		var re = new RegExp('^[0-9]{0,3}$');
		while(!re.test(pos))
		{
		pos = prompt("insertion (0.." + input.value.length + "):", "0");
		}
		if(pos > input.value.length)
		{
		pos = input.value.length;
		}
		var insText = prompt("Veuillez taper le texte");
		input.value = input.value.substr(0, pos) + bbdebut + insText + bbfin + input.value.substr(pos);
	}
}
function smilies(img)
{
 window.document.shoutbox.ShoutText.value += '' + img + '';
}

</script> 
<span class="tooltipshout"><img style="padding-top:2px; padding-left:4px;" src="./img/smileysShout/icon_smile.gif" alt="smile" /><em>
<!-- Standard+ -->
<img src="./img/smileysShout/icon_sad.gif" alt="sad" onclick="javascript:smilies(' :( ');return(false)" />
<img src="./img/smileysShout/icon_razz.gif" alt="razz" onclick="javascript:smilies(' :p ');return(false)" />
<img src="./img/smileysShout/icon_smile.gif" alt="smile" onclick="javascript:smilies(' :) ');return(false)" />
<img src="./img/smileysShout/icon_biggrin.gif" alt="biggrin" onclick="javascript:smilies(' :D ');return(false)" />
<img src="./img/smileysShout/icon_evil.gif" alt="evil" onclick="javascript:smilies(' :evil: ');return(false)" />
<img src="./img/smileysShout/icon_twisted.gif" alt="twisted" onclick="javascript:smilies(' :twisted: ');return(false)" />
<img src="./img/smileysShout/icon_cry.gif" alt="cry" onclick="javascript:smilies(' :cry: ');return(false)" />
<img src="./img/smileysShout/icon_confused.gif" alt="confused" onclick="javascript:smilies(' :? ');return(false)" />
<img src="./img/smileysShout/icon_neutral.gif" alt="neutral" onclick="javascript:smilies(' :| ');return(false)" />
<img src="./img/smileysShout/icon_cool.gif" alt="cool" onclick="javascript:smilies(' 8) ');return(false)" />
<img src="./img/smileysShout/icon_mrgreen.gif" alt="mrgreen" onclick="javascript:smilies(' :mrgreen: ');return(false)" />
<img src="./img/smileysShout/icon_rolleyes.gif" alt="rolleyes" onclick="javascript:smilies(' :roll: ');return(false)" />
<img src="./img/smileysShout/icon_wink.gif" alt="wink" onclick="javascript:smilies(' ;) ');return(false)" />
<img src="./img/smileysShout/icon_eek.gif" alt="eek" onclick="javascript:smilies(' :shock: ');return(false)" />
<img src="./img/smileysShout/icon_surprised.gif" alt="surprised" onclick="javascript:smilies(' :O ');return(false)" />
<img src="./img/smileysShout/icon_mad.gif" alt="mad" onclick="javascript:smilies(' :x ');return(false)" />
<img src="./img/smileysShout/icon_lol.gif" alt="lol" onclick="javascript:smilies(' :lol: ');return(false)" />
<img src="./img/smileysShout/icon_redface.gif" alt="redface" onclick="javascript:smilies(' :oops: ');return(false)" />
</em></span>
</form>


</div>