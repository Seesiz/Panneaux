<div class="content col-12">
    <div class="start col-8 bg-white d-flex justify-content-evenly">
        <img src="<?php echo base_url("assets/img/background.jpeg"); ?>" class="col-9" height="100%" width="100%">
        <h4 class="p-5 d-none d-md-block"> <b style="width: 100%">Bienvenue.</b> </h2>
        <div class="begin col-12">
            <h5 class="start-btn">COMMENCER</h5>
        </div>
    </div>

    <div class="close"></div>
    
    <div class="upload-file col-md-4">
        <h4><b class="color-primary">Pour commencer</b>, choisisez:</h4>
        <form action="<?php echo site_url("Accueil/start"); ?>" method="post" enctype="multipart/form-data">
            <div class="form-start">
                <label for="file">Vos fichier: (9 fichiers max)</label>
                <div class="input-group mb-3">
                    <input type="file" class="form-control" id="file1" name="file[]" multiple required>
                    <label class="input-group-text" for="file1">.xlsx</label>
                </div>
                <label for="PU">PU JIRAMA:</label>
                <div class="input-group mb-3">
                    <input type="number" class="form-control" id="PU" name="PU" value=<?= ($this->session->jirama) ? $this->session->jirama : 0 ?> min=0 required>
                    <label class="input-group-text" for="PU">Ar</label>
                </div>
            </div>
            <input type="submit" class="btn btn-primary col-12" style="margin-top: 10px" name="start" value="Continuer">
        </form>
    </div>
</div>

<script>
    $(document).ready(function(){
        var i = 2; 
        $(".start-btn").click(function(){
            $('.upload-file').css("display", "initial");
            $('.close').css("display", "inherit");
        });
        $(".close").click(function(){
            $('.upload-file').css("display", "none");
            $('.close').css("display", "none");
        });
    });

</script>