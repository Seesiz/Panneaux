<h3 class="position-relative p-3"><b class="color-primary">Maintenant</b>, choisissez les colonnes approprier aux calculs:</h3>
<div class="container">
    <div class="choice col-3">
        <h4 class="col-12">Les colonnes à choisir:</h4>
        <label for="date">Colonne date:</label>
        <select name="date-column" id="date" class="choix form-control" style="background-color: rgb(83, 83, 83)"></select>
        <label for="jirama">Colonne JIRAMA:</label>
        <select name="jirama-column" id="jirama" class="choix form-control" style="background-color: rgb(252, 252, 78)"></select>
        <label for="panneaux">Colonne Panneaux:</label>
        <select name="panneaux-column" id="panneaux" class="choix form-control" style="background-color: #5661C3"></select>
        <br>
        <button class="btn btn-primary col-12">Valider</button>
    </div>
    <div class="data col-8">
        <h4 class="d-flex"><b class="col-5">Les données recueillies: </b></h4>
        <div class="sheet">
            <table class="table table-striped">
                <?php 
                    $row = $table->getHighestRow();
                    $col = PHPExcel_Cell::columnIndexFromString($table->getHighestDataColumn());
                    for($i = 1; $i<=$row; $i++){
                        echo "<tr>";
                        for($y = 0; $y<$col; $y++){
                            if($i == 1){
                                echo "<th class='col_$y'>";
                            } else {
                                echo "<td class='colu_$y'>";
                            }
                                echo $table->getCell(PHPExcel_Cell::stringFromColumnIndex($y).$i)->getValue();
                            if($i == 1){
                                echo "</th>";
                            } else {
                                echo "</td>";
                            }
                        }
                        echo "</tr>";
                    }
                ?>
            </table>
        </div>
    </div>
</div>

<script>
    $(document).ready(function(){
        let i = 0;
        let prec = '';
        let prec1 = '';
        let prec2 = '';
        document.querySelectorAll("th").forEach(element=>{
            const option = document.createElement("option");
            option.value = i;
            option.innerHTML = element.innerText;
            $(".choix").append(option);
            i++;
        });
        $("#date").on("change", function(){
            $('.col_'+$("#date").val()).css("background", "rgb(83, 83, 83)");
            $('.col_'+$("#date").val()).css("color", "white");
            $('.colu_'+$("#date").val()).css("background", "rgb(154, 154, 154)");
            $('.col_'+prec).css("background", "none");
            $('.colu_'+prec).css("background", "none");
            $('.col_'+prec).css("color", "black");
            prec = $("#date").val();
        });
        $("#jirama").on("change", function(){
            $('.col_'+$("#jirama").val()).css("background", "rgb(252, 252, 78)");
            $('.colu_'+$("#jirama").val()).css("background", "rgb(254, 254, 137)");
            $('.col_'+prec1).css("background", "none");
            $('.colu_'+prec1).css("background", "none");
            prec1 = $("#jirama").val();
        });
        $("#panneaux").on("change", function(){
            $('.col_'+$("#panneaux").val()).css("background", "#5661C3");
            $('.col_'+$("#panneaux").val()).css("color", "white");
            $('.colu_'+$("#panneaux").val()).css("background", "#5661c36e");
            $('.col_'+prec2).css("background", "none");
            $('.colu_'+prec2).css("background", "none");
            $('.col_'+prec2).css("color", "black");
            prec2 = $("#panneaux").val();
        });
    });
</script>