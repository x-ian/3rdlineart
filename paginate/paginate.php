<?php
 
class Paginator {
 
private $_conn;
private $_limit;
private $_page;
private $_query;
private $_total;

public function __construct( $conn, $query ) {
    
    $this->_conn = $conn;
    $this->_query = $query;
 
    $rs= $this->_conn->query( $this->_query );
    $this->_total = $rs->num_rows;
    echo "<br>num_rows: ".$this->_total;    
}

public function getData( $limit = 10, $page = 1 ) {

    echo "<br>getData: limit $limit, page $page";
    $this->_limit   = $limit;
    $this->_page    = $page;
 
    if ( $this->_limit == 'all' ) {
        $query      = $this->_query;
    } else {
        $query      = $this->_query . " LIMIT " . ( ( $this->_page - 1 ) * $this->_limit ) . ", $this->_limit";
    }
    echo "<br>query: $query";
    $rs             = $this->_conn->query( $query );
 
    while ( $row = $rs->fetch_assoc() ) {
        $results[]  = $row;
    }
 
    $result         = new stdClass();
    $result->page   = $this->_page;
    $result->limit  = $this->_limit;
    $result->total  = $this->_total;
    $result->data   = $results;
 
    return $result;
}

public function createLinks( $links, $list_class ) {
    if ( $this->_limit == 'all' ) {
        return '';
    }

    $page = $this->_page;
    $last       = ceil( $this->_total / $this->_limit ); 
    $start      = ( ( $this->_page - $links ) > 0 ) ? $this->_page - $links : 1;
    $end        = ( ( $this->_page + $links ) < $last ) ? $this->_page + $links : $last;
    echo "<br>start: $start, (page $page) end: $end";
    $html       = '<ul class="' . $list_class . '">';
    $class      = ( $this->_page == 1 ) ? "disabled" : "";
    
    $href = '?limit=' . $this->_limit . '&page=' . ( $this->_page - 1 );

    $html       .= '<li><a href=".$href.">&laquo;</a></li>';

    if ( $start > 1 ) {
        $html   .= '<li><a href="?limit=' . $this->_limit . '&page=1">1</a></li>';
        $html   .= '<li"><a>&hellip;</a></li>';                
    }
 
    for ( $i = $start ; $i <= $end; $i++ ) {
        $class  = ( $this->_page == $i ) ? "active" : "";
        $html   .= '<li><a href="?limit=' . $this->_limit . '&page=' . $i . '">' . $i . '</a></li>';
    }
 
    if ( $end < $last ) {
        $html   .= '<li><a>&hellip;</a></li>';
        $html   .= '<li><a href="?limit=' . $this->_limit . '&page=' . $last . '">' . $last . '</a></li>';
    }
 
    $class      = ( $this->_page == $last ) ? "disabled" : "";
    $html       .= '<li><a href="?limit=' . $this->_limit . '&page=' . ( $this->_page + 1 ) . '">&raquo;</a></li>';
    $html       .= '</ul>';
 
    return $html;
}

}

?>
