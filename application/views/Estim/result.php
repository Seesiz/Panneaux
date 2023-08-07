<style>
    body{
        background-color: #e8eaff;
    }
    h5{
        color: #5661C3;
    }
</style>
<h3 class="position-absolute p-3"><b class="color-primary">Finalement</b>, voici les resultats:</h3>

<div class="content">
    <div class="d-block col-9">
        <div class="result col-11 g-2 justify-content-evenly m-5">
            <h3 class="col-12 text-center">Resultat des données que vous avez inserer:</h3>
            <div class="col-12 d-flex justify-content-evenly">
                <span class="box-result"><div class="box-value"><h5>Durée des données</h5><p><?php echo sizeof($date)." j" ?></p></div></span>
                <span class="box-result"><div class="box-value"><h5>Jirama</h5><p><?php echo $sumJI." W" ?></p></div></span>
                <span class="box-result"><div class="box-value"><h5>Panneaux</h5><p><?php echo $sumPV." W" ?></p></div></span>
                <span class="box-result"><div class="box-value"><h5>Retour sur investissement</h5><p><?php echo $sumJI ?></p></div></span>
            </div>
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

