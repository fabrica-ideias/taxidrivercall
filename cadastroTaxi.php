<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Configuração de Taxi</title>
  <!-- Compiled and minified CSS -->
  <link rel="stylesheet" href="materialize/css/materialize.min.css">
  <!-- Compiled and minified JavaScript -->
  <link rel="stylesheet" href="css/style.css" />
  <link rel="stylesheet" href="css/infraero.css" />
  <link href="css/icon.css" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="css/font_roboto.css"/>
  <script type="text/javascript" src="js/jquery-3.2.1.min.js"></script>
  <script src="materialize/js/materialize.min.js"></script>
</head>
<body>
	<div class="container">
		<div class="row">
      <div class="col s4"></div>
      <div class="col s4" style="background-color: #fff;padding: 10px;">
        <div class="input-field col s12">
          <select id="beacon">
            <option value="" disabled selected>SELECIONE O BEACON</option>
            <?php 
            require_once("php/conexao.php");
            $result = mysqli_query($con,"SELECT * FROM du31xu75psg7waby.Beacon ORDER BY nome");
            while($row = mysqli_fetch_array($result)){
              echo "<option value='".$row['mac']."''>".strtoupper($row['nome'])."</option>";
            }
            ?>
          </select>
          <label>Mac do Beacons</label>
        </div>
        <div class="input-field col s12">
          <select id="taxi">
            <option value="" disabled selected>SELECIONE O TAXI</option>
            <?php 
            $taxis = json_decode(file_get_contents('php/arquivo.json'));
            foreach ($taxis->posto1 as $taxi) {
              echo "<option value='".$taxi->numero."''>".$taxi->numero."</option>";
            }
            foreach ($taxis->posto2 as $taxi) {
              echo "<option value='".$taxi->numero."''>".$taxi->numero."</option>";
            }
            foreach ($taxis->posto3 as $taxi) {
              echo "<option value='".$taxi->numero."''>".$taxi->numero."</option>";
            }
            ?>
          </select>
          <label>Selecione o Taxi</label>
        </div>
        <button class="btn" id="btnSalva">Salvar</button>
      </div>
      <div class="col s4"></div>
    </div>
  </div>	
  <script type="text/javascript">
    $(document).ready(function() {
      $('select').material_select();
      document.getElementById("btnSalva").addEventListener("click",function(){
        var beacon = $("#beacon").val();
        var taxi = $("#taxi").val();
        request = $.ajax({
          url: "php/salvaTaxiBeacon.php",
          type: "post",
          data: {"taxi":taxi, "beacon" : beacon}
        });
        request.done(function (response, textStatus, jqXHR){
          alert("SALVO COM SUCESSO");

        });
        request.fail(function (jqXHR, textStatus, errorThrown){
          console.error(
            "The following error occurred: "+
            textStatus, errorThrown
            );
        });
      });
    });
  </script>	
</body>
</html>