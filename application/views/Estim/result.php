<style>
    body{
        background-color: #e8eaff;
    }
    h5, th{
        color: #317AC1;
    }
    td, th{
        font-size: 20px;
    }
    li{
        list-style: none;
    }
</style>

<?php 
    $goal = 16039032;
    $sumPV=0;
    $sumJI=0;
    $color = [];
    $color[] = "#08c5d1";
    $color[] = "#EEE6D8";
    $color[] = "#DAAB3A";
    $color[] = "#B67332";
    $color[] = "#93441A";
    $color[] = "#1E0F1C";
    $color[] = "#A7001E";
    $color[] = "#E2E9C0";
    $color[] = "#7AA95C";
    $color[] = "#955149";
    $color[] = "#CA3C66";
    $color[] = "#DB6A8F";
?>
<?php if(count($invalid)>0){ ?>
<div class="position-absolute error col-12 d-flex justify-content-evenly m-4" style="z-index: 10;">
    <div class="alert er alert-danger col-5 text-center" role="alert">
        Les dates suivant sont déja dans la base:
        <ul>
            <?php foreach($invalid as $list){?>
                <li><?php echo $list ?></li>
            <?php } ?>
        </ul>
    </div>
</div>
<?php } ?>

<h1 class="position-relative p-3"><b class="color-primary">Finalement</b>, voici les resultats:</h1>

<div class="content-result">
    <div class="d-block col-9">
        <h3 class="col-12 text-center">Liste des données journalières:</h3>
        <div class="col-12 consom" style="height: 0vh; overflow-y: scroll">
            <table class="table table-hover table-striped bg-white">
                <thead>
                    <tr>
                        <th scope="col">Date</th>
                        <th scope="col">Consommation PV</th>
                        <th scope="col">Consommation JIRAMA</th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($date as $row){
                        $sumPV+=$row["PV"];
                        $sumJI+=$row["JI"];
                        ?>
                        <tr class="row_<?php echo $row['id'] ?>">
                            <td><?php echo date('j/M/Y', strtotime($row['date']))?></td>
                            <td><?php echo $row["PV"]." KW (".($row["PV"]*$this->session->jirama)." Ar)"?></td>
                            <td><?php echo $row["JI"]." KW (".($row["JI"]*$this->session->jirama)." Ar)"?></td>
                            <td><button type="button" class="delete btn btn-danger" data-id="<?php echo $row['id']?>"><i class="fa fa-trash" style="color: white"></i></button></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
        <button class="btn btn-secondary col-12 afficher"><i class="fa fa-eye" style="color: white"></i></button>

        <h3 class="col-12 text-center">Liste des données menstruelles:</h3>
        <div class="col-12 consomM" style="height: 0vh; overflow-y: scroll">
            <table class="table table-hover table-striped bg-white">
                <thead>
                    <tr>
                        <th scope="col">Date</th>
                        <th scope="col">Consommation PV</th>
                        <th scope="col">Consommation JIRAMA</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($byMonth as $row){?>
                        <tr class="row_<?php echo $row['id'] ?>">
                            <td><?php echo date('M/Y', strtotime('23-'.$row['mois'].'-'.$row['annee']))?></td>
                            <td><?php echo $row["pv"]." KW (".($row["pv"]*$this->session->jirama)." Ar)"?></td>
                            <td><?php echo $row["ji"]." KW (".($row["ji"]*$this->session->jirama)." Ar)"?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
        <button class="btn btn-secondary col-12 afficher1"><i class="fa fa-eye" style="color: white"></i></button>

        <div class="result col-12 justify-content-evenly mt-3">
            <h3 class="col-12 text-center">Resultat:</h3>
            <div class="col-12 d-md-flex d-grid justify-content-evenly mb-3">
                <span class="box-result"><div class="box-value"><h5>Durée des données</h5><p class="duree"><?php echo sizeof($date)." j" ?></p></div></span>
                <span class="box-result"><div class="box-value"><h5>Jirama</h5><p><?php echo $sumJI." KW" ?></p></div></span>
                <span class="box-result"><div class="box-value"><h5>Panneaux</h5><p><?php echo $sumPV." KW" ?></p></div></span>
            </div>
            <h3 class="col-12 text-center mb-1">Retour sur investissement:</h3>
            <div class="progress">
                <?php 
                $i = 0;
                $width = 0;
                $lastWidth = 0;
                foreach($byMonth as $row){
                    $width = ((($row['pv']*$this->session->jirama)+($row['ji']*$this->session->jirama)) * 100)/$goal;
                    ?>
                    <div class="progress-bar" role="progressbar" style="background: <?php echo $color[$i]?>; width: <?php echo $width?>%" aria-valuenow="<?php echo $color[$i]?>" aria-valuemin="0" aria-valuemax="100" data-toggle="tooltip" data-placement="top" title="<?php echo date('M/Y', strtotime('23-'.$row['mois'].'-'.$row['annee']))?>"></div>
                <?php  
                $i++;
                if($i == count($color)-1){
                    $i = 0; 
                }
                } ?>
            </div>
        </div>
        <a href="<?php echo site_url("Accueil") ?>"><button class="btn btn-primary col-12 col-md-1 mt-3" style="float: right"><i class="fa fa-arrow-rotate-right" style="color: white"></i></button></a>
    </div>
</div>
<script>
    $(document).ready(function(){
        var show =false;
        var showM =false;
        setInterval(function(){
            $('.er').hide();
        }, 4000);
    
        $('.afficher').on("click", function(){
            if(!show){
                $('.consom').css("height","30vh");
                show = true;
                $(this).html('<i class="fa fa-eye-slash" style="color: white"></i>');
            } else{
                $('.consom').css("height","0vh");
                show = false;
                $(this).html('<i class="fa fa-eye" style="color: white"></i>');
            }
        });
        $('.afficher1').on("click", function(){
            if(!showM){
                $('.consomM').css("height","30vh");
                showM = true;
                $(this).html('<i class="fa fa-eye-slash" style="color: white"></i>');
            } else{
                $('.consomM').css("height","0vh");
                showM = false;
                $(this).html('<i class="fa fa-eye" style="color: white"></i>');
            }
        });
        $('.delete').on("click", function() {
        var clickedButton = $(this);
    
        $.ajax({
            url: "<?php echo site_url('Estimation/delete')?>",
            method: "GET",
            data: {id: clickedButton.data("id")},
            success: function(data) {
                $(".row_" + clickedButton.data("id")).remove();
                $(".duree").html((parseInt($('.duree').text())-1)+" j");
            },
            error: function() {
                alert("Une erreur s'est produite lors de la requête.");
            }
        });
    })

});
</script>


