<div class="container col-12">
    <div class="start col-7">
        <img src="<?php echo base_url("assets/img/background.jpeg"); ?>" height="100%">
        <h4 class="p-5"> <b>Bienvenue.</b> </h2>
        <div class="begin">
            <h5 class="start-btn">COMMENCER</h5>
        </div>
    </div>

    <div class="close"></div>
    
    <div class="upload-file col-4">
        <h4><b class="color-primary">Pour commencer</b>, choisisez:</h4>
        <form action="<?php echo site_url("Accueil/start"); ?>" method="post" enctype="multipart/form-data">
            <div class="form-start">
                <label for="file">Votre fichier:</label>
                <div class="input-group mb-3">
                    <input type="file" class="form-control" id="file" name="file" required>
                    <label class="input-group-text" for="file">.xlsx</label>
                </div>
                <label for="PU">PU JIRAMA:</label>
                <div class="input-group mb-3">
                    <input type="number" class="form-control" id="PU" name="PU" value=0 min=0 required>
                    <label class="input-group-text" for="PU">Ar</label>
                </div>
            </div>
            <button class="btn btn-primary col-12" style="margin-top: 10px" value="start">Continuer</button>
        </form>
    </div>
</div>

<script>
    $(document).ready(function(){
        $(".start-btn").click(function(){
            $('.upload-file').css("display", "initial");
            $('.close').css("display", "inherit");
        });
        $(".close").click(function(){
            $('.upload-file').css("display", "none");
            $('.close').css("display", "none");
        })
    });
</script>