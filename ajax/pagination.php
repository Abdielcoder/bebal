<?php
function paginate($reload, $page, $total_pages, $adjacents) {
	$prevlabel = "Anterior";
	$nextlabel = "Siguiente";
	$out = '<ul class="pagination pagination-custom">';
	
	// previous label
	if ($page == 1) {
		$out.= '<li class="page-item disabled"><a class="page-link">'.$prevlabel.'</a></li>';
	} else if ($page == 2) {
		$out.= '<li class="page-item"><a class="page-link" href="'.$reload.'">'.$prevlabel.'</a></li>';
	} else {
		$out.= '<li class="page-item"><a class="page-link" href="'.$reload.'&page='.($page-1).'">'.$prevlabel.'</a></li>';
	}
	
	// first label
	if ($page > ($adjacents+1)) {
		$out.= '<li class="page-item"><a class="page-link" href="'.$reload.'">1</a></li>';
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
			$out.= '<li class="page-item"><a class="page-link" href="'.$reload.'">'.$i.'</a></li>';
		} else {
			$out.= '<li class="page-item"><a class="page-link" href="'.$reload.'&page='.$i.'">'.$i.'</a></li>';
		}
	}

	// interval
	if ($page < ($total_pages-$adjacents-1)) {
		$out.= '<li class="page-item disabled"><a class="page-link">...</a></li>';
	}

	// last
	if ($page < ($total_pages-$adjacents)) {
		$out.= '<li class="page-item"><a class="page-link" href="'.$reload.'&page='.$total_pages.'">'.$total_pages.'</a></li>';
	}

	// next
	if ($page < $total_pages) {
		$out.= '<li class="page-item"><a class="page-link" href="'.$reload.'&page='.($page+1).'">'.$nextlabel.'</a></li>';
	} else {
		$out.= '<li class="page-item disabled"><a class="page-link">'.$nextlabel.'</a></li>';
	}
	
	$out.= '</ul>';
	return $out;
}
?>
