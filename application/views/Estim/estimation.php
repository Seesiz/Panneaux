<div class="position-absolute error col-12 d-flex justify-content-evenly m-4" style="z-index: 10;">
    <div class="alert er alert-primary col-5 text-center" style="display: none" role="alert">
        Veuillez choisir des colonnes distinctes
    </div>
</div>

<h3 class="position-absolute p-3"><b class="color-primary">Maintenant</b>, choisissez les colonnes approprier aux calculs:</h3>
<div class="content">
    <form action="<?php echo site_url("Estimation") ?>" method="post" class="position-relative choice col-3">
        <h4 class="col-12">Les colonnes à choisir:</h4>
        <label for="date">Colonne date:</label>
        <select name="date-column" id="date" class="choix form-control" style="background-color: #AD956B"></select><br>
        <label for="jirama">Colonne JIRAMA:</label>
        <select name="jirama-column" id="jirama" class="choix form-control" style="background-color: #E1A624"></select><br>
        <label for="panneaux">Colonne Panneaux:</label>
        <select name="panneaux-column" id="panneaux" class="choix form-control" style="background-color: #317AC1"></select>
        <br>
        <button type="button" class="btn btn-success col-12" data-toggle="modal" data-target="#exampleModalCenter">
            Valider
        </button>

        <!-- Modal -->
        <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Validation</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Vous êtes sûr de votre choix?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Non</button>
                <button name="valider" class="btn btn-secondary">Oui</button>
            </div>
            </div>
        </div>
        </div>
    </form>


    <div class="data col-8 bg-white">
        <h4 class="d-flex"><b class="col-5">Les données recueillies: </b></h4>
        <div class="sheet">
            <table class="table t table-striped">
                <?php 
                    $data = $table->toArray();
                    $i = 1;
                    foreach($data as $row){
                        echo "<tr>";
                        $y = 0;
                        foreach($row as $value){
                            if($i == 1){
                                echo "<th class='col_$y'>";
                            } else {
                                echo "<td class='colu_$y'>";
                            }
                                echo $value;
                            if($i == 1){
                                echo "</th>";
                            } else {
                                echo "</td>";
                            }
                            $y++;
                        }
                        echo "</tr>";
                        $i++;
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

        /*
            Code design, à ne pas toucher
        */

        $("#date").on("change", function(){
            $('.col_'+$("#date").val()).css("background", "#AD956B");
            $('.col_'+$("#date").val()).css("color", "white");
            $('.colu_'+$("#date").val()).css("background", "#cab692");
            $('.col_'+prec).css("background", "none");
            $('.colu_'+prec).css("background", "none");
            $('.col_'+prec).css("color", "black");
            prec = $("#date").val();
        });
        $("#jirama").on("change", function(){
            $('.col_'+$("#jirama").val()).css("background", "#E1A624");
            $('.colu_'+$("#jirama").val()).css("background", "#dfc69c");
            $('.col_'+$("#jirama").val()).css("color", "white");
            $('.col_'+prec1).css("background", "none");
            $('.colu_'+prec1).css("background", "none");
            $('.col_'+prec1).css("color", "black");
            prec1 = $("#jirama").val();
        });
        $("#panneaux").on("change", function(){
            $('.col_'+$("#panneaux").val()).css("background", "#317AC1");
            $('.col_'+$("#panneaux").val()).css("color", "white");
            $('.colu_'+$("#panneaux").val()).css("background", "#e0f5ff");
            $('.col_'+prec2).css("background", "none");
            $('.colu_'+prec2).css("background", "none");
            $('.col_'+prec2).css("color", "black");
            prec2 = $("#panneaux").val();
        });

        setInterval(function(){
            $('.er').hide();
        }, 4000);

        var count = 0;
        $(".choice").on("submit", function(e){
            if($('#date').val() == $('#jirama').val() || 
            $('#date').val() == $('#panneaux').val() ||
            $('#jirama').val() == $('#panneaux').val()) {
                e.preventDefault();
                console.log("Try:"+count);
                count++;
                $('.er').show();
                if(count>42){
                    $('.er').text("Serieusement, ceci est un outil serieux, ne faites pas l'imbécile!");
                } if(count>100){
                    $('.er').text("Rafraichissez la page si vous voulez continuer!");
                    window.open("https://www.youtube.com/watch?v=W-fFHeTX70Q&pp=ygUIYmV0aG92ZW4%3D");
                }
            } else {
                e.submit();
            }
        });
    });
</script>