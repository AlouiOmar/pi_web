function rech() {

        var rech=$('#rech').val();

        if(rech.length==0){
            console.log('chaine vide');
        }else{
            console.log(rech);
            document.location = 'http://localhost/pi/web/app_dev.php/annonce/recherche/'.concat(rech);

        }
    }