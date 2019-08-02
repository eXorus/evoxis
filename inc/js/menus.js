function affiche(balise)
{
if (document.getElementById && document.getElementById(balise) != null)
{
document.getElementById(balise).style.visibility='visible';
document.getElementById(balise).style.display='block';
}
}

function cache(balise)
{
if (document.getElementById && document.getElementById(balise) != null)
{
document.getElementById(balise).style.visibility='hidden';
document.getElementById(balise).style.display='none';
}
}