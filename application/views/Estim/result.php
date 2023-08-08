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

<h1 class="position-absolute p-3"><b class="color-primary">Finalement</b>, voici les resultats:</h1>

<div class="content">
    <div class="d-block col-9">
        <h3 class="col-12 text-center">Liste des données journalières:</h3>
        <div class="col-12" style="height: 40vh; overflow-y: scroll">
            <table class="table table-hover table-striped bg-white">
                <thead>
                    <tr>
                        <th scope="col">Date</th>
                        <th scope="col">Consommation en moyenne PV</th>
                        <th scope="col">Consommation en moyenne JIRAMA</th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($date as $row){?>
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
        <div class="result col-11 g-2 justify-content-evenly m-5">
            <h3 class="col-12 text-center">Resultat:</h3>
            <div class="col-12 d-flex justify-content-evenly">
                <span class="box-result"><div class="box-value"><h5>Durée des données</h5><p><?php echo sizeof($date)." j" ?></p></div></span>
                <span class="box-result"><div class="box-value"><h5>Jirama</h5><p><?php echo $sumJI." W" ?></p></div></span>
                <span class="box-result"><div class="box-value"><h5>Panneaux</h5><p><?php echo $sumPV." W" ?></p></div></span>
                <span class="box-result"><div class="box-value"><h5>Retour sur investissement</h5><p><?php echo $sumJI ?></p></div></span>
            </div>
        </div>
    </div>
</div>
<script>
    setInterval(function(){
        $('.er').hide();
    }, 4000);
    $('.delete').on("click", function() {
    var clickedButton = $(this);

    $.ajax({
        url: "<?php echo site_url('Estimation/delete')?>",
        method: "GET",
        data: {id: clickedButton.data("id")},
        success: function(data) {
            $(".row_" + clickedButton.data("id")).remove();
        },
        error: function() {
            alert("Une erreur s'est produite lors de la requête.");
        }
    });
});
</script>


