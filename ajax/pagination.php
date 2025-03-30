<?php
function paginate($reload, $page, $total_pages, $adjacents) {
	$prevlabel = "Anterior";
	$nextlabel = "Siguiente";
	$out = '<ul class="pagination pagination-custom">';
	
	// Asegurar que $reload está correctamente formateado para agregar parámetros
	// Si $reload ya contiene un "?" (significa que ya tiene parámetros), usaremos "&" para agregar page
	// Si no, empezaremos con "?" para el primer parámetro
	$connector = (strpos($reload, '?') !== false) ? '&' : '?';
	
	// previous label
	if ($page == 1) {
		$out.= '<li class="page-item disabled"><a class="page-link">'.$prevlabel.'</a></li>';
	} else if ($page == 2) {
		$out.= '<li class="page-item"><a class="page-link" href="'.$reload.$connector.'page=1">'.$prevlabel.'</a></li>';
	} else {
		$out.= '<li class="page-item"><a class="page-link" href="'.$reload.$connector.'page='.($page-1).'">'.$prevlabel.'</a></li>';
	}
	
	// first label
	if ($page > ($adjacents+1)) {
		$out.= '<li class="page-item"><a class="page-link" href="'.$reload.$connector.'page=1">1</a></li>';
	}
	// interval
	if ($page > ($adjacents+2)) {
		$out.= '<li class="page-item disabled"><a class="page-link">...</a></li>';
	}

	// pages
	$pmin = ($page > $adjacents) ? ($page-$adjacents) : 1;
	$pmax = ($page < ($total_pages-$adjacents)) ? ($page+$adjacents) : $total_pages;
	for ($i=$pmin; $i<=$pmax; $i++) {
		if ($i == $page) {
			$out.= '<li class="page-item active"><a class="page-link">'.$i.'</a></li>';
		} else if ($i == 1) {
			$out.= '<li class="page-item"><a class="page-link" href="'.$reload.$connector.'page=1">'.$i.'</a></li>';
		} else {
			$out.= '<li class="page-item"><a class="page-link" href="'.$reload.$connector.'page='.$i.'">'.$i.'</a></li>';
		}
	}

	// interval
	if ($page < ($total_pages-$adjacents-1)) {
		$out.= '<li class="page-item disabled"><a class="page-link">...</a></li>';
	}

	// last
	if ($page < ($total_pages-$adjacents)) {
		$out.= '<li class="page-item"><a class="page-link" href="'.$reload.$connector.'page='.$total_pages.'">'.$total_pages.'</a></li>';
	}

	// next
	if ($page < $total_pages) {
		$out.= '<li class="page-item"><a class="page-link" href="'.$reload.$connector.'page='.($page+1).'">'.$nextlabel.'</a></li>';
	} else {
		$out.= '<li class="page-item disabled"><a class="page-link">'.$nextlabel.'</a></li>';
	}
	
	$out.= '</ul>';
	return $out;
}
?>
