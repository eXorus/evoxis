<?php
class GC {
	
	function rungc($cache_path,$gc_max) {
		/*
		Ici on a une routine de ramasse miette
		qui nettoie le contenu du cache des fichiers hors d'age
		et evite d'avoir un cache trop volumineux
		tout les fichiers dont l'age est supérieur a gc_max
		sont supprimés
		*/
		$handle=opendir($cache_path);
		while ($file = readdir($handle)) {
			$path=dirname($cache_path).'/'.$file;
			if ( is_file($path) && filemtime($path)<time()-$gc_max && $file!='.htaccess' ) {
				GC::delfile($path);
			}
		}
		closedir($handle);
	}
	
	function delfile($file) {
		/*
		là une routine qui permet l'effacement du fichier file
		sous unix puis windows
		*/
		@unlink($file);
		clearstatcache();
		if (@file_exists($file)) {
			$filesys = str_replace("/", "\\", $file);
			@system("del $filesys");
			clearstatcache();
			if (@file_exists($file)) {
				@chmod ($file, 0775);
				@unlink($file);
				@system("del $filesys");
			}
		}
		clearstatcache();
		if (@file_exists($file)) {return FALSE; }
		else { return TRUE; }
	}
}
?>