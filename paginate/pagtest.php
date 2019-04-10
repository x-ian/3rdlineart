<!DOCTYPE html>
    <head>
        <title>PHP Pagination</title>
        <link rel="stylesheet" href="../css/bootstrap.min.css">
    </head>

<?php
    require_once 'paginate.php';

    $conn       = new mysqli( 'localhost', 'root', 'password', 'world' );
     
    $limit      = isset($_GET['limit']) ? $_GET['limit'] : 10;
    $page       = isset( $_GET['page']) ? $_GET['page'] : 1;
    $links      = isset( $_GET['links']) ? $_GET['links'] : 7;
    $query      = "SELECT city.Name, city.countryCode, country.Code, country.Name AS country, country.Continent, country.Region FROM city, country WHERE city.countryCode = country.Code ORDER BY country.Name, city.Name";

echo "<br>limit: $limit, page: $page";
    $Paginator  = new Paginator( $conn, $query );
 
    $results    = $Paginator->getData( $limit, $page );
?>
    <body>
        <div class="container">
                <div class="col-md-10 col-md-offset-1">
                <h1>PHP Pagination</h1>
                <table class="table table-striped table-condensed table-bordered table-rounded">
                        <thead>
                                <tr>
                                <th>City</th>
                                <th width="20%">Country</th>
                                <th width="20%">Continent</th>
                                <th width="25%">Region</th>
                        </tr>
                        </thead>
                        <tbody>

<?php echo"<br> # of rows: ".sizeof($results->data);
        for( $i = 0; $i < count( $results->data ); $i++ ) : ?>
              	      	<tr>
				<td><?php echo $results->data[$i]['Name']; ?></td>
                		<td><?php echo $results->data[$i]['country']; ?></td>
                		<td><?php echo $results->data[$i]['Continent']; ?></td>
                		<td><?php echo $results->data[$i]['Region']; ?></td>
        		</tr>
<?php endfor; ?>

			</tbody>
                </table>
                </div>
        </div>
        </body>
<?php echo $Paginator->createLinks( $links, 'pagination pagination-sm' ); ?>

</html>
