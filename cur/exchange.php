<!DOCTYPE html>
<html lang="en">
<head>
  <title>
    Currenct Exchange Form
  </title>
  <meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js">
    </script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    

<body style="background-color: powderblue;">

 <h1 style="color:green">
  <p style="text-align: left;">
    <b><i> Currency Exchange Form</i> </b>
  </p>
 </h1>
 <br>
 
  <form class="form-group" action="/action_page.php">
    <table>
      <h3>
           <label class="control-label col-sm-2" for="amount" style="color: blue">Original Amount:</label> </h3>
         
           <div class="col-sm-2">
              <input type="number" class="form-control" id="amount" placeholder="Enter Amount" name="amount" autofocus>
           </div>
         
      <br><br>

        <h3>
           <label class="control-label col-sm-2" for="fromcur" style="color: blue">From Currency:</label>
        </h3>
         <div class="col-sm-2">          
            <select class="form-control" id="fromcur"  name="fromcur" required>
                <option>USD</option>
                <option>MMK</option>
                <option>SGD</option>
                <option>EUR</option>
            </select>

         </div>
       
    <br><br>
   
       <h3>
         <label class="control-label col-sm-2" for="tocur" style="color: blue">To Currency:</label>
       </h3>

      <div class="col-sm-2">          
        <select class="form-control" id="tocur"  name="tocur" required>
           <option>USD</option>
           <option>MMK</option>
           <option>SGD</option>
           <option>EUR</option>
        </select>

      </div>
    
  <br><br>

    <tr>
        <div class="container-fluid">
            <div class="col-sm-4 text-center"><br><br>
       <button class="btn btn-primary btn-lg" title="Buy">Buy</button>
       <button class="btn btn-primary btn-lg" title="Sell">Sell</button>
       <button class="btn btn-warning btn-lg" title="Exit">Exit</button>
      </div>
    </div>
    </tr> 
  </table>
 </form>
</body>
</html>


