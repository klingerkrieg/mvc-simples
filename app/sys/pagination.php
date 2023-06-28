<?php


function htmlPagination($paginated){
    if ($paginated['pages'] <= 1) {
        return "";
    }

    $qrstr = $_SERVER['QUERY_STRING'];
    $qrstr = explode("&", $qrstr);
    $arrQrStr = [];
    foreach($qrstr as $str){
        if (!str_starts_with($str, "page=")){
            array_push($arrQrStr, $str);
        }
    }
    $qrstr = implode("&",$arrQrStr);
        
    
    $html = "<nav><ul class='pagination'>";

    $pagesLimit = 7;
    #define qual é a primeira página que irá aparecer
    $startPageFrom = $paginated['actualPage'] - 3;
    if ($startPageFrom < 1){
        $startPageFrom = 1;
    }
    
    #se a primeira página não for a 1, haverá um link para ir para a primeira página
    if ($startPageFrom != 1){
        $html .= "<li class='page-item'><a class='page-link' href='?$qrstr&page=1'>
                    <span aria-hidden='true'>&laquo;</span></a></li>";
    }

    if ($paginated['actualPage'] > 1){
        $html .= "<li class='page-item'><a class='page-link' href='?$qrstr&page=".($paginated['actualPage']-1)."'>
                    <span aria-hidden='true'>&lt;</span></a></li>";
    }

    for($page = $startPageFrom, $c=0; $page <= $paginated['pages'] && $c < $pagesLimit; $page++, $c++){
        $active = "";
        if ($paginated['actualPage'] == $page){
            $active = "active";
        }
    
        $html .= "<li class='page-item $active'><a class='page-link' href='?$qrstr&page=$page'>$page</a></li>";
    }

    if ($paginated['actualPage'] < $paginated['pages']){
        $html .= "<li class='page-item'><a class='page-link' href='?$qrstr&page=".($paginated['actualPage']+1)."'>
                        <span aria-hidden='true'>&gt;</span></a></li>";
    }

    #se a última página que apareceu não for realmente a última
    #haverá um link para ir para a última
    if ($page-1 != $paginated['pages']){
        $html .= "<li class='page-item'><a class='page-link' href='?$qrstr&page={$paginated['pages']}'>
                        <span aria-hidden='true'>&raquo;</span></a></li>";
    }

    $html .= "</ul></nav>";
    return $html;
}

?>