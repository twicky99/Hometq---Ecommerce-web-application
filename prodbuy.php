<?php
include("db.php");
//create a variable called $pagename which contains the actual name of the page
$pagename="A smart buy for a smart home";

//call in the style sheet called ystylesheet.css to format the page as defined in the style sheet
echo "<link rel=stylesheet type=text/css href=mystylesheet.css>";

//display window title
echo "<title>".$pagename."</title>";
//include head layout 
include ("headfile.html");

echo "<p></p>";
//display name of the web page
echo "<h4>".$pagename."</h4>";

//retrieve the product id passed from previous page using the GET method and the $_GET superglobal variable
//applied to the query string u_prod_id
//store the value in a local variable called $prodid
$prodid=$_GET['u_prod_id'];
//display the value of the product id, for debugging purposes
echo "<p>Selected product Id: ".$prodid;

//create a $SQL variable and populate it with a SQL statement that retrieves product details
$SQL="select prodId, prodName,prodDescripLong,prodPrice, prodPicNameLarge ,prodQuantity from Product WHERE prodId=$prodid";
//run SQL query for connected DB or exit and display error message
$exeSQL=mysqli_query($conn, $SQL) or die (mysqli_error());
echo "<table style='border: 0px'>";
//create an array of records (2 dimensional variable) called $arrayp.
//populate it with the records retrieved by the SQL query previously executed.
//Iterate through the array i.e while the end of the array has not been reached, run through it
while ($arrayp=mysqli_fetch_array($exeSQL))
{
    echo "<tr>";
    echo "<td style='border: 0px'>";

    //make the image into an anchor to prodbuy.php and pass the product id by URL (the id from the array)
    echo "<a href=prodbuy.php?u_prod_id=".$arrayp['prodId'].">";
    //display the small image whose name is contained in the array
    echo "<img src=images/".$arrayp['prodPicNameLarge']." height=200 width=200>";
    //close the anchor
    echo"</a>";
    
    echo "</td>";
    echo "<td style='border: 0px'>";
    echo "<p><h5>".$arrayp['prodName']."</h5>"; //display product name as contained in the array
    echo "<p>".$arrayp['prodDescripLong']."</p>"; //display product short description as contained in the array
    echo "<p><b>&pound;".$arrayp['prodPrice']."</b></p>"; //display product price as contained in the array
    echo "<p> Number of items left in stock: ".$arrayp['prodQuantity']."</p>"; //display no.of items left in the stock
    
    echo "<p>Number to be purchased: ";
    //create form made of one text field and one button for user to enter quantity
    //the value entered in the form will be posted to the basket.php to be processed
    echo "<form action=basket.php method=post>";
    //echo "<input type=text name=p_quantity size=5 maxlength=3>";
    echo "<select name='p_quantity'>";
    for($counter=1;$counter<=$arrayp['prodQuantity'];$counter++){
        echo "<option value='$counter'> $counter </option>";
    }
        
    echo "</select>";

    echo "<input type=submit value='ADD TO BASKET'>";

    //pass the product id to the next page basket.php as a hidden value
    echo "<input type=hidden name=h_prodid value=".$prodid.">";
    echo "</form>";
    
    echo "</td>";
    echo "</tr>";
}
echo "</table>";

//include foot layout
include("footfile.html");
?>
