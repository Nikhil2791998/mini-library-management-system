<html>
<head><style>
.btn-green,input{
    text-decoration: none;
    font-size: 1.5em;
    margin: 0px;
    cursor: pointer;
    border: 1px solid white;
    color: white;
    background-color: rgb(41, 189, 15);
    padding: 5px;
    transition: background 1s;
}
.btn-green:hover{background-color: white; color:rgb(41, 189, 15);}
legend{font-size:3em;}
</style>
<title>Library Management</title></head>
<body style="margin:0px;">
<nav style="background-color: rgb(41, 189, 15);display: flow-root;padding: 5px;margin: 0px;">
    <div style="float:left;">
        <form style="disply:inline-block;margin:0px;" action="index.php" method="get">
            <button class="btn-green">Home</button>
        </form>
    </div>
    <div style="float:right;padding:5px;">
        <a href="login.php" class="btn-green">Login</a>
    </div>
</nav>
<fieldset>
    <legend>Book Management</legend>
    <form method="post">
    <table>
    <?php 
        if($_SERVER["REQUEST_METHOD"]=="GET")
        echo '<tr>
        <td>Select Your Choice</td>
        <td><select class="btn-green" name="choice" id="choice">
            <option value="search">Search Available Book</option>
            <option value="issue">Issue a Book</option>
            <option value="return">Return a Book</option>
        </select></td>
        </tr>';
        elseif($_SERVER["REQUEST_METHOD"]=="POST")
        {
            
            #$db=new mysqli("localhost","root","","libms");
            if(isset($_POST["choice"]))
            switch($_POST["choice"])
            {
                case "search":
                echo '<tr><td>Enter Book Title</td>
                    <td><input type="text" name="book_title"></td>
                    </tr>';     
                    break;
                case "issue":
                echo '<tr><td>Enter Book ID</td>
                    <td><input type="number" name="book_id"></td>
                    </tr><tr>
                    <td>Enter Issuer ID</td>
                    <td><input type="number" name="issuer_id"></td>
                    </tr>
                    ';
                    break;
                case "return":
                echo '<tr><td>Enter Book ID</td>
                    <td><input type="number" name="rbook_id"></td>
                    </tr>';
                break;
                default:die("Warning Wrong Place Hacking Detected....");break;
            }
            elseif(isset($_POST["book_title"]))
            {
                $res=$db->query("Select * from books where book_title like '%".$_POST["book_title"]."%' and issuer_id=''");
                echo "<table>";
                while ($row = mysql_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>".$row["book_title"]."</td>";
                    echo "<td>".$row["book_id"]."</td>";
                    echo "<td>".$row["book_cupboard_number"]."</td>";
                    echo "<td>".$row["book_author"]."</td>";
                    echo "</tr>";
                }
                echo "</table>";
            }
            elseif(isset($_POST["book_id"]))
            {
                if(mysqli_num_rows($db->query("select * from books where book_id='".$_POST["book_id"]."' and issuer_id=''")) != 0)
                {
                    $res=$db->query("update books set issue_date=today issuer_id='".$_POST["issuer_id"]."' where book_id='".$_POST["book_id"]."'");
                    if($res===TRUE)
                        echo "Issue Successfull";
                    else
                        echo "Error Issuing The Book";
                }
                else{
                    echo "No Books Found";
                }
            }
            elseif(isset($_POST["rbook_id"]))
            {
                $res=$db->query("update books set issuer_id='' where book_id='".$_POST["rbook_id"]."'");
                if($res===TRUE)
                    echo "Book returned Successfully";
                else
                    echo "Error Returning Book check if book id is proprly written";
            }
            else echo("Unkown Error");
        }
        else echo "Warning Wrong Place Hacking Detected....";
    ?>
    </table>
    <button class="btn-green">Submit</button>
    </form>
</fieldset>
</body>
</html>
